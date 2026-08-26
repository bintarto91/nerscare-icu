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
        $questions = AssessmentQuestion::query()
            ->whereBetween('sort_order', [1, 11])
            ->when($search, function ($query) use ($search) {
                $query->where('question_text', 'like', "%{$search}%");
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(11)
            ->withQueryString();

        return view('assessment_questions.index', compact('questions', 'search'));
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }
}
