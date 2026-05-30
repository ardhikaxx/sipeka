<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => AuditLog::count(),
            'today' => AuditLog::whereDate('created_at', now())->count(),
            'create' => AuditLog::whereIn('aksi', ['create', 'tambah'])->count(),
            'update' => AuditLog::whereIn('aksi', ['update', 'ubah'])->count(),
            'delete' => AuditLog::whereIn('aksi', ['delete', 'hapus'])->count(),
        ];

        $logs = AuditLog::with('user')->latest()->paginate(20);

        return view('admin.audit.index', compact('logs', 'stats'));
    }
}
