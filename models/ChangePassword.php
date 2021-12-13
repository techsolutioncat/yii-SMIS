<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePassword extends Model {

    public $password;
    public $verifypassword;

    public function rules() {
        return [
            // name, email, subject and body are required
            [['password', 'verifypassword'], 'required'],
            ['verifypassword', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return [
            'password' => "New Password",
            'verifypassword' => "Retype New Password",
            ];
    }

}
