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

}
