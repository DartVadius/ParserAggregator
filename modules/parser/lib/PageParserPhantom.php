<?php

namespace app\modules\parser\lib;
use PhantomInstaller\PhantomBinary;

/**
 * ParserPhantom: obtain the content of the page using phantomJS headless browser
 *
 * @author DartVadius
 */
class PageParserPhantom extends PageParser {
    /**
     *
     * @param string $url
     */
    public function __construct($url) {
        parent::__construct($url);
        $bin = PhantomBinary::getBin();
        $jsPath = $this->appConfig['jsSetup']['jsPath'];
        $this->body = __FILE__ . " " . shell_exec("$bin  $jsPath $url");
    }

}
