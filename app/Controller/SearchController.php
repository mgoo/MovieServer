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
    
    public function search(){
        $title = $this->request->data('title');
        $year = $this->request->data('year');
        
        $json_string = file_get_contents('https://torrentproject.se/?s='.$title.' '.$year.'&out=json', true);
        $json_string = utf8_encode($json_string);
        $data_array = json_decode($json_string, true);
        
        $this->set('data', $data_array);  
    }    
        
    public function getInfo(){
        $title = $this->request->data('title');        
        $year = $this->request->data('year');
        
        $isFile = $this->request->data('isFile');
        if ($isFile == true){
            $this->set('location', $this->request->data('dir'));
            $this->set('ext', explode('.', $title)[count(explode('.', $title))-1]); 
            $this->set('is_file', true);      
            $title = $this->extractTitle($title);
            $year = $title['year'];
            $title = $title['title'];
            $this->set('title', $title);            
        }
        
        $json_string = file_get_contents('http://www.omdbapi.com/?t='.urlencode($title).'&y='.urlencode($year).'&plot=short&r=json');
        $json_string = utf8_encode($json_string);
        $data_array = json_decode($json_string, true);        
        
        $this->set('data', $data_array);        
    }
    
    public function quickOpen(){
        $this->autoRender = false;
        
        $title = $this->request->data('title');
        
        $this->set('location', $this->request->data('dir'));
        $this->set('title', $this->extractTitle($title)['title']);
        $this->set('data', ['Error' => 'has not loaded yet']);
        $this->set('ext', explode('.', $title)[count(explode('.', $title))-1]);
        $this->set('is_file', true);
        
        $this->render('get_info');
    }
    
    private function extractTitle($title){
        $year = '';
        $title = preg_replace('/.'.explode('.', $title)[count(explode('.', $title))-1].'/', '', $title); //remove the file type
        $qualities = ['1080p', '720p', '480p', '360p', 'BlueRay', 'HDRIP', 'DVDRIP', 'EXTENDED', '/S([0-9]{2})E([0-9]{2})/'];
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
    
    public function loadMoive(){
        $this->autoRender = false;
        
        $json_string = $this->request->data('data');
        $json_string = utf8_encode($json_string);
        $data_array = json_decode($json_string, true);
        
        $this->set('data', $data_array);
        $this->render('get_info');
    }
}
