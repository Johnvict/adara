<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;

trait Utility
{
    public static function upload($base64_encoded)
    {
        $uploads_dir = base_path('storage/app/public/images');
        $file_name = uniqid();
        $allowed_mimes = ['data:image/jpeg;base64', 'data:image/png;base64', 'data:image/jpg;base64', 'data:image/pdf;base64'];
        $the_image = explode(',', $base64_encoded);

        $mime = $the_image[0]; // data:image/jpeg;base64
        $image = $the_image[1];

        $extension = '.jpg';
        if (!in_array($mime, $allowed_mimes))
            return [
                "status"    => "02",
                "error"        => "File type not allowed. Only png, jpg, pdf, jpeg required"
            ];

        $file = fopen($uploads_dir . '/' . $file_name . $extension, 'w+');
        fwrite($file, base64_decode($image));
        fclose($file);
        return [
            "status"    => "00",
            "fileName"        => $file_name . $extension
        ];
    }
}
