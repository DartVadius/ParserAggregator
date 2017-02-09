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
     * getting page content by PhantomJS browser
     * 
     * @param string $url
     */
    public function __construct($url) {
        parent::__construct($url);
        $bin = PhantomBinary::getBin();
//        $proxy = ['186.219.36.19:8080',
//            '64.20.74.24:45554',
//            '62.37.237.101:8080',
//            '67.149.217.254:10200',
//            '203.77.251.162:8080',
//            '31.208.48.230:45554',
//            '47.88.188.1:3128',
//            '180.234.206.77:8080',
//            '138.68.140.197:3128',
//            '78.11.85.13:8080',
//            '188.40.37.248:3128',
//            '139.59.17.113:8080',
//            '191.179.147.46:11421',
//            '113.53.159.111:8080',
//            '68.234.205.173:45554'
//        ]; 
//        $n = array_rand($proxy);
//        $newProxy = '--proxy='.$proxy[$n];       
        $jsPath = $this->appConfig['jsSetup']['jsPath'];
        $this->body = shell_exec("$bin $jsPath $url");
    }

}
