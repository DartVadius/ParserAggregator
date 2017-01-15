<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property string $region_id
 * @property string $country_id
 * @property string $city_id
 * @property string $name
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'city_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'country_id' => 'Country ID',
            'city_id' => 'City ID',
            'name' => 'Name',
        ];
    }
}
