<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts_rss".
 *
 * @property string $id
 * @property string $title
 * @property string $category
 * @property string $source
 * @property string $link
 * @property string $date
 */
class PostsRss extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'posts_rss';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'category', 'link'], 'required'],
            [['category'], 'integer'],
            [['title', 'source', 'link'], 'string', 'max' => 255],
            [['date'], 'string', 'max' => 125],
            [['link'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'category' => 'Category',
            'source' => 'Source',
            'link' => 'Link',
            'date' => 'Date',
        ];
    }
    /**
     * override the value of the variable $category - 
     * replace string received from the parser by category ID from the database
     */
    public function setCategory() {
        /**
         *
         * @todo make a separate config file for the default category ?!
         */
        $defaultCategory = 1;
        $category = Category::find()->all();
        $newCat = $this->strProcessing($this->category);
        $k = NULL;
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
            $this->category = $k;
        } else {
            $this->category = $defaultCategory;
        }
    }
    
    /**
     * string treatment
     * 
     * @param string $str
     * @return string
     */
    private function strProcessing($str) {
        $str = mb_strtolower($str);
        return trim($str);
    }

}
