<?php

/**
 * Description of rssItem
 *
 * @author DartVadius
 */
class rssItem { 
    private $post = [];
    public function __construct() {
        
    }
    public function __set($name, $value) {
        $this->post[$name] = $value;
    }
    public function getRssItem() {
        return $this->post;
    }
}
