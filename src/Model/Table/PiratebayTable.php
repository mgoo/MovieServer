<?php
/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 17/04/17
 * Time: 1:53 PM
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class PiratebayTable extends Table{
    public $categories = ['all' => 0, 'audio' => 100, 'videos' => 200, 'applications' => 300, 'games' => 400, 'other' => 600];
    public $orders = ['default' => 0, 'seeders' => 7, 'leachers' => 9];

    public function initialize(array $config){
        $this->addBehavior('Timestamp');
        $this->table('piratebay_cache');
    }

    public function find($type = 'all', $options = []){
        if (!isset($options['search']))return false;
        $category = 0; $page = 0; $order = 0;
        if (isset($options['category']) && $this->categories[$options['category']])$category = $this->categories[$options['category']];
        if (isset($options['page']))$page = $options['page'];
        if (isset($options['order']) && $this->orders[$options['order']])$order = $this->orders[$options['order']];
        $response = file_get_contents($this->buildUrl($options['search'], $category, $page, $order));
        $magnets = $this->extractMagnetUrls($response);
        $magnet_array = [];
        foreach ($magnets as $magnet){
            $name = '';
            preg_match('/(?<=dn=)[^\&]+/', $magnet, $name);
            $magnet_array[] = ['magnet' => $magnet, 'name' => urldecode($name[0])];
        }
        return $magnet_array;
    }

    /**
     * Extracts the magenet links from the page and returns them as an array
     * @param $response
     * @return array
     */
    private function extractMagnetUrls($response){
        $matches = array();
        preg_match_all('/(?<=\")magnet:\?\S+(?=\")/', $response, $matches);
        return $matches[0];
    }

    /**
     * Builds a url that searches the piratebay
     * example search url 'http://thepiratebay.se/s/?q=starwars&category=0&page=0&orderby=99'
     * @param $search
     * @param int $category
     * @param int $page
     * @param int $order
     * @return string
     */
    private function buildUrl($search, $category = 0, $page = 0, $order = 7){
        return 'http://thepiratebay.se/s/?q='.$search.'&category='.$category.'&page='.$page.'&orderby='.$order;
    }
}