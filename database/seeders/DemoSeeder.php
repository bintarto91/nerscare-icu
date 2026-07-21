<?php

namespace Database\Seeders;

use App\Models\AssessmentQuestion;
use App\Models\EducationContent;
use App\Models\User;
use App\Support\DeJongGierveldScale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Admin Penelitian',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'unit_kerja' => 'ICU',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'perawat@demo.com'],
            [
                'name' => 'Perawat ICU',
                'password' => Hash::make('password'),
                'role' => 'perawat',
                'unit_kerja' => 'ICU',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'keluarga@demo.com'],
            [
                'name' => 'Keluarga Pasien',
                'password' => Hash::make('password'),
                'role' => 'keluarga',
                'unit_kerja' => null,
                'is_active' => true,
            ]
        );

        foreach (DeJongGierveldScale::questions() as $sortOrder => $question) {
            AssessmentQuestion::updateOrCreate(
                ['sort_order' => $sortOrder],
                [
                    'question_text' => $question,
                    'is_active' => true,
                ]
            );
        }

        EducationContent::updateOrCreate(
            ['title' => 'Pengertian Loneliness pada Pasien ICU'],
            [
                'target' => 'perawat',
                'category' => 'Dasar',
                'content' => 'Loneliness pada pasien ICU adalah kondisi ketika pasien merasa sendiri, terisolasi, atau kurang mendapatkan dukungan emosional selama perawatan intensif. Perawat dapat membantu dengan komunikasi terapeutik, validasi emosi pasien, serta kolaborasi dengan keluarga.',
                'status' => 'published',
            ]
        );

        EducationContent::updateOrCreate(
            ['title' => 'Dukungan Emosional Keluarga'],
            [
                'target' => 'keluarga',
                'category' => 'Dukungan',
                'content' => 'Keluarga dapat memberikan dukungan dengan menyapa pasien secara lembut, memberikan kalimat positif, mengingatkan bahwa pasien tidak sendiri, dan mengikuti arahan perawat saat berkomunikasi.',
                'status' => 'published',
            ]
        );
    }
}
