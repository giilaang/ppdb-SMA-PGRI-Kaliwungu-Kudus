<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Major;
use App\Models\Registrant;
use App\Models\PpdbSetting;
use Illuminate\Support\Facades\Hash;

class AdminCmsTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $adminPpdb;
    protected User $editorContent;
    protected AcademicYear $academicYear;
    protected Major $major;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Seed Roles
        $this->superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@smapgrikaliwungu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
        ]);

        $this->adminPpdb = User::create([
            'name' => 'Admin PPDB',
            'email' => 'ppdb@smapgrikaliwungu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'admin_ppdb',
        ]);

        $this->editorContent = User::create([
            'name' => 'Editor Content',
            'email' => 'editor@smapgrikaliwungu.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'editor_content',
        ]);

        // 2. Seed Academic Year
        $this->academicYear = AcademicYear::create([
            'year' => '2026/2027',
            'is_active' => true,
            'is_archived' => false,
        ]);

        // 3. Seed Major
        $this->major = Major::create([
            'name' => 'MIPA',
            'slug' => 'mipa',
            'description' => 'Sains',
        ]);

        // 4. Seed PPDB Settings
        PpdbSetting::create([
            'academic_year_id' => $this->academicYear->id,
            'status' => 'open',
            'quota' => 120,
            'requirements_text' => 'Syarat...',
            'flow_text' => 'Alur...',
        ]);
    }

    public function test_login_screen_loads()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_valid_user_can_login()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@smapgrikaliwungu.sch.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->superAdmin);
    }

    public function test_invalid_user_cannot_login()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@smapgrikaliwungu.sch.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_super_admin_can_access_all_routes()
    {
        $this->actingAs($this->superAdmin);

        // Dashboard
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);

        // Academic Years
        $response = $this->get('/admin/tahun-ajaran');
        $response->assertStatus(200);

        // PPDB Settings
        $response = $this->get('/admin/ppdb-settings');
        $response->assertStatus(200);

        // PPDB Waves
        $response = $this->get('/admin/gelombang');
        $response->assertStatus(200);

        // Registrants
        $response = $this->get('/admin/pendaftar');
        $response->assertStatus(200);

        // Brochures
        $response = $this->get('/admin/brosur');
        $response->assertStatus(200);

        // Content management (Hero)
        $response = $this->get('/admin/hero');
        $response->assertStatus(200);

        // Profil Sekolah
        $response = $this->get('/admin/profil');
        $response->assertStatus(200);

        // Keunggulan
        $response = $this->get('/admin/keunggulan');
        $response->assertStatus(200);

        // Fasilitas
        $response = $this->get('/admin/fasilitas');
        $response->assertStatus(200);

        // Jurusan
        $response = $this->get('/admin/jurusan');
        $response->assertStatus(200);

        // Prestasi
        $response = $this->get('/admin/prestasi');
        $response->assertStatus(200);

        // Galeri
        $response = $this->get('/admin/galeri');
        $response->assertStatus(200);

        // Kontak
        $response = $this->get('/admin/kontak');
        $response->assertStatus(200);

        // Berita
        $response = $this->get('/admin/berita');
        $response->assertStatus(200);

        // Pengumuman
        $response = $this->get('/admin/pengumuman');
        $response->assertStatus(200);
    }

    public function test_editor_content_role_restrictions()
    {
        $this->actingAs($this->editorContent);

        // Can access dashboard
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);

        // Can access content management
        $response = $this->get('/admin/hero');
        $response->assertStatus(200);

        // Can access news and announcements
        $response = $this->get('/admin/berita');
        $response->assertStatus(200);
        $response = $this->get('/admin/pengumuman');
        $response->assertStatus(200);

        // CANNOT access Academic Years (Forbidden 403)
        $response = $this->get('/admin/tahun-ajaran');
        $response->assertStatus(403);

        // CANNOT access Registrants
        $response = $this->get('/admin/pendaftar');
        $response->assertStatus(403);
    }

    public function test_admin_ppdb_role_restrictions()
    {
        $this->actingAs($this->adminPpdb);

        // Can access dashboard
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);

        // Can access Registrants
        $response = $this->get('/admin/pendaftar');
        $response->assertStatus(200);

        // CANNOT access Academic Years
        $response = $this->get('/admin/tahun-ajaran');
        $response->assertStatus(403);

        // CANNOT access Content Management (Hero)
        $response = $this->get('/admin/hero');
        $response->assertStatus(403);

        // CANNOT access news and announcements
        $response = $this->get('/admin/berita');
        $response->assertStatus(403);
        $response = $this->get('/admin/pengumuman');
        $response->assertStatus(403);
    }

    public function test_registrant_verification_flow()
    {
        $this->actingAs($this->adminPpdb);

        // Create a registrant
        $registrant = Registrant::create([
            'academic_year_id' => $this->academicYear->id,
            'registration_number' => 'REG-2026-0001',
            'name' => 'Budi',
            'nisn' => '1122334455',
            'place_of_birth' => 'Kudus',
            'date_of_birth' => '2010-01-01',
            'gender' => 'L',
            'address' => 'Kaliwungu',
            'previous_school' => 'SMP N 1',
            'phone_number' => '08123',
            'parent_name' => 'Slamet',
            'selected_major_id' => $this->major->id,
            'status' => 'pending',
        ]);

        // Verify registrant
        $response = $this->patch("/admin/pendaftar/{$registrant->id}/verifikasi", [
            'status' => 'verified',
        ]);

        $response->assertRedirect(route('admin.registrants.show', $registrant->id));
        $this->assertEquals('verified', $registrant->fresh()->status);
    }

    public function test_news_crud_flow()
    {
        $this->actingAs($this->editorContent);

        // 1. Create news
        $response = $this->post('/admin/berita', [
            'title' => 'Berita Baru Hari Ini',
            'content' => 'Ini isi berita yang sangat menarik sekali.',
            'published_at' => '2026-06-03T12:00',
        ]);
        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', [
            'title' => 'Berita Baru Hari Ini',
            'slug' => 'berita-baru-hari-ini',
        ]);

        $newsItem = \App\Models\News::where('title', 'Berita Baru Hari Ini')->first();

        // 2. Update news
        $response = $this->patch("/admin/berita/{$newsItem->id}", [
            'title' => 'Berita Baru Terupdate',
            'content' => 'Ini isi berita yang sangat menarik sekali setelah diupdate.',
            'published_at' => '2026-06-03T13:00',
        ]);
        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', [
            'title' => 'Berita Baru Terupdate',
            'slug' => 'berita-baru-terupdate',
        ]);

        // 3. Delete news
        $response = $this->delete("/admin/berita/{$newsItem->id}");
        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseMissing('news', [
            'id' => $newsItem->id,
        ]);
    }

    public function test_announcements_crud_flow()
    {
        $this->actingAs($this->editorContent);

        // 1. Create announcement
        $response = $this->post('/admin/pengumuman', [
            'title' => 'Pengumuman Baru Hari Ini',
            'content' => 'Ini isi pengumuman yang sangat penting.',
            'published_at' => '2026-06-03T12:00',
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('admin.announcements.index'));
        $this->assertDatabaseHas('announcements', [
            'title' => 'Pengumuman Baru Hari Ini',
            'is_active' => true,
        ]);

        $annItem = \App\Models\Announcement::where('title', 'Pengumuman Baru Hari Ini')->first();

        // 2. Update announcement
        $response = $this->patch("/admin/pengumuman/{$annItem->id}", [
            'title' => 'Pengumuman Baru Terupdate',
            'content' => 'Ini isi pengumuman yang sangat penting setelah diupdate.',
            'published_at' => '2026-06-03T13:00',
            'is_active' => '0',
        ]);
        $response->assertRedirect(route('admin.announcements.index'));
        $this->assertDatabaseHas('announcements', [
            'title' => 'Pengumuman Baru Terupdate',
            'is_active' => false,
        ]);

        // 3. Delete announcement
        $response = $this->delete("/admin/pengumuman/{$annItem->id}");
        $response->assertRedirect(route('admin.announcements.index'));
        $this->assertDatabaseMissing('announcements', [
            'id' => $annItem->id,
        ]);
    }
}
