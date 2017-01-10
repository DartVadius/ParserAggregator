<?php
define(PHANTOMPATH, 'phantomjs');
define(JSPATH, 'myjs.js');
/**
 * phantomJsItem
 *
 * @author DartVadius
 */
class phantomJsItem {
    private $data = null;
    public function __construct($url, $phantomPath, $jsPath) {        
        $this->data['url'] = $url;
        $urlArr = parse_url($url);
        $this->data['source'] = $urlArr['host'];
        $this->data['body'] = shell_exec("$phantomPath $jsPath $url");
    }
    public function getPhantomBody() {
        return $this->data['body'];
    }

    public function getPhantomSource() {
        return $this->data['source'];
    }    
    
    public function getPhantomUrl() {
        return $this->data['url'];
    }
}
