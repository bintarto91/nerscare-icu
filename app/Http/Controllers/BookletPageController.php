<?php

namespace App\Http\Controllers;

use App\Models\BookletPage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookletPageController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $search = $request->string('search')->toString();
        $status = $request->get('status');
        $audience = $request->get('audience');

        $pages = BookletPage::query()
            ->when(in_array($audience, ['keluarga', 'perawat'], true), fn ($query) => $query->where('audience', $audience))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%")
                        ->orWhere('kicker', 'like', "%{$search}%")
                        ->orWhere('alt_text', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', fn ($query) => $query->where('is_active', (bool) $status))
            ->orderBy('audience')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(20)
            ->withQueryString();

        return view('booklet_pages.index', [
            'pages' => $pages,
            'settings' => SiteSetting::getBookletSettings(),
            'search' => $search,
            'status' => $status,
            'audience' => $audience,
        ]);
    }

    public function create(Request $request)
    {
        $this->ensureAdmin();

        $audience = in_array($request->get('audience'), ['keluarga', 'perawat'], true)
            ? $request->get('audience')
            : 'keluarga';
        $nextOrder = (BookletPage::where('audience', $audience)->max('sort_order') ?? 0) + 1;

        return view('booklet_pages.create', compact('nextOrder', 'audience'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $this->validatedPageData($request, true);
        $data['image_path'] = $this->storePageImage($request, $data['audience']);
        BookletPage::create($data);

        return redirect()->route('booklet-pages.index', ['audience' => $data['audience']])
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

        $data = $this->validatedPageData($request, false);
        if ($request->hasFile('image')) {
            $this->deleteManagedFile($bookletPage->image_path);
            $data['image_path'] = $this->storePageImage($request, $data['audience']);
        }
        $bookletPage->update($data);

        return redirect()->route('booklet-pages.index', ['audience' => $data['audience']])
            ->with('success', 'Halaman booklet berhasil diperbarui.');
    }

    public function destroy(BookletPage $bookletPage)
    {
        $this->ensureAdmin();

        $audience = $bookletPage->audience;
        $this->deleteManagedFile($bookletPage->image_path);
        $bookletPage->delete();

        return redirect()->route('booklet-pages.index', ['audience' => $audience])
            ->with('success', 'Halaman booklet berhasil dihapus.');
    }

    public function updateSettings(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'booklet_section_kicker' => ['required', 'string', 'max:100'],
            'booklet_section_title' => ['required', 'string', 'max:255'],
            'booklet_section_description' => ['required', 'string', 'max:1000'],
            'booklet_clinical_note' => ['required', 'string', 'max:1000'],
            'booklet_reader_note' => ['required', 'string', 'max:1000'],
            'booklet_autoplay_seconds' => ['required', 'integer', 'min:1', 'max:30'],
            'booklet_family_title' => ['required', 'string', 'max:255'],
            'booklet_family_description' => ['required', 'string', 'max:1000'],
            'booklet_nurse_title' => ['required', 'string', 'max:255'],
            'booklet_nurse_description' => ['required', 'string', 'max:1000'],
            'booklet_family_pdf_upload' => ['nullable', 'file', 'mimes:pdf', 'max:30720'],
            'booklet_nurse_pdf_upload' => ['nullable', 'file', 'mimes:pdf', 'max:30720'],
        ]);

        $current = SiteSetting::getBookletSettings();
        foreach (['family', 'nurse'] as $role) {
            $uploadKey = "booklet_{$role}_pdf_upload";
            $settingKey = "booklet_{$role}_pdf";
            if ($request->hasFile($uploadKey)) {
                $this->deleteManagedFile($current[$settingKey]);
                $path = $request->file($uploadKey)->store('booklets/pdfs', 'public');
                $validated[$settingKey] = 'storage/'.$path;
            }
            unset($validated[$uploadKey]);
        }

        foreach ($validated as $key => $value) {
            SiteSetting::updateOrCreate(['setting_key' => $key], ['setting_value' => (string) $value]);
        }

        return redirect()->route('booklet-pages.index')
            ->with('success', 'Pengaturan booklet berhasil diperbarui dan langsung dipakai di web.');
    }

    private function validatedPageData(Request $request, bool $imageRequired): array
    {
        $validated = $request->validate([
            'audience' => ['required', Rule::in(['keluarga', 'perawat'])],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'kicker' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'alt_text' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:1000'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        unset($validated['image']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['points'] = null;

        return $validated;
    }

    private function storePageImage(Request $request, string $audience): string
    {
        $path = $request->file('image')->store("booklets/{$audience}/pages", 'public');

        return 'storage/'.$path;
    }

    private function deleteManagedFile(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }
}
