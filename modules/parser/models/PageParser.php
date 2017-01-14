<?php

namespace app\modules\parser\models;

/**
 * parser
 *
 * @author DartVadius
 */
class PageParser {
    protected $appConfig;
    protected $url;
    protected $source;
    protected $body;
    
    /**
     * 
     * @param string $url
     */
    public function __construct($url) {
        $this->appConfig = \app\modules\parser\ParserModule::$configPageParser;        
        $this->url = $url;
        $urlArr = parse_url($url);
        $this->source = $urlArr['host'];
        $this->body = '';
    }
    public function getSource() {
        return $this->source;
    }    
    
    public function getUrl() {
        return $this->url;
    }
    
    public function getBody() {
        return $this->body;        
    }
}
