<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageHelper
{
    public static function compress(UploadedFile $image): string
    {
        $imageRename = Str::uuid() . '.' . $image->extension();
        $originalPath = $image->storeAs('images', $imageRename, 'public');
        $fullPath = storage_path('app/public/' . $originalPath);

        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize($fullPath);
        
        return $originalPath;
    }
}