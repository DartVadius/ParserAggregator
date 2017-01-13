<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Images".
 *
 * @property integer $image_id
 * @property string $link_to_image
 * @property integer $article_id
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_to_image', 'article_id'], 'required'],
            [['article_id'], 'integer'],
            [['link_to_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'link_to_image' => 'Link To Image',
            'article_id' => 'Article ID',
        ];
    }
}
