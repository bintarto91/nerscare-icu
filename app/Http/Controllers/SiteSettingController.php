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

        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:255'],
            'landing_badge' => ['nullable', 'string', 'max:255'],
            'landing_title' => ['required', 'string', 'max:255'],
            'landing_description' => ['required', 'string'],
            'landing_calculator_title' => ['required', 'string', 'max:255'],
            'landing_calculator_description' => ['required', 'string'],
            'clinical_disclaimer' => ['required', 'string'],
            'footer_text' => ['required', 'string', 'max:255'],
        ]);

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