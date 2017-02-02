<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Tags".
 *
 * @property integer $tag_id
 * @property string $tag
 */
class Tags extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Tags';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tag'], 'required'],
            [['tag'], 'string', 'max' => 45],
            [['tag'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'tag_id' => 'Tag ID',
            'tag' => 'Tag',
        ];
    }

}
