<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 17/04/17
 * Time: 11:16 AM
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class OmdbTable extends Table{
    public function initialize(array $config){
        $this->addBehavior('Timestamp');
        $this->table('omdb_cache');
    }

    public function find($type = 'one', $options = []){
        if (empty($options['title']))return false;
        if (!isset($options['year']))$options['year'] = '';

        $query = 'http://www.omdbapi.com/?t='.urlencode($options['title']).'&y='.urlencode($options['year']).'&plot=short&r=json';
        $result_obj = parent::find()->where(['query_string' => $query]);

        if (!$result_obj->isEmpty()){
            $result = $result_obj->first()->toArray();
            $data = json_decode($result['result']);
            if ($data->Response == 'False')return false;
            return $data;
        } else {
            echo "OMDB ACCESSED*****";
            $result = file_get_contents($query);
            $new_result = $this->newEntity();
            $new_result->query_string = $query;
            $new_result->result = $result;
            $new_result->title = $options['title'];
            $new_result->year = $options['year'];
            $this->save($new_result);

            $data = json_decode($result);
            if ($data->Response == 'False')return false;
            return $data;
        }

    }
}
