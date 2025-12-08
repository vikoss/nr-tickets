<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Service for handling evidence image uploads.
 * Handles compression, optimization, and storage with UUID-based filenames.
 */
class EvidenceImageService
{
    private ImageManager $manager;

    public function __construct()
    {
        // Use GD driver (available in most PHP installations)
        $this->manager = new ImageManager(new Driver);
    }

    /**
     * Store and optimize an evidence image.
     *
     * @param  UploadedFile  $file  The uploaded image file
     * @param  string  $servicioId  UUID of the parent service
     * @return array{path: string, mime: string, size: int, evidenciaId: string}
     */
    public function store(UploadedFile $file, string $servicioId): array
    {
        $evidenciaId = (string) Str::uuid();
        $extension = $this->getExtension($file);

        // Build path: evidences/{servicio_uuid}/{servicio_uuid}-{evidencia_uuid}.{ext}
        $directory = "evidences/{$servicioId}";
        $filename = "{$servicioId}-{$evidenciaId}.{$extension}";
        $path = "{$directory}/{$filename}";

        // Ensure directory exists
        Storage::disk('public')->makeDirectory($directory);

        // Read and optimize the image
        $image = $this->manager->read($file->getRealPath());

        // Get quality setting from config
        $quality = config('branding.evidence.compression_quality', 85);

        // Encode with compression
        $encoded = $image->encodeByExtension($extension, quality: $quality);

        // Store the optimized image
        Storage::disk('public')->put($path, $encoded->toString());

        // Get the final file size
        $size = Storage::disk('public')->size($path);

        return [
            'path' => $path,
            'mime' => $file->getMimeType(),
            'size' => $size,
            'evidenciaId' => $evidenciaId,
        ];
    }

    /**
     * Delete all evidence images for a service.
     *
     * @param  string  $servicioId  UUID of the service
     */
    public function deleteServiceEvidences(string $servicioId): void
    {
        $directory = "evidences/{$servicioId}";
        Storage::disk('public')->deleteDirectory($directory);
    }

    /**
     * Get the proper file extension from an uploaded file.
     */
    private function getExtension(UploadedFile $file): string
    {
        $mime = $file->getMimeType();

        return match ($mime) {
            'image/jpeg', 'image/jpg' => 'jpg',
            'image/png' => 'png',
            default => $file->getClientOriginalExtension() ?: 'jpg',
        };
    }
}
