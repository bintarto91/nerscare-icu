<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertSee('Pilih panduan sesuai peran Anda')
            ->assertSee('Edukasi Keluarga Pasien ICU')
            ->assertSee('Edukasi Perawat ICU')
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
            ->assertSee('Halaman 1 dari 10')
            ->assertSee('booklets/keluarga/page-01.jpg', false)
            ->assertSee('id="flipbook"', false)
            ->assertSee('Flipbook responsif')
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
}
