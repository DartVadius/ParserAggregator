<?php
namespace app\models;

use mdm\admin\models\form\Signup as SignupForm;

class Signup extends SignupForm
{
    public $captcha;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['captcha', 'required'];
        $rules[] = ['captcha', 'captcha'];
        return $rules;
    }
}