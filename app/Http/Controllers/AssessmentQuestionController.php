<?php

namespace App\Http\Controllers;

use App\Models\AssessmentQuestion;
use Illuminate\Http\Request;

class AssessmentQuestionController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $search = $request->get('search');
        $status = $request->get('status');

        $questions = AssessmentQuestion::query()
            ->when($search, function ($query) use ($search) {
                $query->where('question_text', 'like', "%{$search}%");
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', (bool) $status);
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('assessment_questions.index', compact('questions', 'search', 'status'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $nextOrder = (AssessmentQuestion::max('sort_order') ?? 0) + 1;

        return view('assessment_questions.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'question_text' => ['required', 'string'],
            'sort_order' => ['required', 'integer', 'min:1'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        AssessmentQuestion::create($validated);

        return redirect()
            ->route('questions.index')
            ->with('success', 'Pertanyaan assessment berhasil ditambahkan.');
    }

    public function edit(AssessmentQuestion $question)
    {
        $this->ensureAdmin();

        return view('assessment_questions.edit', compact('question'));
    }

    public function update(Request $request, AssessmentQuestion $question)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'question_text' => ['required', 'string'],
            'sort_order' => ['required', 'integer', 'min:1'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $question->update($validated);

        return redirect()
            ->route('questions.index')
            ->with('success', 'Pertanyaan assessment berhasil diperbarui.');
    }

    public function destroy(AssessmentQuestion $question)
    {
        $this->ensureAdmin();

        $question->delete();

        return redirect()
            ->route('questions.index')
            ->with('success', 'Pertanyaan assessment berhasil dihapus.');
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }
}