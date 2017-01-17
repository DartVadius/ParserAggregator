<?php

namespace app\modules\parser\controllers;

use yii\web\Controller;
use app\modules\parser\lib\PageParserCurl;
use app\modules\parser\lib\PageParserPhantom;
use app\modules\parser\lib\ContentParser;
use app\modules\parser\lib\RssParser;
use app\models\Sites;
use app\models\Category;
use phpQuery;

/**
 * parser
 *
 * @author DartVadius
 */
class ParserController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionTest() {
        $url = '';
        $parser = new PageParserCurl($url);
        //$parser = new PageParserPhantom($url);

        return $this->render('test', ['info' => $parser]);
    }
    
    /**
     * 
     * @return type
     */
    public function actionRss() {
        /**
         * 
         * @todo сделать конфиг для дефолтной категории?!
         */
        $defaultCategory = 1;
        
        $sites = Sites::find()->where([
                    'make_parsing' => '1'
                ])->all();
        foreach ($sites as $site) {

            if ($site->method_of_parsing == 'Phantom') {
                $page = new PageParserPhantom($site->source);
            }
            if ($site->method_of_parsing == 'cURL') {
                $page = new PageParserCurl($site->source);
            }
            if (!empty($page->getBody())) {
                $rss = new RssParser($page);
            }      
                        
            $rss = $rss->getUniquePosts();
            
            foreach ($rss as $rssItem) {
                $category = Category::find()->all();
                $newCat = $this->strProcessing($rssItem->category);                
                if (!empty($newCat)) {                    
                    foreach ($category as $value) {                        
                        $cat = explode(',', $value['synonyms']);
                        $cat = array_map(array($this, 'strProcessing'), $cat);
                        $k = array_search($newCat, $cat);
                        if ($k !== NULL && $k !== FALSE) {
                            $k = $value['id'];
                            break;
                        }
                    }
                }                 
                if ($k) {
                    $rssItem->category = $k;
                } else {                    
                    $rssItem->category = $defaultCategory;
                }                
                $rssItem->save();                
            }
        }
        return $this->render('index', ['info' => $rssItem]);
    }
    
    private function strProcessing($str) {
        $str = trim($str);
        return mb_strtolower($str);
    }

}
