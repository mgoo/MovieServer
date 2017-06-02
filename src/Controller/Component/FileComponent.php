<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 18/04/17
 * Time: 11:26 AM
 */

namespace App\Controller\Component;


use Cake\Controller\Component;

class FileComponent extends Component {
    /**
     * tries to extract the title from the title of a file
     * does this by choping of the name of the file from the quality of which season and expisode of the TV series it is
     * @param String $title
     * @return array [title, year, quality]
     */
    public function extractTitle($filename){
        $title = $filename;
        $year = '';
        $quality = '';
        $title = preg_replace('/\.[^.]+$/', '', $title); //remove the file type
        $qualities = ['1080p', '720p', '480p', '360p', 'BlueRay', 'HDRIP', 'DVDRIP', 'HDTV', 'EXTENDED', 'HD-TC'];
        foreach ($qualities as $qual){
            if(stripos($title, $qual)){ // If the title contains the quality then set the quality and chop of the end of the string
                $quality = $qual;
                $title = substr($title, 0, stripos($title, $qual));
            }
        }
        if(preg_match('/\.[Hh][Cc]\./', $title)){ // Handle HC for hard coded subs
            $quality .= ' HC';
            $title = preg_replace('/\.[Hh][Cc]\./', '.', $title);
        }
        preg_match('/\.[0-9]{4}[.$]/', $title, $year_matches);
        $year = end($year_matches);
        $year = preg_replace('/\./', '', $year);
        $title = preg_replace('/[.]/', ' ', $title); //removes full stops
        $title = preg_replace('/  /', ' ', $title); //removes double spaces
        $title = preg_replace('/[ ]+$/', '', $title);


        /*if (ctype_digit(explode(' ', $title)[count(explode(' ', $title))-1]) && strlen(explode(' ', $title)[count(explode(' ', $title))-1]) == 4){
            $year = explode(' ', $title)[count(explode(' ', $title))-1];
            $title = substr($title, 0, count($title)-1-5);
        }*/
        return [$title, $year, $quality];
    }
}