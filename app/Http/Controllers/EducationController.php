<?php

namespace App\Http\Controllers;

use App\Models\EducationContent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EducationController extends Controller
{
    public function perawat()
    {
        return redirect()->route('public.booklet', 'perawat');
    }

    public function keluarga()
    {
        return redirect()->route('public.booklet', 'keluarga');
    }

    public function show(EducationContent $educationContent)
    {
        if ($educationContent->status !== 'published' && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('education.show', compact('educationContent'));
    }

    public function manage(Request $request)
    {
        $this->ensureAdmin();

        $search = $request->get('search');
        $target = $request->get('target');

        $contents = EducationContent::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($target, function ($query) use ($target) {
                $query->where('target', $target);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('education.manage', compact('contents', 'search', 'target'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('education.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'target' => ['required', Rule::in(['perawat', 'keluarga'])],
            'category' => ['nullable', 'string', 'max:150'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);

        $validated['created_by'] = auth()->id();

        EducationContent::create($validated);

        return redirect()
            ->route('education.manage')
            ->with('success', 'Materi edukasi berhasil ditambahkan.');
    }

    public function edit(EducationContent $educationContent)
    {
        $this->ensureAdmin();

        return view('education.edit', compact('educationContent'));
    }

    public function update(Request $request, EducationContent $educationContent)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'target' => ['required', Rule::in(['perawat', 'keluarga'])],
            'category' => ['nullable', 'string', 'max:150'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);

        $educationContent->update($validated);

        return redirect()
            ->route('education.manage')
            ->with('success', 'Materi edukasi berhasil diperbarui.');
    }

    public function destroy(EducationContent $educationContent)
    {
        $this->ensureAdmin();

        $educationContent->delete();

        return redirect()
            ->route('education.manage')
            ->with('success', 'Materi edukasi berhasil dihapus.');
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }
}
