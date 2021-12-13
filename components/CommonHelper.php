<?php

namespace app\components;

use app\models\FeeDiscounts;
use app\models\FeeDiscountTypes;
use app\models\FeeParticulars;
use app\models\RefClass;
use app\models\search\FineType;
use app\models\Settings;
use app\models\SmsLog;
use Yii;
use yii\base\Component;
use app\models\search\FeeHeads;
use app\models\Branch;
use app\models\search\FeePlanType;
use app\models\RefSection;
use app\models\Session;
use app\models\RefGroup;
use app\models\User;
use app\models\StudentParentsInfo;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

class CommonHelper extends Component {

    //=========================================================//
    //                   Get branch Id                        //
    //=========================================================//
    public static function getBranch() {
        $branch = Session::find()->where(['user_id' => Yii::$app->user->id])->One();
        if ($branch && Yii::$app->user->id != '') {
            return $branch->fk_branch_id;
        } else {
            return false;
        }
    }

    public static function getNumberFormat($number, $dec = 0) {
        if ($number != 0) {
            return number_format($number, $dec);
        } else {
            return $number;
        }
    }

    //=========================================================//
    //                   Get branch detail                        //
    //=========================================================//
    public static function getBranchDetail() {
        $branch = Branch::find()->where(['id' => Yii::$app->common->getBranch()])->One();
        if ($branch && Yii::$app->user->id != '') {
            return $branch;
        } else {
            return false;
        }
    }

    //=========================================================//
    //                    get group                            //
    //=========================================================//
    public static function getGroup($class_id) {
        $data = RefGroup::find()->select(['group_id as id', 'title as name'])->where(['fk_class_id' => $class_id, 'fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active'])->asArray()->all();

        return $data;
    }

    //=========================================================//
    //                    get section                          //
    //=========================================================//
    public static function getSection($class_id, $group_id = null) {
        $data = RefSection::find()->select(['section_id as id', 'title as name'])->where(['class_id' => $class_id, 'fk_group_id' => $group_id, 'fk_branch_id' => Yii::$app->common->getBranch(), 'status' => 'active'])->asArray()->all();
        return $data;
    }

    //=========================================================//
    //                    get full name                        //
    //=========================================================//
    public static function getName($id) {
        $name = User::find()->where(['id' => $id])->One();
        if ($name) {
            $return_name = "";
            if ($name->first_name) {
                $return_name .= strtoupper($name->first_name);
            }if ($name->middle_name) {
                $return_name .= ' ' . strtoupper($name->middle_name);
            }if ($name->last_name) {
                $return_name .= ' ' . strtoupper($name->last_name);
            }
            return $return_name;
        } else {
            return false;
        }
    }

    //=========================================================//
    //                       get months                        //
    //=========================================================//

    public static function getMonthName($start_date, $end_date) {
        $start = (new \DateTime($start_date))->modify('first day of this month');
        $end = (new \DateTime($end_date))->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);
        $months = [];

