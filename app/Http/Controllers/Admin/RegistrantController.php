<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Major;
use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrantController extends Controller
{
    public function index(Request $request)
    {
        $years = AcademicYear::orderBy('year', 'desc')->get();
        $majors = Major::all();

        // Get filters
        $selectedYearId = $request->get('academic_year_id');
        if (!$selectedYearId) {
            $activeYear = AcademicYear::where('is_active', true)->first();
            $selectedYearId = $activeYear ? $activeYear->id : ($years->first() ? $years->first()->id : null);
        }

        $selectedStatus = $request->get('status');
        $selectedMajorId = $request->get('major_id');
        $search = $request->get('search');

        // Query
        $query = Registrant::with(['academicYear', 'major']);

        if ($selectedYearId) {
            $query->where('academic_year_id', $selectedYearId);
        }
        if ($selectedStatus) {
            $query->where('status', $selectedStatus);
        }
        if ($selectedMajorId) {
            $query->where('selected_major_id', $selectedMajorId);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%")
                  ->orWhere('previous_school', 'like', "%{$search}%");
            });
        }

        $registrants = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.registrants.index', compact(
            'years',
            'majors',
            'selectedYearId',
            'selectedStatus',
            'selectedMajorId',
            'search',
            'registrants'
        ));
    }

    public function show($id)
    {
        $registrant = Registrant::with(['academicYear', 'major'])->findOrFail($id);
        return view('admin.registrants.show', compact('registrant'));
    }

    public function verify(Request $request, $id)
    {
        $registrant = Registrant::findOrFail($id);

        $request->validate([
            'status' => 'required|in:verified,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        $registrant->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
        ]);

        $statusLabel = $request->status === 'verified' ? 'Diverifikasi' : 'Ditolak';
        return redirect()->route('admin.registrants.show', $registrant->id)
            ->with('success', "Pendaftar berhasil ditandai sebagai: {$statusLabel}.");
    }

    public function viewDocument($id, $type)
    {
        $registrant = Registrant::findOrFail($id);
        $filePath = null;

        switch ($type) {
            case 'ijazah':
                $filePath = $registrant->document_ijazah;
                break;
            case 'akta':
                $filePath = $registrant->document_akta;
                break;
            case 'kk':
                $filePath = $registrant->document_kk;
                break;
            case 'foto':
                $filePath = $registrant->document_foto;
                break;
        }

        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        $mimeType = Storage::disk('local')->mimeType($filePath);
        return response()->file(storage_path('app/private/' . $filePath), [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline'
        ]);
    }

    public function downloadDocument($id, $type)
    {
        $registrant = Registrant::findOrFail($id);
        $filePath = null;
        $fileName = null;

        switch ($type) {
            case 'ijazah':
                $filePath = $registrant->document_ijazah;
                $fileName = 'Ijazah_' . $registrant->name;
                break;
            case 'akta':
                $filePath = $registrant->document_akta;
                $fileName = 'Akta_Lahir_' . $registrant->name;
                break;
            case 'kk':
                $filePath = $registrant->document_kk;
                $fileName = 'KK_' . $registrant->name;
                break;
            case 'foto':
                $filePath = $registrant->document_foto;
                $fileName = 'Pas_Foto_' . $registrant->name;
                break;
        }

        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        return Storage::disk('local')->download($filePath, $fileName . '.' . $extension);
    }

    public function exportCsv(Request $request)
    {
        $selectedYearId = $request->get('academic_year_id');
        $selectedStatus = $request->get('status');
        $selectedMajorId = $request->get('major_id');
        $search = $request->get('search');

        $query = Registrant::with(['academicYear', 'major']);

        if ($selectedYearId) {
            $query->where('academic_year_id', $selectedYearId);
        }
        if ($selectedStatus) {
            $query->where('status', $selectedStatus);
        }
        if ($selectedMajorId) {
            $query->where('selected_major_id', $selectedMajorId);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        $registrants = $query->orderBy('created_at', 'desc')->get();
        $yearName = $selectedYearId ? AcademicYear::find($selectedYearId)->year : 'Semua_Tahun';
        $yearName = str_replace('/', '-', $yearName);

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=Pendaftar_PPDB_SMA_PGRI_Kaliwungu_{$yearName}.csv",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [
            'Nomor Pendaftaran', 'Nama Lengkap', 'NISN', 'Tempat Lahir', 'Tanggal Lahir', 
            'Jenis Kelamin', 'Alamat', 'Asal Sekolah', 'No. HP', 'Nama Orang Tua', 
            'Jurusan Pilihan', 'Status Verifikasi', 'Tanggal Daftar'
        ];

        $callback = function () use ($registrants, $columns) {
            $file = fopen('php://output', 'w');
            
            // Write UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns, ';');

            foreach ($registrants as $registrant) {
                fputcsv($file, [
                    $registrant->registration_number,
                    $registrant->name,
                    $registrant->nisn,
                    $registrant->place_of_birth,
                    $registrant->date_of_birth ? $registrant->date_of_birth->format('Y-m-d') : '',
                    $registrant->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                    $registrant->address,
                    $registrant->previous_school,
                    $registrant->phone_number,
                    $registrant->parent_name,
                    $registrant->major ? $registrant->major->name : '',
                    ucfirst($registrant->status),
                    $registrant->created_at ? $registrant->created_at->format('Y-m-d H:i:s') : '',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($id)
    {
        $registrant = Registrant::findOrFail($id);

        // Delete uploaded files safely
        if ($registrant->document_ijazah) {
            Storage::disk('local')->delete($registrant->document_ijazah);
        }
        if ($registrant->document_akta) {
            Storage::disk('local')->delete($registrant->document_akta);
        }
        if ($registrant->document_kk) {
            Storage::disk('local')->delete($registrant->document_kk);
        }
        if ($registrant->document_foto) {
            Storage::disk('local')->delete($registrant->document_foto);
        }

        $registrant->delete();

        return redirect()->route('admin.registrants.index')->with('success', 'Data pendaftar berhasil dihapus beserta seluruh berkasnya.');
    }
}
