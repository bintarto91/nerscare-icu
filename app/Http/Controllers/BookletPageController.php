<?php

namespace App\Http\Controllers;

use App\Models\BookletPage;
use Illuminate\Http\Request;

class BookletPageController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $search = $request->get('search');
        $status = $request->get('status');

        $pages = BookletPage::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%")
                        ->orWhere('kicker', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', (bool) $status);
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('booklet_pages.index', compact('pages', 'search', 'status'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $nextOrder = (BookletPage::max('sort_order') ?? 0) + 1;

        return view('booklet_pages.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        BookletPage::create($this->validatedData($request));

        return redirect()
            ->route('booklet-pages.index')
            ->with('success', 'Halaman booklet berhasil ditambahkan.');
    }

    public function edit(BookletPage $bookletPage)
    {
        $this->ensureAdmin();

        return view('booklet_pages.edit', compact('bookletPage'));
    }

    public function update(Request $request, BookletPage $bookletPage)
    {
        $this->ensureAdmin();

        $bookletPage->update($this->validatedData($request));

        return redirect()
            ->route('booklet-pages.index')
            ->with('success', 'Halaman booklet berhasil diperbarui.');
    }

    public function destroy(BookletPage $bookletPage)
    {
        $this->ensureAdmin();

        $bookletPage->delete();

        return redirect()
            ->route('booklet-pages.index')
            ->with('success', 'Halaman booklet berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'kicker' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'points_text' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $points = collect(preg_split('/\r\n|\r|\n/', $validated['points_text'] ?? ''))
            ->map(fn ($point) => trim($point))
            ->filter()
            ->values()
            ->all();

        return [
            'kicker' => $validated['kicker'] ?? null,
            'title' => $validated['title'],
            'body' => $validated['body'],
            'points' => $points,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->boolean('is_active'),
        ];
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }
}
