<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureClinicalUser();
        
        $search = $request->get('search');

        $patients = Patient::query()
            ->when($search, function ($query) use ($search) {
                $query->where('kode_pasien', 'like', "%{$search}%")
                    ->orWhere('nama_inisial', 'like', "%{$search}%")
                    ->orWhere('diagnosis_medis_utama', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        $this->ensureClinicalUser();
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $this->ensureClinicalUser();

        $validated = $request->validate([
            'kode_pasien' => ['required', 'string', 'max:100', 'unique:patients,kode_pasien'],
            'nama_inisial' => ['required', 'string', 'max:150'],
            'usia' => ['required', 'integer', 'min:1', 'max:120'],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'tanggal_masuk_icu' => ['nullable', 'date'],
            'diagnosis_medis_utama' => ['nullable', 'string', 'max:255'],
            'status_kesadaran' => ['nullable', 'string', 'max:255'],
            'kemampuan_komunikasi' => ['nullable', 'string', 'max:255'],
            'nama_perawat_pengisi' => ['nullable', 'string', 'max:150'],
            'tanggal_pengisian' => ['nullable', 'date'],
        ]);

        $validated['sadar'] = $request->has('sadar');
        $validated['mampu_berkomunikasi'] = $request->has('mampu_berkomunikasi');
        $validated['memahami_pertanyaan'] = $request->has('memahami_pertanyaan');
        $validated['bersedia_assessment'] = $request->has('bersedia_assessment');
        $validated['created_by'] = auth()->id();

        Patient::create($validated);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show(Patient $patient)
    {
        $this->ensureClinicalUser();

        $patient->load('assessments');

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $this->ensureClinicalUser();

        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $this->ensureClinicalUser();

        $validated = $request->validate([
            'kode_pasien' => [
                'required',
                'string',
                'max:100',
                Rule::unique('patients', 'kode_pasien')->ignore($patient->id),
            ],
            'nama_inisial' => ['required', 'string', 'max:150'],
            'usia' => ['required', 'integer', 'min:1', 'max:120'],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'tanggal_masuk_icu' => ['nullable', 'date'],
            'diagnosis_medis_utama' => ['nullable', 'string', 'max:255'],
            'status_kesadaran' => ['nullable', 'string', 'max:255'],
            'kemampuan_komunikasi' => ['nullable', 'string', 'max:255'],
            'nama_perawat_pengisi' => ['nullable', 'string', 'max:150'],
            'tanggal_pengisian' => ['nullable', 'date'],
        ]);

        $validated['sadar'] = $request->has('sadar');
        $validated['mampu_berkomunikasi'] = $request->has('mampu_berkomunikasi');
        $validated['memahami_pertanyaan'] = $request->has('memahami_pertanyaan');
        $validated['bersedia_assessment'] = $request->has('bersedia_assessment');

        $patient->update($validated);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $this->ensureClinicalUser();
        
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
    private function ensureClinicalUser(): void
    {
        if (auth()->user()->role === 'keluarga') {
            abort(403, 'Akses hanya untuk admin atau perawat.');
        }
    }
}