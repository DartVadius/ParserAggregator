<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property string $city_id
 * @property string $country_id
 * @property string $region_id
 * @property string $name
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'region_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => 'City ID',
            'country_id' => 'Country ID',
            'region_id' => 'Region ID',
            'name' => 'Name',
        ];
    }
}
