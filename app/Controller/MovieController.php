<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP MovieController
 * @author root
 */
class MovieController extends AppController {
    public $uses = false;
    public $helpers = ['Html', 'Form'];
    public $layout = 'ajax';
    private $moive_file_extensions = ['webm', 'mkv', 'flv', 'vob', 'ogg', 'ogv', 'gif', 'gifv', 'mng', 'avi', 'mov', 'qt', 'wmv', 'yuv', 'rm', 'rmvb', 'asf', 'amv', 'mp4', 'm4p', 'm4v',
        'mpg', 'mp2', 'mpeg', 'mpe', 'mpv', 'm2v', 'm4v', 'svi', '3gp', '3g2', 'mxf', 'roq', 'nsv', 'flv', 'f4v', 'f4p', 'f4a', 'f4b'];
    
    public function scanDir(){           
        $this->autoRender = false;
        
        $dir = $this->request->data('dir');
        $all = scandir($dir);
        array_shift($all);array_shift($all);
        $folders = [];
        $files = [];
        foreach ($all as $item){
            if (is_dir($dir.$item)){
                array_push($folders, ['name' => $item, 'dir' => $dir, 'connected' => true]);
            } elseif(is_link($dir.$item)){
                array_push($folders, ['name' => $item.' (Not Connected)', 'dir' => $dir, 'connected' => false]);
            } else {
                array_push($files, ['name' => $item, 'dir' => $dir]);
            }
        }
        $this->set('files', $files);
        $this->set('folders', $folders);
        
        if ($this->request->data('first') == true){
            $this->render();
        } else {
            $this->render('/Elements/DirElement');
        }
    }
    
    public function searchDir(){
        $this->autoRender = false;
        
        $search_query = $this->request->data('search');
        $dir = $this->request->data('dir');
        $filter = $this->request->data('filter');
        
        $results = $this->recursiveSearch($dir, $search_query);
        
        $folders = [];
        $files = [];        
        
        foreach ($results as $item){
            if (is_dir($item['dir'].$item['name'])){
                if ($this->filterSearch($item, $filter)){array_push($folders, $item);}
            } else {
                if ($this->filterSearch($item, $filter)){array_push($files, $item);}
            }
        }
        
        $this->set('folders', $folders);
        $this->set('files', $files);
        $this->render('/Elements/DirElement');
    }
    
    private function filterSearch($item, $filter){
        if($filter == 'videos'){
            $exp = explode('.', $item['name']);
            $ext = $exp[count($exp)-1];
            return in_array($ext, $this->moive_file_extensions);
        } elseif($filter == 'all'){
            return true;
        } elseif($filter == 'downloading'){
            $exp = explode('.', $item['name']);
            $ext = $exp[count($exp)-1];
            return $ext == 'part';
        }
        return true;
    }
    
    private function recursiveSearch($dir, $pattern){  
        //echo 'Directory: '.$dir.' Pattern: '.$pattern.'<br>';        
        $all = scandir($dir);
        $results = [];
        $matches = [];
        foreach ($all as $item){
            if ((is_dir($dir.$item)) && ($item != '.' && $item != '..')){
                try{
                    $matches = array_merge($this->recursiveSearch($dir.$item.DIRECTORY_SEPARATOR, $pattern), $matches);
                } catch (Exception $e){}
            }
            if (stripos($item, $pattern) !== false || stripos($item, str_replace(' ', '.', $pattern)) !== false){
                array_push($results, $item);
            }
        }
        
        $formatted_results = [];        
        
        foreach($results as $item){            
            $format = ['name' => $item, 'dir' => $dir, 'connected' => true]; 
            array_push($formatted_results, $format);
        }
        return array_merge($formatted_results, $matches);
    }


    public function changeName(){
        $this->autoRender = false;
        
        $dir = $this->request->data('dir');
        $file = $this->request->data('file');
        $newName = $this->request->data('name');
                
        rename($dir.$file, $dir.$newName);
    }    
    
    public function search(){
        
    }
}
