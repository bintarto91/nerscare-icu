<?php

namespace Tests\Feature;

use App\Models\BookletPage;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->app['config']->set('app.url', 'http://localhost');

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_landing_uses_the_two_final_booklets_and_revised_questionnaire_example(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Edukasi Perawat/Keluarga untuk Menurunkan Kesepian pada Pasien ICU')
            ->assertSee('Edukasi Keluarga untuk Menurunkan Kesepian pada Pasien ICU')
            ->assertSee('Edukasi Perawat untuk Menurunkan Kesepian pada Pasien ICU')
            ->assertSee('id="homeBook"', false)
            ->assertSee('data-home-audience="family"', false)
            ->assertSee('data-home-audience="nurse"', false)
            ->assertSee('STS')
            ->assertSee('SS')
            ->assertDontSee('Not lonely')
            ->assertDontSee('Halaman 5-6 dari 8');
    }

    public function test_public_booklet_reader_uses_a_responsive_flipbook_with_thumbnails(): void
    {
        $response = $this->get('/booklet/keluarga');

        $response
            ->assertOk()
            ->assertSee('Pilih halaman')
            ->assertSee('Sampul · klik untuk membuka')
            ->assertSee('booklets/keluarga/page-01.jpg', false)
            ->assertSee('id="flipbook"', false)
            ->assertSee('id="readerClosedCover"', false)
            ->assertSee('Flipbook manual')
            ->assertSee('turnPageNext', false)
            ->assertDontSee('Otomatis membuka halaman');
    }

    public function test_clinical_instrument_and_decision_matrix_are_read_only(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin/questions')
            ->assertOk()
            ->assertSee('Instrumen baku dan baca-saja')
            ->assertSee('KL, S, atau SS')
            ->assertDontSee('Tambah Pertanyaan');

        $this->actingAs($admin)
            ->get('/admin/interpretations')
            ->assertOk()
            ->assertSee('Matriks Keputusan AI')
            ->assertSee('Kode Keputusan VHB')
            ->assertDontSee('Tambah Pengaturan');

        $this->actingAs($admin)->get('/admin/questions/create')->assertNotFound();
        $this->actingAs($admin)->get('/admin/interpretations/create')->assertNotFound();
    }

    public function test_admin_can_manage_booklet_settings_without_editing_code(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin/booklet-pages')
            ->assertOk()
            ->assertSee('Kelola Booklet')
            ->assertSee('Auto-flip (detik)')
            ->assertSee('Buka PDF yang sedang aktif');

        $this->actingAs($admin)->put('/admin/booklet-settings', [
            'booklet_section_kicker' => 'Materi edukasi',
            'booklet_section_title' => 'Judul booklet dari admin',
            'booklet_section_description' => 'Deskripsi booklet dari admin.',
            'booklet_clinical_note' => 'Catatan klinis dari admin.',
            'booklet_reader_note' => 'Catatan pembaca dari admin.',
            'booklet_autoplay_seconds' => 5,
            'booklet_family_title' => 'Booklet keluarga dari admin',
            'booklet_family_description' => 'Deskripsi keluarga.',
            'booklet_nurse_title' => 'Booklet perawat dari admin',
            'booklet_nurse_description' => 'Deskripsi perawat.',
        ])->assertRedirect('/admin/booklet-pages');

        $this->assertSame('5', SiteSetting::getValue('booklet_autoplay_seconds'));
        $this->get('/')
            ->assertOk()
            ->assertSee('Judul booklet dari admin')
            ->assertSee('const homeAutoplayMilliseconds = 5000;', false);
    }

    public function test_admin_can_upload_a_booklet_page_and_public_reader_uses_it(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/admin/booklet-pages', [
            'audience' => 'keluarga',
            'image' => UploadedFile::fake()->image('halaman-baru.jpg', 1190, 1684),
            'kicker' => 'Halaman 11',
            'title' => 'Halaman tambahan',
            'alt_text' => 'Halaman tambahan booklet keluarga',
            'body' => 'Catatan untuk pengelola.',
            'sort_order' => 11,
            'is_active' => 1,
        ])->assertRedirect('/admin/booklet-pages?audience=keluarga');

        $page = BookletPage::where('title', 'Halaman tambahan')->firstOrFail();
        Storage::disk('public')->assertExists(substr($page->image_path, strlen('storage/')));
        $this->get('/booklet/keluarga')
            ->assertOk()
            ->assertSee($page->image_path, false)
            ->assertSee('11 halaman')
            ->assertSee('Sampul · klik untuk membuka');
    }

    public function test_non_admin_cannot_manage_booklets(): void
    {
        $user = User::factory()->create(['role' => 'perawat']);

        $this->actingAs($user)->get('/admin/booklet-pages')->assertForbidden();
    }
}
