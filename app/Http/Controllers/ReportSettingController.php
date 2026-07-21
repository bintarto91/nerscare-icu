<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ReportSettingController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();

        $settings = SiteSetting::getReportSettings();

        return view('report_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'report_institution_name' => ['required', 'string', 'max:255'],
            'report_app_name' => ['required', 'string', 'max:255'],
            'report_title' => ['required', 'string', 'max:255'],
            'report_subtitle' => ['required', 'string', 'max:255'],
            'report_unit_name' => ['nullable', 'string', 'max:255'],
            'report_left_signature_label' => ['required', 'string', 'max:255'],
            'report_right_signature_label' => ['required', 'string', 'max:255'],
            'report_right_signature_name' => ['nullable', 'string', 'max:255'],
            'report_clinical_note' => ['required', 'string'],
            'report_footer_text' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()
            ->route('report-settings.index')
            ->with('success', 'Pengaturan laporan berhasil diperbarui.');
    }

    private function ensureAdmin(): void
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }
    }
}