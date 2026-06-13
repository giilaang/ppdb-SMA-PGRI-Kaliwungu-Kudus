<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Major;
use App\Models\PpdbSetting;
use App\Models\PpdbWave;
use App\Models\Registrant;

class PpdbTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed initial data for testing
        $academicYear = AcademicYear::create([
            'year' => '2026/2027',
            'is_active' => true,
            'is_archived' => false,
        ]);

        Major::create([
            'name' => 'MIPA',
            'slug' => 'mipa',
            'description' => 'Matematika dan Ilmu Pengetahuan Alam',
            'image_path' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=400',
        ]);

        PpdbSetting::create([
            'academic_year_id' => $academicYear->id,
            'status' => 'open',
            'quota' => 120,
            'requirements_text' => 'Persyaratan...',
            'flow_text' => 'Alur...',
            'fees_text' => 'Biaya...',
            'schedule_text' => 'Jadwal...',
        ]);

        PpdbWave::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Gelombang I',
            'start_date' => now()->subDays(5)->format('Y-m-d'),
            'end_date' => now()->addDays(5)->format('Y-m-d'),
            'is_active' => true,
        ]);
    }

    public function test_home_page_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SMA PGRI KALIWUNGU KUDUS');
        $response->assertSee('PPDB 2026/2027');
    }

    public function test_student_can_register_online()
    {
        $major = Major::first();

        $data = [
            'name' => 'Ahmad Dani',
            'nisn' => '1234567890',
            'place_of_birth' => 'Kudus',
            'date_of_birth' => '2010-05-15',
            'gender' => 'L',
            'address' => 'Kaliwungu, Kudus, RT 01 RW 02',
            'previous_school' => 'SMP N 1 Kaliwungu',
            'phone_number' => '081234567890',
            'parent_name' => 'Slamet',
            'selected_major_id' => $major->id,
        ];

        // Perform POST request
        $response = $this->post('/daftar', $data);

        // Verify redirect to receipt
        $registrant = Registrant::where('nisn', '1234567890')->first();
        $this->assertNotNull($registrant);
        
        $response->assertRedirect(route('receipt', $registrant->registration_number));

        // Verify database contains the record
        $this->assertDatabaseHas('registrants', [
            'nisn' => '1234567890',
            'name' => 'Ahmad Dani',
            'status' => 'pending',
        ]);
    }

    public function test_registration_validation_enforced()
    {
        $data = [
            'name' => '', // Empty name should fail
            'nisn' => '12345', // Short NISN should fail
            'place_of_birth' => 'Kudus',
        ];

        $response = $this->post('/daftar', $data);

        $response->assertSessionHasErrors(['name', 'nisn', 'date_of_birth']);
    }
}
