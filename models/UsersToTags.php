<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Users_to_tags".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tag_id
 * @property integer $count_tag
 */
class UsersToTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Users_to_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tag_id', 'count_tag'], 'required'],
            [['user_id', 'tag_id', 'count_tag'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tag_id' => 'Tag ID',
            'count_tag' => 'Count Tag',
        ];
    }
}
