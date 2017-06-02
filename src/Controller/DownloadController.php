<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 17/04/17
 * Time: 12:48 PM
 */

namespace App\Controller;

use Cake\Event\Event;
use Transmission\Transmission;

class DownloadController extends AppController{
    /** @var \Transmission\Transmission the transmission library object  */
    public $Transmission;

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
        $this->Transmission = new Transmission('172.17.0.1', '9091');
        return parent::beforeFilter($event);
    }


    public function index(){

    }

    public function deluge() {

    }

    public function transmission() {
        $this->set('current_torrents', $this->Transmission->all());
    }

    public function add(){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;

        $magnet = $this->request->query('magnet');
        $torrent = $this->Transmission->add(urldecode($magnet));
        var_dump($torrent);
    }

    public function getProgress(){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;

        $id = (int)$this->request->query('id');
        echo $this->Transmission->get($id)->getPercentDone();
    }

    public function stop(){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;

        $id = (int)$this->request->query('id');
        $this->Transmission->stop($this->Transmission->get($id));
    }

    public function start(){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;

        $id = (int)$this->request->query('id');
        $this->Transmission->start($this->Transmission->get($id));
    }

    public function remove(){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;

        $id = (int)$this->request->query('id');
        $this->Transmission->remove($this->Transmission->get($id), false);
    }

    public function get(){
        $this->viewBuilder()->layout('ajax');
        $this->autoRender = false;

        $id = (int)$this->request->query('id');
        $this->set('torrent', $this->Transmission->get($id));
        $this->render('/Element/torrent_downloading');
    }
}