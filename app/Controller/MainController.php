<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP MainController
 * @author root
 */
class MainController extends AppController {
    public $uses = false;
    public $helpers = ['Html', 'Form'];
    //public $components = ['MovieSearch'];
    public $layout = 'main';
    
    function beforeFilter() {
        parent::beforeFilter();
    }

    public function index($id) {
        
    }
}
