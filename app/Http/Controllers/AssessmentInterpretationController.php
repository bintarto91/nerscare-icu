<?php

namespace App\Http\Controllers;

use App\Models\AssessmentInterpretation;
use Illuminate\Http\Request;

class AssessmentInterpretationController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $search = $request->get('search');

        $interpretations = AssessmentInterpretation::query()
            ->when($search, function ($query) use ($search) {
                $query->where('category', 'like', "%{$search}%")
                    ->orWhere('interpretation', 'like', "%{$search}%")
                    ->orWhere('nursing_recommendation', 'like', "%{$search}%")
                    ->orWhere('family_education_recommendation', 'like', "%{$search}%");
            })
            ->orderBy('sort_order')
            ->orderBy('min_score')
            ->paginate(10)
            ->withQueryString();

        return view('assessment_interpretations.index', compact('interpretations', 'search'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('assessment_interpretations.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $this->validateData($request);

        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = auth()->id();

        AssessmentInterpretation::create($validated);

        return redirect()
            ->route('interpretations.index')
            ->with('success', 'Pengaturan interpretasi berhasil ditambahkan.');
    }

    public function edit(AssessmentInterpretation $interpretation)
    {
        $this->ensureAdmin();

        return view('assessment_interpretations.edit', compact('interpretation'));
    }

    public function update(Request $request, AssessmentInterpretation $interpretation)
    {
        $this->ensureAdmin();

        $validated = $this->validateData($request);

        $validated['is_active'] = $request->has('is_active');

        $interpretation->update($validated);

        return redirect()
            ->route('interpretations.index')
            ->with('success', 'Pengaturan interpretasi berhasil diperbarui.');
    }

    public function destroy(AssessmentInterpretation $interpretation)
    {
        $this->ensureAdmin();

        $interpretation->delete();

        return redirect()
            ->route('interpretations.index')
            ->with('success', 'Pengaturan interpretasi berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'category' => ['required', 'string', 'max:100'],
            'min_score' => ['required', 'integer', 'min:0'],
            'max_score' => ['required', 'integer', 'gte:min_score'],
            'interpretation' => ['required', 'string'],
            'nursing_recommendation' => ['required', 'string'],
            'family_education_recommendation' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }
}