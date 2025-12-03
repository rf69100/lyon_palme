<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public static function log(
        string $action,
        string $resourceType,
        ?int $resourceId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        bool $success = true,
        ?string $errorMessage = null
    ): AuditLog {
        return AuditLog::create([
            'utilisateur_id' => Auth::id(),
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'method' => Request::method(),
            'path' => Request::path(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'success' => $success,
            'error_message' => $errorMessage,
        ]);
    }

    public static function logLogin(string $email, string $ipAddress, bool $success = true): AuditLog
    {
        return self::log(
            action: 'login',
            resourceType: 'Utilisateur',
            success: $success,
            errorMessage: $success ? null : 'Failed login attempt'
        );
    }

    public static function logLogout(): AuditLog
    {
        return self::log(
            action: 'logout',
            resourceType: 'Utilisateur'
        );
    }

    public static function logCreate(string $resourceType, int $resourceId, array $newValues): AuditLog
    {
        return self::log(
            action: 'create',
            resourceType: $resourceType,
            resourceId: $resourceId,
            newValues: $newValues
        );
    }

    public static function logUpdate(string $resourceType, int $resourceId, array $oldValues, array $newValues): AuditLog
    {
        return self::log(
            action: 'update',
            resourceType: $resourceType,
            resourceId: $resourceId,
            oldValues: $oldValues,
            newValues: $newValues
        );
    }

    public static function logDelete(string $resourceType, int $resourceId, array $oldValues): AuditLog
    {
        return self::log(
            action: 'delete',
            resourceType: $resourceType,
            resourceId: $resourceId,
            oldValues: $oldValues
        );
    }

    public static function logExport(string $resourceType, ?int $count = null): AuditLog
    {
        return self::log(
            action: 'export',
            resourceType: $resourceType,
            newValues: $count ? ['count' => $count] : null
        );
    }

    public static function logPasswordChange(int $userId): AuditLog
    {
        return self::log(
            action: 'password_change',
            resourceType: 'Utilisateur',
            resourceId: $userId
        );
    }

    public static function logUnauthorizedAccess(string $resourceType, int $resourceId): AuditLog
    {
        return self::log(
            action: 'unauthorized_access_attempt',
            resourceType: $resourceType,
            resourceId: $resourceId,
            success: false,
            errorMessage: 'User does not have permission to access this resource'
        );
    }
}
