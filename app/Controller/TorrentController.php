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

    /**
     * This lists the current donloads from transmission
     * currently unused as the transmission web interface is being used in a Iframe
     * will create my own interface for it eventually for it but is works well at the moment
     */
    public function index() {
        $output = [];  
        exec('transmission-remote -n mgoo:poliwrath -l', $output);                               
        $this->set('data', $this->Torrent->extract_data($output));
    }
    
    /**
     * adds a torrent to transmission to the default download location Torrents atm
     */
    public function add(){
        $hash = $this->request->data('hash');
        $title = $this->request->data('title');
        
        $magnet = $this->Torrent->hash_to_magnet($hash, $title);
        exec('transmission-remote -n mgoo:poliwrath -a '.$magnet);
        $this->autoRender = false;
    }
    
    /**
     * Loads the HTML for the search bar for search the torrent project api
     */
    public function search(){
        $title = $this->request->data('title');
        $year = $this->request->data('year');
        
        if ($title != ''){$this->set('title', $title);}
        if ($year != ''){$this->set('year', $year);}
    }
}
