<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Comments".
 *
 * @property integer $comment_id
 * @property string $text
 * @property integer $user_id
 * @property integer $article_id
 * @property integer $comment_parrent_id
 * @property string $comment_create_datetime
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'user_id', 'article_id', 'comment_parrent_id', 'comment_create_datetime'], 'required'],
            [['user_id', 'article_id', 'comment_parrent_id'], 'integer'],
            [['comment_create_datetime'], 'safe'],
            [['text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'text' => 'Text',
            'user_id' => 'User ID',
            'article_id' => 'Article ID',
            'comment_parrent_id' => 'Comment Parrent ID',
            'comment_create_datetime' => 'Comment Create Datetime',
        ];
    }
}
