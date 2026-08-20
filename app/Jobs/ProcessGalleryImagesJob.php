<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\GalleryModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessGalleryImagesJob implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $galleryId,
        public array $paths
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $gallery = GalleryModel::findOrFail($this->galleryId);

        foreach ($this->paths as $path) {
            $fullPath = Storage::disk('local')->path($path);

            if (!file_exists($fullPath)) {
                Log::warning("ProcessGalleryImagesJob: File not found, skipping: {$fullPath}");
                continue;
            }

            try {
                $gallery->addMedia($fullPath)
                    ->toMediaCollection('gallery');
            } catch (\Throwable $e) {
                Log::error("ProcessGalleryImagesJob: Failed to add media for gallery {$this->galleryId}: {$e->getMessage()}");
                throw $e;
            }

            // Clean up the temp file (it may already be moved by addMedia)
            if (Storage::disk('local')->exists($path)) {
                Storage::disk('local')->delete($path);
            }
        }

        Log::info("ProcessGalleryImagesJob: Successfully processed " . count($this->paths) . " images for gallery {$this->galleryId}");
    }

    /**
     * Handle a job failure.
     */
    public function failed(?\Throwable $exception): void
    {
        Log::error("ProcessGalleryImagesJob failed for gallery {$this->galleryId}: " . ($exception?->getMessage() ?? 'Unknown error'));

        // Clean up any remaining temp files
        foreach ($this->paths as $path) {
            if (Storage::disk('local')->exists($path)) {
                Storage::disk('local')->delete($path);
            }
        }
    }
}
