<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 12/02/17
 * Time: 4:53 PM
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class MoviesTable extends Table {
    public function initialize(array $config){
        $this->addBehavior('Timestamp');
    }
}