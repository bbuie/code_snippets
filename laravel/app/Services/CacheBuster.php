<?php
namespace App\Services;

class CacheBuster {

    public static function getVersionHash()
    {
        $hashFilePath = public_path('hash.json');
        if (file_exists($hashFilePath)) {
            $hashFileContents = json_decode(file_get_contents($hashFilePath));
            $versionHash = $hashFileContents->hash ?? null;
        } else {
            $versionHash = null;
        }

        return $versionHash;
    }

}