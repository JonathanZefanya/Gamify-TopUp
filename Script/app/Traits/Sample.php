<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sample
{
    public function csvSampleDownload($file, $title)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type('assets/' . $file);
        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile('assets/' . $file);
    }
}
