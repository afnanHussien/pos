<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoHelper
{
    public static function compress(UploadedFile $video): string
    {
        $originalPath = $video->store('original_videos', 'public');

        $compressedName = 'videos/' . Str::uuid() . '.mp4';
        // $compressedPath = storage_path('app/public/' . $compressedName);

        FFMpeg::fromDisk('public')
            ->open($originalPath)
            ->export()
            ->toDisk('public')
            ->inFormat(new \FFMpeg\Format\Video\X264('aac', 'libx264'))
            ->save($compressedName);

        return $compressedName;
    }
}