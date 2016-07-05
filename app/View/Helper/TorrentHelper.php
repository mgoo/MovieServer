<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP TorrentHelper
 * @author root
 */
class TorrentHelper extends AppHelper {

    public $helpers = array();

    public function formatBytes($bytes, $precision = 1) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        $bytes /= pow(1024, $pow); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }
    
    public function hash_to_magnet($hash, $name){
        $magnet = "magnet:"
            . "?xt=urn:btih:" . $hash
            . "&dn=" . urlencode($name)
            . "&tr=udp%3A%2F%2Ftracker.openbittorrent.com%3A80"
            . "&tr=udp%3A%2F%2Fopentor.org%3A2710"
            . "&tr=udp%3A%2F%2Ftracker.ccc.de%3A80"
            . "&tr=udp%3A%2F%2Ftracker.blackunicorn.xyz%3A6969"
            . "&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969"
            . "&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969";
        return $magnet;
    }

}
