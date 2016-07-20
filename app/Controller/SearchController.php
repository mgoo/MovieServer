<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP SearchController
 * @author root
 */
class SearchController extends AppController {
    public $uses = false;
    public $helpers = ['Html', 'Form', 'Torrent'];
    public $layout = 'ajax';
    public $components = [];

    public function index() {
        
    }
    
    /**
     * Searches the Torrent Project API for torrents
     */
    public function search(){
        $title = $this->request->data('title');
        $year = $this->request->data('year');
        
        $json_string = file_get_contents('https://torrentproject.se/?s='.$title.' '.$year.'&out=json', true);
        $json_string = utf8_encode($json_string);
        $data_array = json_decode($json_string, true);
        
        $this->set('data', $data_array);  
    }    
        
    /**
     * Gets the info of a movie from Omdb and returns the HTML for the side bar
     */
    public function getInfo(){
        $title = $this->request->data('title');        
        $year = $this->request->data('year');
        
        $isFile = $this->request->data('isFile');
        if ($isFile == true){
            $dir = $this->request->data('dir');
            $this->set('location', $dir);
            $this->set('ext', explode('.', $title)[count(explode('.', $title))-1]); 
            $this->set('is_file', true);      
            $title = $this->extractTitle($title);
            $year = $title['year'];
            $title = $title['title'];
            $this->set('title', $title);   
            
            $base_location = Configure::read('DeviceNetworkLocations')[explode('/', $dir)[1]];
            $dir_arr = explode('/', $dir);
            unset($dir_arr[0]);unset($dir_arr[1]);
            $base_location .= implode('\\', $dir_arr);
            $this->set('network_location', $base_location); //This only works with windows as docuemtn separator has to be the document separator of the client not he server
        }
        
        $json_string = file_get_contents('http://www.omdbapi.com/?t='.urlencode($title).'&y='.urlencode($year).'&plot=short&r=json');
        $json_string = utf8_encode($json_string);
        $data_array = json_decode($json_string, true);        
        
        $this->set('data', $data_array);        
    }
    
    /**
     * returns the code for the side bar but does not search Omdb so it is faster
     */
    public function quickOpen(){
        $this->autoRender = false;
        
        $title = $this->request->data('title');
        
        $dir = $this->request->data('dir');
        
        $this->set('location', $dir);
        $this->set('title', $this->extractTitle($title)['title']);
        $this->set('data', ['Error' => 'has not loaded yet']);
        $this->set('ext', explode('.', $title)[count(explode('.', $title))-1]);
        $this->set('is_file', true);
        
        $base_location = Configure::read('DeviceNetworkLocations')[explode('/', $dir)[1]];
        $dir_arr = explode('/', $dir);
        unset($dir_arr[0]);unset($dir_arr[1]);
        $base_location .= implode('\\', $dir_arr);
        $this->set('network_location', $base_location); //This only works with windows     
        
        $this->render('get_info');
    }
    
    /**
     * tries to extract the title from the title of a file
     * does this by choping of the name of the file from the quality of which season and expisode of the TV series it is
     * @param type $title
     * @return type
     */
    private function extractTitle($title){
        $year = '';
        $title = preg_replace('/.'.explode('.', $title)[count(explode('.', $title))-1].'/', '', $title); //remove the file type
        $qualities = ['1080p', '720p', '480p', '360p', 'BlueRay', 'HDRIP', 'DVDRIP', 'HDTV', 'EXTENDED', 'HD-TC', '/S([0-9]{2})E([0-9]{2})/'];
        foreach ($qualities as $qual){
            if (substr($qual, 0, 1) == '/'){
                preg_match($qual, $title, $matches, PREG_OFFSET_CAPTURE);
                if($matches != []){
                    if($qual == '/S([0-9]{2})E([0-9]{2})/'){
                        $ep = 'Season: '.substr($matches[0][0], 1, 2).' Episode: '.substr($matches[0][0], 4, 5);
                        $this->set('episode', $ep);
                    }               
                    $title = substr($title, 0, $matches[0][1]);
                }
            } else {                
                if(stripos($title, $qual)){
                    $this->set('quality', $qual);
                    $title = substr($title, 0, stripos($title, $qual));                    
                }
            }
        }      
        $title = preg_replace('/[.]/', ' ', $title); //removes full stops
        $title = preg_replace('/  /', ' ', $title); //removes double spaces
        if (substr($title, count($title)-2) == ' '){$title = substr($title, 0, count($title)-2);} //removes trailing space
        if (ctype_digit(explode(' ', $title)[count(explode(' ', $title))-1]) && strlen(explode(' ', $title)[count(explode(' ', $title))-1]) == 4){
            $year = explode(' ', $title)[count(explode(' ', $title))-1];
            $title = substr($title, 0, count($title)-1-5);
        }
        return ['title' => $title, 'year' => $year];
    }
    
    /**
     * Searches Omdb for a movie and returns a list of results
     * this has pagination
     */
    public function searchOmdb(){
        $title = $this->request->data('title');
        $year = $this->request->data('year');
        $page = $this->request->data('page');
        $type = $this->request->data('type');
        
        $search_string = 's='.urlencode($title);
        if ($year != ''){$search_string .= '&y='.urlencode($year);}
        if ($page != ''){$search_string .= '&page='.urlencode($page);}
        if ($type != ''){$search_string .= '&type='.urlencode($type);}
        
        $json_string = file_get_contents('http://www.omdbapi.com/?'.$search_string.'&r=json');
        $json_string = utf8_encode($json_string);
        $data_array = json_decode($json_string, true);
        
        $this->set('data', $data_array);
        $this->set('page', $page);
        $this->set('year', $year);
        $this->set('title', $title);
        $this->set('type', $type);
    }
    
    /**
     * this loads a movie to the sidebar from a omdb search
     * un unused as cbf json encoding everything when searching Omdb is reasonable fast
     */
    public function loadMoive(){
        $this->autoRender = false;
        
        $json_string = $this->request->data('data');
        $json_string = utf8_encode($json_string);
        $data_array = json_decode($json_string, true);
        
        $this->set('data', $data_array);
        $this->render('get_info');
    }
}
