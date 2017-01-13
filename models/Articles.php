<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Articles".
 *
 * @property integer $article_id
 * @property string $title
 * @property string $text
 * @property string $article_create_datetime
 * @property string $link_to_article
 * @property integer $category_id
 * @property string $Article_JSON
 * @property string $sourse
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'article_create_datetime', 'link_to_article', 'category_id', 'Article_JSON', 'sourse'], 'required'],
            [['text', 'Article_JSON'], 'string'],
            [['article_create_datetime'], 'safe'],
            [['category_id'], 'integer'],
            [['title', 'link_to_article', 'sourse'], 'string', 'max' => 255],
            [['link_to_article'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'Article ID',
            'title' => 'Title',
            'text' => 'Text',
            'article_create_datetime' => 'Article Create Datetime',
            'link_to_article' => 'Link To Article',
            'category_id' => 'Category ID',
            'Article_JSON' => 'Article  Json',
            'sourse' => 'Sourse',
        ];
    }
}
