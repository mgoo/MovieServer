<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP TorrentComponent
 * @author root
 */
class TorrentComponent extends Component {
    public $components = array();
    
    public function extract_data($allData){    //TODO fix this stupid thing
        unset($allData[0]);
        $usefullData = [];
        foreach ($allData as $file){
            $file_info = preg_split('/\s+/', $file);            
            if ($file_info[0] == 'Sum:'){                
                array_push($usefullData, ['id' => $file_info[0], 'down' => $file_info[4], 'up' => $file_info[3], 'name' => 'global']);
            } else {
                $file_info[2] = rtrim($file_info[2], '%');            
                $file_info[10] = implode(' ', array_slice($file_info, 10));
                print_r($file_info);            
                array_push($usefullData, ['id' => $file_info[1], 'done' => $file_info[2], 'have' => $file_info[3] . $file_info[4], 'ETA' => $file_info[5].$file_info[6], 'up' => $file_info[7], 'down' => $file_info[8], 'status' => $file_info[10],  'name' => $file_info[11]]);
            }
        }
        return $usefullData;
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
