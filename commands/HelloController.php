<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use Yii;
use app\models\User;
use app\models\EmployeeAttendance;
use app\models\StudentAttendance;
use yii\helpers\ArrayHelper;
use app\models\WorkingDays;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }
    
    
    
    public function actionMake(){
        // root of directory yii2
        // /var/www/html/<yii2>



        $stuQuery = User::find()
            ->select(['employee_info.emp_id',"concat(user.first_name, ' ' ,  user.last_name) as name"])
            ->innerJoin('employee_info','employee_info.user_id = user.id')
            ->where(['user.fk_role_id'=>4])->asArray()->all();
        $stuArray = ArrayHelper::map($stuQuery,'emp_id','name');
        $GetWorkingdays=WorkingDays::find()->select('title')->where(['is_active'=>1,'fk_branch_id'=>1,'title'=>date("D")])->one();
        $day=$GetWorkingdays->title;
        //if($GetWorkingdays){
        
        //echo '<pre>';print_r($stuArray);
        //$us=User::find()->where(['fk_role_id'=>'4'])->All();
        foreach ($stuQuery as $users){
        
            //echo count($users->id);
           
       // echo ($users['emp_id']);die;
             $mdl= new EmployeeAttendance;
             //$u_id=$users->id;
             $mdl->fk_empl_id=$users['emp_id'];
             
             $mdl->date=date("Y-m-d H:i:s");
             $mdl->leave_type='present';
             if($mdl->save()){
             //echo "yes";
             }else{
             print_r($mdl->getErrors());die;
             }
             
             }
        // }
             //die;
//             $mdl->date=date("Y:m:d");
//                 $mdl->leave_type='A';
//                 if($mdl->save()){
//            echo "yes";
//        }else{
//            print_r($model->getErrors());die;
//        }
//            
//        }
//        //echo '<pre>';print_r($us);die;
////        $model = new EmployeeAttendance();
////        $model->fk_empl_id=1;
////        $model->date=date("Y:m:d");
////        $model->leave_type='A';
////        if($model->save()){
////            echo "yes";
////        }else{
////            print_r($model->getErrors());die;
////        }
//        //$us=User::find()->one();
//        //echo $us->last_name;
//   // $connection->createCommand()->insert('employee_attendance', [
////    'fk_empl_id' => '1',
////    'date' => date('Y:m:d'),
////    'leave_type'=>'absent',
////])->execute();
//        die;
//        
//         $rootyii = realpath(dirname(__FILE__).'/..');
// 
//        // create file <hours:menu:seconds>.txt
//         $filename = date('H:i:s') . '.txt';
//         $folder = $rootyii.'/cronjob/'.$filename;
//        $f = fopen($folder, 's');
//        $fw = fwrite($f, 'now : ' . $filename);
//        fclose($f);
    }
    
    public function actionStu(){
        $stuQuery = \app\models\User::find()
            ->select(['student_info.stu_id',"concat(user.first_name, ' ' ,  user.last_name) as name"])
            ->innerJoin('student_info','student_info.user_id = user.id')
            ->where(['user.fk_role_id'=>3])->asArray()->all();
        $stuArray = ArrayHelper::map($stuQuery,'stu_id','name');

        $GetWorkingdays=WorkingDays::find()->select('title')->where(['is_active_stu'=>1,'fk_branch_id'=>1,'title'=>date("D")])->one();
        $day=$GetWorkingdays->title;
        
        foreach ($stuQuery as $users){
             $mdl= new StudentAttendance;
             $mdl->fk_stu_id=$users['stu_id'];
             $mdl->date=date("Y-m-d H:i:s");
            //$mdl->date=date('Y-m-d H:i:s', strtotime(' -3 day'));
             $mdl->leave_type='present';
             if($mdl->save()){
             }else{
             print_r($mdl->getErrors());die;
             }
             
             }
     }
     }
