<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'utilisateur_id',
        'action',
        'resource_type',
        'resource_id',
        'method',
        'path',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
        'success',
        'error_message',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'success' => 'boolean',
        'created_at' => 'datetime',
    ];

    public const UPDATED_AT = null;

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
