<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 19/04/17
 * Time: 11:43 AM
 */

namespace App\View\Helper;


use Cake\View\Helper;

class DownloadHelper extends Helper {

    private $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    /**
     * @param $bytes
     * @return array
     */
    public function bytesToReadable($bytes_original){
        for ($bytes = $bytes_original, $unit = 0; $bytes > 1024; $bytes /= 1024, $unit++){}
        return ['units' => $this->units[$unit], 'amount' => round($bytes, 2), 'origonal' => $bytes_original];
    }
}