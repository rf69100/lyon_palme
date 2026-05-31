<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\View\View;

/**
 * Consultation des journaux d'audit (US2 — traçabilité / non-répudiation).
 * Lecture seule, réservé aux rôles administratifs (middleware "admin").
 */
class AuditLogController extends Controller
{
    public function index(): View
    {
        $logs = AuditLog::with('utilisateur')
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('admin.audit.index', compact('logs'));
    }
}
