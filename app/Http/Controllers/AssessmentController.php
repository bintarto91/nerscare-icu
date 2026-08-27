<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestion;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Models\SiteSetting;
use App\Support\DeJongGierveldScale;

class AssessmentController extends Controller
{
    public function print(Assessment $assessment)
    {
        $this->ensureClinicalUser();

        $assessment->load(['patient', 'answers.question', 'user']);

        $reportSettings = SiteSetting::getReportSettings();

        return view('assessments.print', compact('assessment', 'reportSettings'));
    }
    
    public function selectPatient(Request $request)
    {
        $this->ensureClinicalUser();

        $search = $request->get('search');

        $patients = Patient::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($patientQuery) use ($search) {
                    $patientQuery->where('kode_pasien', 'like', "%{$search}%")
                        ->orWhere('nama_inisial', 'like', "%{$search}%")
                        ->orWhere('diagnosis_medis_utama', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('assessments.select-patient', compact('patients', 'search'));
    }
    public function index(Request $request)
    {
        $this->ensureClinicalUser();

        $search = $request->get('search');
        $category = $request->get('category');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $assessments = Assessment::with(['patient', 'answers.question', 'followUpUser'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->where('kode_pasien', 'like', "%{$search}%")
                        ->orWhere('nama_inisial', 'like', "%{$search}%")
                        ->orWhere('diagnosis_medis_utama', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('assessment_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('assessment_date', '<=', $dateTo);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('assessments.index', compact(
            'assessments',
            'search',
            'category',
            'dateFrom',
            'dateTo'
        ));
    }

    public function create(Patient $patient)
    {
        $this->ensureClinicalUser();

        $eligible = $patient->sadar
            && $patient->mampu_berkomunikasi
            && $patient->memahami_pertanyaan
            && $patient->bersedia_assessment;

        if (!$eligible) {
            return redirect()
                ->route('patients.show', $patient)
                ->withErrors('Pasien belum memenuhi syarat untuk dilakukan assessment.');
        }

        $questions = AssessmentQuestion::whereBetween('sort_order', [1, 11])
            ->orderBy('sort_order')
            ->get();

        return view('assessments.create', compact('patient', 'questions'));
    }

    public function store(Request $request, Patient $patient)
    {
        $this->ensureClinicalUser();

        $questions = AssessmentQuestion::whereBetween('sort_order', [1, 11])
            ->orderBy('sort_order')
            ->get();

        $rules = [
            'assessment_date' => ['required', 'date'],
            'administration_mode' => ['required', 'string', Rule::in(['mandiri', 'dibacakan'])],
            'answers' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
            'personalization_triggers' => ['nullable', 'array'],
            'personalization_triggers.*' => [
                'string',
                Rule::in(array_keys(DeJongGierveldScale::personalizationTriggers())),
            ],
            'safety_alerts' => ['nullable', 'array'],
            'safety_alerts.*' => [
                'string',
                Rule::in(array_keys(DeJongGierveldScale::safetyAlerts())),
            ],
            'safety_alert_notes' => ['nullable', 'string'],
        ];

        foreach ($questions as $question) {
            $rules['answers.' . $question->id] = ['nullable', 'integer', 'min:1', 'max:5'];
        }

        $validated = $request->validate($rules);

        $responsesByItem = [];

        foreach ($questions as $question) {
            $responsesByItem[(int) $question->sort_order] = $validated['answers'][$question->id] ?? null;
        }

        try {
            $result = DeJongGierveldScale::scoreResponses($responsesByItem);
        } catch (\InvalidArgumentException $exception) {
            throw ValidationException::withMessages([
                'answers' => $exception->getMessage(),
            ]);
        }

        $personalizationTriggers = array_values($validated['personalization_triggers'] ?? []);
        $safetyAlerts = array_values($validated['safety_alerts'] ?? []);
        $safetyAlertDetails = DeJongGierveldScale::selectedSafetyAlerts($safetyAlerts);

        $assessment = Assessment::create([
            'patient_id' => $patient->id,
            'user_id' => auth()->id(),
            'assessment_date' => $validated['assessment_date'],
            'administration_mode' => $validated['administration_mode'],
            'total_score' => $result['total_score'],
            'missing_item_count' => $result['missing_item_count'],
            'emotional_score' => $result['emotional_score'],
            'emotional_score_valid' => $result['emotional_score_valid'],
            'social_score' => $result['social_score'],
            'social_score_valid' => $result['social_score_valid'],
            'category' => $result['category'],
            'decision_code' => $result['code'],
            'decision_profile' => $result['profile'],
            'interpretation' => $result['interpretation'],
            'nursing_recommendation' => $result['nursing_recommendation'],
            'family_education_recommendation' => $result['family_education_recommendation'],
            'clinical_decision_note' => $result['clinical_decision_note'],
            'personalization_triggers' => $personalizationTriggers ?: null,
            'safety_alert' => $safetyAlertDetails !== [],
            'safety_alert_details' => $safetyAlertDetails ?: null,
            'safety_alert_notes' => $safetyAlertDetails !== []
                ? ($validated['safety_alert_notes'] ?? null)
                : null,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($questions as $question) {
            $scoredResponse = $result['scored_responses'][(int) $question->sort_order];
            $isMissing = $scoredResponse === null;
            $answerValue = $isMissing ? null : $scoredResponse['answer_value'];
            $score = $isMissing ? 0 : $scoredResponse['score'];

            AssessmentAnswer::create([
                'assessment_id' => $assessment->id,
                'assessment_question_id' => $question->id,
                'answer_text' => $isMissing ? 'Tidak diisi' : $this->scoreLabel($answerValue),
                'score' => $score,
                'is_missing' => $isMissing,
            ]);
        }

        return redirect()
            ->route('assessments.show', $assessment)
            ->with('success', 'Assessment berhasil disimpan.');
    }
    public function editFollowUp(Assessment $assessment)
    {
        $this->ensureClinicalUser();

        $assessment->load(['patient', 'user', 'followUpUser']);

        return view('assessments.follow-up', compact('assessment'));
    }

    public function updateFollowUp(Request $request, Assessment $assessment)
    {
        $this->ensureClinicalUser();

        $validated = $request->validate([
            'follow_up_status' => [
                'required',
                'string',
                'in:Belum Ditindaklanjuti,Sudah Edukasi Perawat,Sudah Edukasi Keluarga,Perlu Monitoring Ulang,Selesai',
            ],
            'follow_up_notes' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date'],
        ]);

        $assessment->update([
            'follow_up_status' => $validated['follow_up_status'],
            'follow_up_notes' => $validated['follow_up_notes'] ?? null,
            'follow_up_date' => $validated['follow_up_date'] ?? date('Y-m-d'),
            'follow_up_by' => auth()->id(),
        ]);

        return redirect()
            ->route('assessments.show', $assessment)
            ->with('success', 'Tindak lanjut assessment berhasil diperbarui.');
    }

    public function show(Assessment $assessment)
    {
        $this->ensureClinicalUser();

        $assessment->load(['patient', 'answers.question']);

        return view('assessments.show', compact('assessment'));
    }

    public function destroy(Assessment $assessment)
    {
        $this->ensureClinicalUser();

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hapus riwayat hanya dapat dilakukan oleh admin.');
        }

        $assessment->delete();

        return redirect()
            ->route('assessments.index')
            ->with('success', 'Riwayat assessment berhasil dihapus.');
    }

    private function scoreLabel(int $score): string
    {
        return DeJongGierveldScale::answerLabel($score);
    }

    private function ensureClinicalUser(): void
    {
        if (auth()->user()->role === 'keluarga') {
            abort(403, 'Akses assessment hanya untuk admin atau perawat.');
        }
    }
}
