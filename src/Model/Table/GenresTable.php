<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 18/02/17
 * Time: 4:16 PM
 */

namespace App\Model\Table;


use Cake\ORM\Table;

class GenresTable extends Table {
    public function initialize(array $config){
        $this->addBehavior('Timestamp');
    }
}