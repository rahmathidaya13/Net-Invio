<?php

namespace App\Http\Controllers\Backup;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Helpers\TelegramNotification;

class BackupController extends Controller
{
    public function backup()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $fileName = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $folder = storage_path('app/backups');
        $storagePath = $folder . '/' . $fileName;

        // Pastikan folder ada
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $command = "mysqldump --user=$username --password=$password --host=$host $database > $storagePath";
        $result = null;
        $output = null;
        exec($command, $output, $result);
        if ($result !== 0 || !file_exists($storagePath)) {
            return back()->with('error', 'Backup gagal. Periksa mysqldump atau koneksi.');
        }
        TelegramNotification::sendOrFail("*Backup File Database*\n" .
            "Tanggal: *" . Carbon::now()->format('d-m-Y') . "*\n" .
            "File: *{$fileName}*\n" .
            "Status: *" . 'Berhasil' . "*\n" .
            "Created at: *" . auth()->user()->name . "*");

        return back()->with([
            'success' => 'Backup berhasil dibuat file ' . $fileName,
            'fileBackup' => $fileName,
        ]);
    }

    public function download($file)
    {
        $path = storage_path('app/backups' . $file);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function create()
    {
        return view('Home.BackupForm.form');
    }
    public function store(Request $request)
    {
        $request->validate([
            'restore' => 'required|file|mimetypes:text/plain,application/sql,text/x-sql,text/x-plain|max:5120',

        ], [
            'restore.required' => 'Pilih file backup yang ingin dipilih.',
            'restore.file' => 'File backup harus berupa file.',
            'restore.mimes' => 'File backup harus berupa file SQL.',
            'restore.max' => 'Ukuran file backup tidak boleh lebih dari 5MB.',
        ]);

        $files = $request->file('restore');
        $sql = File::get($files->getRealPath());
        try {
            DB::unprepared($sql);
            TelegramNotification::sendOrFail("*Restore Database*\n" .
                "Tanggal: *" . Carbon::now()->format('d-m-Y') . "*\n" .
                "File: *{$files->getClientOriginalName()}*\n" .
                "Status: *" . 'Berhasil' . "*\n" .
                "Import by: *" . auth()->user()->name . "*");
            return back()->with('success', 'Backup berhasil dikembalikan dari file ' . $files->getClientOriginalName());
        } catch (\Exception $err) {
            return back()->with('error', 'Backup gagal dikembalikan. Pastikan file backup valid ' . $err->getMessage());
        }
    }
}
