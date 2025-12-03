<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileSecurityService
{
    // Allowed MIME types for uploads
    private const ALLOWED_MIME_TYPES = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
    ];

    // Maximum file size (5MB)
    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

    // Dangerous file extensions
    private const DANGEROUS_EXTENSIONS = [
        'php', 'phtml', 'php3', 'php4', 'php5', 'php7',
        'exe', 'sh', 'bat', 'cmd', 'com', 'jar',
        'js', 'aspx', 'asp', 'jsp', 'html',
        'svg', 'swf', 'xhtml',
    ];

    /**
     * Validate uploaded file for security
     */
    public static function validateUploadedFile(UploadedFile $file): array
    {
        $errors = [];

        // Check file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            $errors[] = 'File size exceeds maximum allowed size of 5MB';
        }

        // Check MIME type
        $mimeType = $file->getMimeType();
        if (!isset(self::ALLOWED_MIME_TYPES[$mimeType])) {
            $errors[] = 'File type is not allowed. Allowed types: PDF, JPG, PNG, DOC, DOCX';
        }

        // Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, self::DANGEROUS_EXTENSIONS)) {
            $errors[] = 'File extension is not allowed';
        }

        // Check actual file content
        if (!self::isFileContentSafe($file)) {
            $errors[] = 'File content appears to be malicious';
        }

        return $errors;
    }

    /**
     * Check if file content is actually what it claims to be
     */
    private static function isFileContentSafe(UploadedFile $file): bool
    {
        $filePath = $file->getRealPath();
        $mimeType = mime_content_type($filePath);
        $declaredMimeType = $file->getMimeType();

        // PHP files disguised as other types
        $content = file_get_contents($filePath, false, null, 0, 512);

        if (str_contains($content, '<?php') || str_contains($content, '<?' . '?') || str_contains($content, '<%')) {
            return false;
        }

        // SVG with embedded scripts
        if ($declaredMimeType === 'image/svg+xml' && str_contains($content, '<script')) {
            return false;
        }

        return true;
    }

    /**
     * Store file securely
     */
    public static function storeFile(UploadedFile $file, string $path = 'uploads'): ?string
    {
        // Sanitize filename
        $originalName = InputSanitizationService::sanitizeFileName($file->getClientOriginalName());
        $fileName = time() . '_' . uniqid() . '.' . strtolower($file->getClientOriginalExtension());

        try {
            $storagePath = Storage::disk('local')->putFileAs(
                $path,
                $file,
                $fileName,
                'private'
            );

            return $storagePath;
        } catch (\Exception $e) {
            \Log::error('File upload failed', ['exception' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get file safely
     */
    public static function getFile(string $path)
    {
        if (!str_contains($path, '..')) {
            return Storage::disk('local')->get($path);
        }

        return null;
    }

    /**
     * Delete file safely
     */
    public static function deleteFile(string $path): bool
    {
        if (!str_contains($path, '..')) {
            return Storage::disk('local')->delete($path);
        }

        return false;
    }
}
