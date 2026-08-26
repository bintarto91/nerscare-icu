<?php

namespace App\Http\Controllers;

use App\Support\DeJongGierveldScale;

class AssessmentInterpretationController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();

        $decisions = collect(DeJongGierveldScale::decisionOutputs())
            ->map(fn (array $output, string $code): array => array_merge(['code' => $code], $output))
            ->values();

        return view('assessment_interpretations.index', compact('decisions'));
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }
}
