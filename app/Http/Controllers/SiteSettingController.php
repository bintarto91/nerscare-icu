<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();

        $settings = SiteSetting::getPublicSettings();

        return view('site_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->ensureAdmin();

        $rules = collect(SiteSetting::PUBLIC_DEFAULTS)
            ->mapWithKeys(fn (string $value, string $key) => [
                $key => ['required', 'string'],
            ])
            ->all();
        $rules['landing_badge'] = ['nullable', 'string', 'max:255'];

        $validated = $request->validate($rules);

        foreach ($validated as $key => $value) {
            SiteSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()
            ->route('site-settings.index')
            ->with('success', 'Pengaturan landing page berhasil diperbarui.');
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }
}