        foreach ($period as $dt) {
            //echo $dt->format("Y-m") . "<br/><br/><br/>";
            if ($dt->format("Y-m") != date('Y-m')) {
                $months[] = $dt->format("F");
            }
        }
        return $months;
    }

    //=========================================================//
    //                   get parent full name                  //
    //=========================================================//
    public static function getParentName($id) {
        $name = StudentParentsInfo::find()->where(['stu_id' => $id])->one();
        if ($name) {
            $return_name = "";
            if ($name->first_name) {
                $return_name .= strtoupper($name->first_name);
            }if ($name->middle_name) {
                $return_name .= ' ' . strtoupper($name->middle_name);
            }if ($name->last_name) {
                $return_name .= ' ' . strtoupper($name->last_name);
            }
            return $return_name;
        } else {
            return false;
        }
    }

    //=========================================================//
    //                  Get Student Detail                      //
    //=========================================================//

    public static function getStudent($id) {
        $student = \app\models\StudentInfo::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'stu_id' => $id])->one();
        return $student;
    }

    //=========================================================//
    //                  Get Employee Detail                    //
    //=========================================================//
    public static function getEmployee($id) {
        $employee = \app\models\EmployeeInfo::find()->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'stu_id' => $id])->one();
        return $employee;
    }

    //=========================================================//
    //                  Trillium legends                      //
    //=========================================================//
    public static function getLegends($marks) {
        if ($marks >= 89.99) {
            return 'A+';
        } elseif ($marks >= 85 && $marks <= 89.99) {
            return 'A';
        } elseif ($marks >= 80 && $marks <= 84.99) {
            return 'A-';
        } elseif ($marks >= 75 && $marks <= 79.99) {
            return 'B+';
        } elseif ($marks >= 70 && $marks <= 74.99) {
            return 'B';
        } elseif ($marks >= 65 && $marks <= 69.99) {
            return 'B-';
        } elseif ($marks >= 60 && $marks <= 64.99) {
            return 'C+';
        } elseif ($marks >= 55 && $marks <= 59.99) {
            return 'C';
        } elseif ($marks >= 50 && $marks <= 54.99) {
            return 'D';
        } else {
            return 'F';
        }
    }

    //=========================================================//
    //           Get students Array helper branch wise.        //
    //=========================================================//
    public static function getBranchStudents() {
        $stuQuery = \app\models\User::find()
                        ->select(['student_info.stu_id', "concat(user.first_name, ' ' ,  user.last_name) as name"])
                        ->innerJoin('student_info', 'student_info.user_id = user.id')
                        ->where(['user.fk_branch_id' => Yii::$app->common->getBranch(), 'user.fk_role_id' => 3, 'user.status' => 'active'])->asArray()->all();
        $stuArray = ArrayHelper::map($stuQuery, 'stu_id', 'name');
        return $stuArray;
    }

    //=========================================================//
    //           Get employee Array helper branch wise.        //
    //=========================================================//
    public static function getBranchEmployee() {
        $stuQuery = User::find()
                        ->select(['employee_info.emp_id', "concat(user.first_name, ' ' ,  user.last_name) as name"])
                        ->innerJoin('employee_info', 'employee_info.user_id = user.id')
                        ->where(['user.fk_branch_id' => Yii::$app->common->getBranch(), 'user.fk_role_id' => 4])->asArray()->all();
        $stuArray = ArrayHelper::map($stuQuery, 'emp_id', 'name');
        return $stuArray;
    }

    //=========================================================//
    //           Get Fee Head Array helper branch wise.        //
    //=========================================================//
    public static function getBranchFeeHead() {

        $feeHeadArray = ArrayHelper::map(FeeHeads::find()->where(['fk_branch_id' => Yii::$app->common->getBranch()])->all(), 'id', 'title');
        return $feeHeadArray;
    }

    //=========================================================//
    //          Get Fee Plan Array helper branch wise.         //
    //=========================================================//

    public static function getBranchFeePlan() {

        $feePlanArray = ArrayHelper::map(FeePlanType::find()->where(['fk_branch_id' => Yii::$app->common->getBranch()])->all(), 'id', 'title');
        return $feePlanArray;
    }

    //=========================================================//
    //          Get Fine Type Array helper branch wise.        //
    //=========================================================//

    public static function getBranchFineType() {

        $feeTypeArray = ArrayHelper::map(FineType::find()->where(['fk_branch_id' => Yii::$app->common->getBranch()])->all(), 'id', 'title');
        return $feeTypeArray;
    }

    //=========================================================//
    //          Get Fee Discount Type Array helper branch wise.        //
    //=========================================================//

    public static function getBranchDiscountType() {

        $feeTypeArray = ArrayHelper::map(FeeDiscountTypes::find()->where(['fk_branch_id' => Yii::$app->common->getBranch()])->all(), 'id', 'title');
        return $feeTypeArray;
    }

    //=========================================================//
    //          Get Fee Discount Array helper branch wise.        //
    //=========================================================//

    public static function getBranchFeeDiscounts() {
        $query = FeeDiscounts::find()
                        ->select(['fee_discounts.id as id', 'fee_discount_types.title as name'])
                        ->innerJoin('fee_discount_types', 'fee_discount_types.id = fee_discounts.fk_fee_discounts_type_id')
                        ->where(['fee_discounts.fk_branch_id' => Yii::$app->common->getBranch()])->asArray()->all();

        $feeDiscountArray = ArrayHelper::map($query, 'id', 'name');
        return $feeDiscountArray;
    }

    //=========================================================//
    //    Get Fee Particulars Array helper branch wise.        //
    //=========================================================//

    public static function getBranchFeeParticulars() {
        $feearticularQuery = \app\models\FeeParticulars::find()
                        ->select(['fee_particulars.id', "concat(user.first_name, ' ' , user.last_name,'-',fee_plan_type.title,'-',fee_heads.title) as name "])
                        ->innerJoin('student_info', 'student_info.stu_id = fee_particulars.fk_stu_id')
                        ->innerJoin('user', 'user.id = student_info.user_id ')
                        ->innerJoin('fee_heads', 'fee_heads.id = fee_particulars.fk_fee_head_id')
                        ->innerJoin('fee_plan_type', 'fee_plan_type.id = fee_particulars.fk_fee_plan_type')
                        ->where(['fee_particulars.fk_branch_id' => Yii::$app->common->getBranch()])->asArray()->all();

        $feeparticualrArray = ArrayHelper::map($feearticularQuery, 'id', 'name');

        return $feeparticualrArray;
    }

    //=========================================================//
    //    Get student find detail  branch wise.                //
    //=========================================================//

    public static function getBranchStdFineDetail() {
        $stdFindDetailQuery = \app\models\StudentFineDetail::find()
                        ->select(['student_fine_detail.id as id', "concat(fine_type.title, '-' , student_fine_detail.amount) as name"])
                        ->innerJoin('fine_type', 'fine_type.id = student_fine_detail.fk_fine_typ_id')
                        ->where(['student_fine_detail.fk_branch_id' => Yii::$app->common->getBranch()])->asArray()->all();

        $stdfindDetailArray = ArrayHelper::map($stdFindDetailQuery, 'id', 'name');

        return $stdfindDetailArray;
    }

    //=========================================================//
    //                  Get Branch Settings                    //
    //=========================================================//

    public static function getBranchSettings() {
        $settings = Settings::find()->where(['fk_branch_id' => Yii::$app->common->getBranch()])->One();
        return $settings;
    }

    //=========================================================//
    //                  send sms funtion                   //
    //=========================================================//

    public static function SendSms($mbl, $msg, $studentId) {
        $smsModel = new SmsLog();
        /* $smsModel=new SmsLog();
          $smsModel->SMS_body=$msg;
          $useri=$smsModel->fk_user_id=$studentId;
          $smsModel->fk_branch_id=yii::$app->common->getBranch();
          $smsModel->sent_date_time=date("Y:m:d H:i:s");
          $smsModel->status='pending';
          if($smsModel->save()){}else{print_r($smsModel->getErrors());} */


        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL,"http://221.132.117.58:7700/sendsms_url.html"); 
        curl_setopt($ch, CURLOPT_URL, "http://119.160.92.2:7700/sendsms_url.html");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'Username=03028501396&Password=123.123&From=NewIslamia&To=' . $mbl . '&Message=' . $msg);
        /* http://119.160.92.2:7700/sendsms_url.html?Username=0300xxxxxx&Password=xxxxxxxx&From=Mask&To=0300xxxxxxxx&Message=Text */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);

        $smsModel->SMS_body = $msg;
        $useri = $smsModel->fk_user_id = $studentId;
        $smsModel->fk_branch_id = yii::$app->common->getBranch();
        $smsModel->sent_date_time = date("Y:m:d H:i:s");
        $server_output;
        $smsModel->status = "$server_output";
        if ($smsModel->save()) {
            //echo "saved";
        } else {
            print_r($smsModel->getErrors());
        }



        /* $model= SmsLog::find()->where(['fk_user_id'=>$useri])->one();
          if ($server_output == 'Message Sent Successfully!') {
          $model->status='success';

          return 'Successfully Send';
          } else {
          $model->status='fail';

          return 'fail';
          }
          $model->save(); */
    }

    //=========================================================//
    //                  get month interval                    //
    //=========================================================//

    public static function getMonthInterval($start_date, $end_date) {
        $start = (new \DateTime($start_date))->modify('first day of this month');
        $end = (new \DateTime($end_date))->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);
        $counter = 0;
        foreach ($period as $dt) {
            //echo $dt->format("Y-m") . "<br/><br/><br/>";
            if ($dt->format("Y-m") != date('Y-m')) {
                $counter++;
                //echo $dt->format("Y-m")."<br/>";
            } else {
                //echo $dt->format("Y-m")."<br/>";
            }
        }

        return $counter;
    }

    /* get student class group section */

    public static function getStudentCGSection($student_id) {
        /* get std details */
        $student = Yii::$app->common->getStudent($student_id);
        if ($student) {
            $CGS = $student->class->title;

            if ($student->group_id) {
                $CGS .= '-' . $student->group->title;
            }
            if ($student->section_id) {
                $CGS .= '-' . $student->section->title;
            }
            return $CGS;
        } else {
            return 'N/A';
        }
    }

    /* get Class group and section concatinated when passing classid-groupid-sectionid */

    public static function getCGSName($class_id, $group_id = null, $section) {
        $classtitle = RefClass::find()->select(['title'])->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'class_id' => $class_id])->one();
        $grouptitle = RefGroup::find()->select(['title'])->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'group_id' => ($group_id) ? $group_id : null])->one();
        $sectiontitle = RefSection::find()->select(['title'])->where(['fk_branch_id' => Yii::$app->common->getBranch(), 'section_id' => $section])->one();
        //echo '<pre>';print_r($grouptitle);die;
        $cgs = '';
        if (count($classtitle) > 0) {
            $cgs .= ucfirst($classtitle->title);
        }
        if (count($grouptitle) > 0) {
            $cgs .= ' - ' . ucfirst($grouptitle->title);
        }
        if (count($sectiontitle) > 0) {
            $cgs .= ' - ' . ucfirst($sectiontitle->title);
        }
        return $cgs;
    }

    /* multidimational search for student position based on std positon. */

    public static function multidimensional_search($parents, $searched) {
        if (empty($searched) || empty($parents)) {
            return false;
        }
        foreach ($parents as $key => $value) {
            $exists = true;
            foreach ($searched as $skey => $svalue) {
                $exists = ($exists && Isset($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
            }
            if ($exists) {
                return $parents[$key]['position'];
            }
        }
        return false;
    }

    public static function getTimeStampFormat($stamp) {
        if (isset($stamp)) {
            return date("F j, Y h:i:s A ", strtotime($stamp));
        } else {
            return $stamp;
        }
    }

    public static function createFolderStructure($type = 'users') {
        $path = 'uploads/' . $type;
        FileHelper::createDirectory($path);
        return $path;
    }

    public static function getLoginUserProfilePicture() {
        $image=Yii::$app->user->identity->Image;
        $path = Yii::$app->common->createFolderStructure() . '/' . $image;
        if (file_exists($path) && $image != null) {
            return Yii::$app->request->baseUrl . '/' . $path;
        } else {
            return Yii::$app->request->baseUrl . '/uploads/male.jpg';
        }
    }

    public static function getSlug($title = null) {
        if ($title != null) {
            return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', str_replace(' ', '-', preg_replace('/\s+/', ' ', $title)))));
        } else {
            return null;
        }
    }

}
