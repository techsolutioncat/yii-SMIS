<?php
/**
 *Describe
 * @author zcy
 * @date 2019/8/13
 */

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class UploadExcelForm extends ActiveRecord
{
  public $file;

  public function rules()
  {
    return [
      [['file'],'file', 'skipOnEmpty' => false,'extensions' => 'xls,xlsx'],
    ];
  }

  public function attributeLabels()
  {
    return array(
      'file' =>'upload file '
    );
  }

  public function upload()
  {
    $file = UploadedFile::getInstance($this, 'file');

    if ($this->rules()) {
        // $tmp_file = $file->baseName . '.' . $file->extension;
        $tmp_file = date('YmdHis') . '.' . $file->extension;
        $path = 'uploads/excel/';
        if (is_dir($path)) {
            $file->saveAs($path . $tmp_file);
        } else {
            mkdir($path, 0777, true);
        }
        $file->saveAs($path . $tmp_file);
            return true;
        } else {
            Return 'validation failed';
        }
    }

}