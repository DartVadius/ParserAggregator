<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_history".
 *
 * @property string $id
 * @property string $tags
 * @property integer $post_id
 * @property integer $counter
 */
class UserHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tags', 'post_id', 'counter'], 'required'],
            [['tags'], 'string'],
            [['post_id', 'counter'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tags' => 'Tags',
            'post_id' => 'Post ID',
            'counter' => 'Counter',
        ];
    }
}
