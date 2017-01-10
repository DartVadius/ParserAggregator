<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Agregator extends \yii\db\ActiveRecord
{
    public static function tableName(){
        return 'posts_rss';
    }

    public static function getAll()
    {
       $data = self::find()->all();
        return $data;
    }
}