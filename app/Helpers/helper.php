
<?php

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

if (!function_exists('test')) {
    /**
     * This function uploads files to the filesystem of your choice
     * @param \Illuminate\Http\UploadedFile $file The File to Upload
     * @param string|null $filename The file name
     * @param string|null $folder A specific folder where the file will be stored
     * @param string $disk Your preferred Storage location(s3,public,gcs etc)
     */

    function test($name)
    {
        $testname = "yourname".$name;
        return $testname;
    }
}
