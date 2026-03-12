<?php

namespace App\Facades;

class FileFacade
{
    public static function requisito($path)
    {
        $disk = \Storage::disk('requisitos');
        if (!$disk->exists($path))
            return redirect(asset('assets/img/income-404.jpg'));

        $extension = strtolower(pathinfo($path,PATHINFO_EXTENSION));
        $content=$disk->get($path);
        $mimeType = match ($extension) {
            'pdf' => 'application',
            'mp4' => 'video',
            default => 'image',
        };

        header("Content-type: $mimeType/".$extension);
        header("Content-Length: " . strlen($content));
        echo $content;
        die();
    }

}
