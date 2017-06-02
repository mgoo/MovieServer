<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 12/02/17
 * Time: 4:57 PM
 */

namespace App\Controller;

use App\Model\Table\GenresTable;
use App\Model\Table\OmdbTable;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class MoviesController extends AppController {
    /** @var GenresTable the genres Model  */
    public $Genres;
    /** @var OmdbTable omdb the mode for the omdb cache */
    public $Omdb;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('File');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
        $this->Genres = TableRegistry::get('Genres');
        $this->Omdb = TableRegistry::get('Omdb');
        return parent::beforeFilter($event);
    }

    public function index() {
        $this->viewBuilder()->layout('default');
    }

    public function list() {
        $genres = $this->Genres->find('all');
        $genres_options = [];
        foreach($genres as $genre) {
            $genres_options[] = "<option value='$genre->id'>$genre->name</option>";
        }
        $this->set('genres', $genres_options);
    }

    public function featuredMovies(){
        $this->viewBuilder()->layout('ajax');
        $this->set('movies', [1,2,3,4,5,6,7,8]);
    }

    public function allMovies() {
        $movies = $this->Movies->find('all');
        $this->set(compact($movies));
    }

    public function updateMovies(){
        $this->autoRender = false;

        $Directory = new \RecursiveDirectoryIterator('files/Movies/',  \FilesystemIterator::FOLLOW_SYMLINKS);
        $Iterator = new \RecursiveIteratorIterator($Directory);
        //$Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH); //TODO use this to only match movies
        $files = [];
        foreach ($Iterator as $file_path_str){ //Remove
            if (substr($file_path_str, strlen($file_path_str) - 1) == '.'
                || ($this->Movies->exists(['path' => $file_path_str]) && !$this->Movies->find()->where(['path' => $file_path_str])->first()->toArray()['refresh'])){
                continue;
            }
            $files[] = $file_path_str;
        }
        if (count($files) == 0){
            echo "There are no Movies to update";
        }
        foreach ($files as $file_path_str){
            $file_path = explode('/', $file_path_str);
            $filename = end($file_path);
            list($title, $year, $quality) = $this->File->extractTitle($filename);
            echo 'Title: '.$title.' Year: '.$year.' Quality: '.$quality.'<br>';
            $data = $this->Omdb->find('one', ['title' => $title, 'year' => $year]);
            $newMovie = $this->Movies->newEntity();
            $newMovie->filename = $filename;
            $newMovie->path = $file_path_str;
            $newMovie->quality = $quality;
            if ($data != false){
                $newMovie->poster = $data->Poster;
                $newMovie->name = $data->Title;
                $genres = explode(', ', $data->Genre);
                $genre_keys = [];
                foreach ($genres as $genre){
                    if (!$this->Genres->exists(['name' => $genre])){
                        $newGenre = $this->Genres->newEntity();
                        $newGenre->name = $genre;
                        $this->Genres->save($newGenre);
                    }
                    $genre_keys[] = $this->Genres->find()->where(['name' => $genre])->first()->toArray()['id'];
                }
                $newMovie->genre = implode(',',$genre_keys);
            } else {
                $newMovie->name = $title;
            }
            $this->Movies->save($newMovie);
        }
    }
}