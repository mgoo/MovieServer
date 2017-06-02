<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 17/04/17
 * Time: 1:38 PM
 */

namespace App\Controller;

use App\Model\Table\GenresTable;
use App\Model\Table\OmdbTable;
use App\Model\Table\PiratebayTable;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class SearchController extends AppController{
    /** @var OmdbTable omdb the mode for the omdb cache */
    public $Omdb;
    /** @var PiratebayTable omdb the mode for the omdb cache */
    public $Piratebay;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('File');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
        $this->Genres = TableRegistry::get('Genres');
        $this->Omdb = TableRegistry::get('Omdb');
        $this->Piratebay = TableRegistry::get('Piratebay');
        return parent::beforeFilter($event);
    }

    public function index(){

    }

    public function search(){
        $this->viewBuilder()->layout('ajax');

        $search = $this->request->data['search'];
        $category = $this->request->data['category'];
        $order = $this->request->data['order'];

        $results =  $this->Piratebay->find('notused', ['search' => $search, 'category' => $category, 'order' => $order]);
        foreach ($results as &$value){
            $value['extracted_name'] = $this->File->extractTitle($value['name']);
        }
        $this->set('results', $results);
    }
}