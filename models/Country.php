<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $country_id
 * @property integer $city_id
 * @property string $name
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'name' => 'Name',
        ];
    }
}
