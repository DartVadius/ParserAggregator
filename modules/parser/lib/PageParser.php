<?php

namespace app\modules\parser\lib;

use app\modules\parser\ParserModule;

/**
 * class for getting page content
 *
 * @author DartVadius
 */
class PageParser {

    /**
     *
     * @var array - config data for setting up cURL and PhantomJS browser
     */
    protected $appConfig;
    protected $url;
    protected $source;
    protected $body;

    /**
     *
     * @param string $url - url of source page
     */
    public function __construct($url) {
        $this->appConfig = ParserModule::$config;
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
