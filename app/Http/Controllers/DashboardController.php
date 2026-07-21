<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\EducationContent;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $assessmentTable = 'assessments';

        $categoryColumn = collect([
            'kategori_loneliness',
            'kategori',
            'category',
            'loneliness_category',
            'hasil_kategori',
        ])->first(function ($column) use ($assessmentTable) {
            return Schema::hasColumn($assessmentTable, $column);
        });

        $scoreColumn = collect([
            'total_score',
            'total_skor',
            'score',
            'skor',
            'loneliness_score',
        ])->first(function ($column) use ($assessmentTable) {
            return Schema::hasColumn($assessmentTable, $column);
        });

        $categoryCounts = collect();

        if ($categoryColumn) {
            $categoryCounts = Assessment::query()
                ->select($categoryColumn, DB::raw('COUNT(*) as total'))
                ->whereNotNull($categoryColumn)
                ->groupBy($categoryColumn)
                ->orderByDesc('total')
                ->pluck('total', $categoryColumn);
        }

        $latestAssessments = Assessment::with('patient')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($assessment) use ($categoryColumn, $scoreColumn) {
                return [
                    'id' => $assessment->id,
                    'patient_code' => $assessment->patient->kode_pasien ?? '-',
                    'patient_name' => $assessment->patient->nama_inisial ?? '-',
                    'score' => $scoreColumn ? $assessment->{$scoreColumn} : null,
                    'category' => $categoryColumn ? $assessment->{$categoryColumn} : null,
                    'date' => $assessment->created_at,
                ];
            });

        $latestPatients = Patient::latest()
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalPatients' => Patient::count(),
            'totalAssessments' => Assessment::count(),
            'totalQuestions' => AssessmentQuestion::count(),
            'totalEducation' => EducationContent::where('status', 'published')->count(),
            'latestAssessments' => $latestAssessments,
            'latestPatients' => $latestPatients,
            'categoryCounts' => $categoryCounts,
            'categoryColumn' => $categoryColumn,
            'scoreColumn' => $scoreColumn,
        ]);
    }
}