<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Sites".
 *
 * @property integer $site_id
 * @property string $name
 * @property string $source
 * @property string $method_of_parsing
 * @property string $parsing_settings
 * @property integer $make_parsing
 */
class Sites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Sites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'source', 'method_of_parsing', 'parsing_settings'], 'required'],
            [['method_of_parsing', 'parsing_settings'], 'safe'],
            [['make_parsing'], 'integer'],
            [['name', 'source'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'site_id' => 'Site ID',
            'name' => 'Name',
            'source' => 'Source',
            'method_of_parsing' => 'Method Of Parsing',
            'parsing_settings' => 'Parsing Settings',
            'make_parsing' => 'Make Parsing',
        ];
    }
}
