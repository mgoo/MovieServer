<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP TorrentController
 * @author root
 */
class TorrentController extends AppController {
    public $uses = false;
    public $helpers = ['Html', 'Form', 'Torrent'];
    public $layout = 'ajax';
    public $components = ['Torrent'];

    public function index() {
        $output = [];  
        exec('transmission-remote -n mgoo:poliwrath -l', $output);                               
        $this->set('data', $this->Torrent->extract_data($output));
    }
    
    public function add(){
        $hash = $this->request->data('hash');
        $title = $this->request->data('title');
        
        $magnet = $this->Torrent->hash_to_magnet($hash, $title);
        exec('transmission-remote -n mgoo:poliwrath -a '.$magnet);
        $this->autoRender = false;
    }
    
    public function search(){
        $title = $this->request->data('title');
        $year = $this->request->data('year');
        
        if ($title != ''){$this->set('title', $title);}
        if ($year != ''){$this->set('year', $year);}
    }
}
