<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ImportForm extends Model {

    public $file;

    public function rules() {
        return [
            // name, email, subject and body are required
            [['file'], 'required'],
//             [['file'], 'file', 'extensions' => 'xls,xlsx'],
        ];
    }

}
