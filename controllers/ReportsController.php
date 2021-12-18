<?php

namespace app\controllers;

use Yii;
use app\models\Exam;
use app\models\ExamType;
use app\models\RefGroup;
use app\models\RefSection;
use app\models\StudentInfo;
use app\models\search\RefDegreeTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use mPDF;
use app\models\StudentLeaveInfo;


/**
 * DegreeController implements the CRUD actions for RefDegreeType model.
 */
class ReportsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * @return Action statistics
     */
    public function actionStatistics()
    {
        $model = new StudentInfo();
        $request = Yii::$app->request;

       /* $query1=RefClass::find()->where(['fk_branch_id'=>yii::$app->common->getBranch()])->all();
        //print_r($query1);
        foreach ($query1 as $stu) {
            $cls=$stu['class_id'];
           $getclaswise=yii::$app->db->createCommand("select rc.title as `class_name`, count(*) as `total` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id not in (select fk_stu_id from stu_reg_log_association) and si.class_id=".$stu['class_id'])->queryAll();


           $promotedclaswise=yii::$app->db->createCommand("select rc.title as `class_name`, count(*) as `No_of_promoted_class_wise`  from student_info si
                inner join ref_class rc on rc.class_id=si.class_id
                where si.stu_id  in (select fk_stu_id from stu_reg_log_association)
                and si.class_id=".$cls)->queryAll();

           $newadmissnavrg=yii::$app->db->createCommand("select ((select count(*) from student_info si where si.stu_id not in (select fk_stu_id from stu_reg_log_association) and si.class_id='".$cls."') / (select count(*) from student_info) ) * 100 as `Average_of_New_admission`")->queryAll();

           $promotedStud=yii::$app->db->createCommand("select ((select count(*) from student_info si where si.stu_id in (select fk_stu_id from stu_reg_log_association) and si.class_id='".$cls."') / (select count(*) from student_info) ) * 100 as `Average_of_Promoted_students`")->queryAll();
          }
          */

          $getclaswise=yii::$app->db->createCommand("SELECT rc.title, count(*) as `No_of_students` FROM student_info si2 inner join ref_class rc on rc.class_id=si2.class_id where si2.fk_branch_id=".yii::$app->common->getBranch()." and si2.is_active =1 and si2.stu_id not in (select fk_stu_id from stu_reg_log_association) group by rc.title")->queryAll();

                
          /*$getclaswiseDeactive=yii::$app->db->createCommand("select rc.class_id, rc.title as `class_name`,  count(*)as `No_of_new_admission_class_wise` from student_info  si
                inner join ref_class rc on rc.class_id=si.class_id
                where stu_id not in ( select fk_stu_id from stu_reg_log_association) and rc.status='active' and si.is_active=0 and rc.fk_branch_id='".yii::$app->common->getBranch()."'
                group by rc.class_id,rc.title")->queryAll();*/

         $getclaswiseDeactive=yii::$app->db->createCommand("SELECT rc.title, count(*) as `No_of_students` FROM student_info si2 inner join ref_class rc on rc.class_id=si2.class_id where si2.fk_branch_id=".yii::$app->common->getBranch()." and si2.is_active =0 and si2.stu_id not in (select fk_stu_id from stu_reg_log_association) group by rc.title")->queryAll();


          $promotedclaswise=yii::$app->db->createCommand("select rc.title as `class_name`, count(*) as `No_of_new_promoted_class_wise` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.fk_branch_id=".yii::$app->common->getBranch()." and si.stu_id in (select fk_stu_id from stu_reg_log_association) GROUP by rc.title")->queryAll();

         

          /*$newadmisnAvg=yii::$app->db->createCommand("select abc.class_name,abc.No_Of_Student, ((abc.No_Of_Student)/ (select count(*) from student_info))*100 as `Average_Newly_Admitted_Students_per_Class` from (select rc.title as `class_name`, count(*) as `No_Of_Student` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id not in (select fk_stu_id from stu_reg_log_association) and si.is_active=1 GROUP by rc.title)abc
                ")->queryAll();*/

           /*$getAllClasses=RefClass::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'status'=>'active'])->all();
           foreach ($getAllClasses as $allclass) {
             
           $newadmisnAvg=yii::$app->db->createCommand("select abc.class_id,abc.class_name,abc.No_Of_Student as `No_of_student_newly_admitted`, ( (abc.No_Of_Student) / (SELECT count(*) FROM student_info si2 inner join ref_class rc on rc.class_id=si2.class_id where si2.fk_branch_id=9 and rc.title= '".$allclass->title."' and si2.is_active =1) ) * 100 as `Percentage_of_newly_admitted_student` from (select rc.class_id, rc.title as class_name, count(*) as `No_Of_Student` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id not in (select fk_stu_id from stu_reg_log_association) and title = '".$allclass->title."' and si.fk_branch_id=9 and si.is_active = 1 GROUP by rc.class_id, rc.title) abc")->queryAll();
               echo '<pre>';print_r($newadmisnAvg);continue;
          }
          die;*/
           
           

                


           //$newAdmsnView=$this->renderAjax('statistics/new-admsn-avrg',['newadmisnAvg'=>$newadmisnAvg]);
             // exit;

          $promtedclasswixeAvg=yii::$app->db->createCommand("select abc.class_name,abc.No_Of_Student, ((abc.No_Of_Student)/ (select count(*) from student_info))*100 as `Average_Promoted_Students_per_Class` from (select rc.title as `class_name`, count(*) as `No_Of_Student` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id in (select fk_stu_id from stu_reg_log_association) and si.is_active=1 GROUP by rc.title)abc")->queryAll();

        
            return $this->render('statistics', [
                'getclaswise' => $getclaswise,
                'promotedclaswise' => $promotedclaswise,
                //'newadmissnavrg' => $newadmissnavrg,
                //'promotedStud' => $promotedStud,
                //'newadmisnAvg' => $newadmisnAvg,
                'promtedclasswixeAvg' => $promtedclasswixeAvg,
                'getclaswiseDeactive' => $getclaswiseDeactive,
                //'admsnArray'=>$admsnArray,
                'model' => $model,
                ]);
    }

    /**
     * @return Action widthdrawn students withdrawal-student
     */
   /* public function actionTransport()
    {  

        $transport=yii::$app->db->createCommand("select si.stu_id,concat (u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name`,z.title as `zone_name`,r.title as `route_name`, s.title as `stop_name`,s.fare as `fare` from student_info si
            inner join user u on u.id=si.user_id
            inner join stop s on s.id=si.fk_stop_id
            inner join route r on r.id=s.fk_route_id
            inner join zone z on z.id=r.fk_zone_id
            ")->queryAll();
        

        return json_encode(['viewtransport'=>$viewtransport]);

    }*/


    

    /*
     * @return Action Acadamics
    */
    public function actionAcademics()
    {

        $model = new \app\models\Exam();


        return $this->render('academics', [
            'model'    =>$model,
        ]);
    }

    public function actionShowOverall()
    {
         $start= Yii::$app->request->post('start');
         $end = Yii::$app->request->post('end');

         $startcnvrt=date('Y-m-d',strtotime($start));
         $endcnvrt=date('Y-m-d',strtotime($end));
         $query=yii::$app->db->createCommand("
                select count(DISTINCT(sa.fk_stu_id)) as total,sa.leave_type from student_attendance sa inner join student_info si on si.stu_id=sa.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id left join ref_section rs on rs.section_id=si.section_id where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1 and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' group by sa.leave_type
            ")->queryAll();
         //echo '<pre>';print_r($query);
         $overallView=$this->renderPartial('statistics/overall',['query'=>$query]);

         return json_encode(['overallview'=>$overallView]);
         


        
    }

    public function actionShowCls()
    {
         $start= Yii::$app->request->post('start');
         $end = Yii::$app->request->post('end');
         $class = Yii::$app->request->post('cls');
         $grp = Yii::$app->request->post('grp');
         $section = Yii::$app->request->post('sectn');

         $startcnvrt=date('Y-m-d',strtotime($start));
         $endcnvrt=date('Y-m-d',strtotime($end));
        if(!empty($class) && empty($grp) && empty($section)){
            //echo '1';
            $where = "where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1  and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and rc.class_id=".$class." and sa.leave_type <>'present' 
                group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type";
        }else if(!empty($class) && !empty($grp) && empty($section)){
            //echo '2';

            $where = "where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1  and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and rc.class_id=".$class." and rg.group_id =".$grp."  and sa.leave_type <>'present'
                group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type";
        }else if(!empty($class) && !empty($grp) && !empty($section)){
           // echo '3';

            $where = "where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1  and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and rc.class_id='".$class."' and rg.group_id =".$grp."  and sa.leave_type <>'present'  and rs.section_id=".$section."
                group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type";
        }

        else{
           // echo '4';
            $where="";
            /*$where = "where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1  and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and sa.leave_type <>'present'
                group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type";*/
        }
        if(empty($where)){}else{
         
         $query=yii::$app->db->createCommand("
                select count(sa.leave_type) as total,rc.class_id,rc.title,rg.group_id,rg.title as group_title,rs.section_id,rs.title as section_title,sa.leave_type from student_attendance sa 
                inner join student_info si on si.stu_id=sa.fk_stu_id
                inner join ref_class rc on rc.class_id=si.class_id 
                left join ref_group rg on rg.group_id=si.group_id
                left join ref_section rs on rs.section_id=si.section_id
                
            ".$where )->queryAll();
 }
        // echo $query;die;getRawSql
         if(count($query) > 0){
         $overallViewCls=$this->renderPartial('statistics/overallClass',['query'=>$query]);

         }else{
            $overallViewCls = 'Not Found';
         }
         //echo '<pre>';print_r($overallViewCls);

         return json_encode(['overallclass'=>$overallViewCls]);
         


        
    }


    public function actionShowGroups()
    {
         $start= Yii::$app->request->post('start');
         $end = Yii::$app->request->post('end');
         $grp = Yii::$app->request->post('grp');

         $startcnvrt=date('Y-m-d',strtotime($start));
         $endcnvrt=date('Y-m-d',strtotime($end));
         $query=yii::$app->db->createCommand("
                select count(sa.leave_type),rc.class_id,rc.title,rg.group_id,rg.title,sa.leave_type from student_attendance sa inner join student_info si on si.stu_id=sa.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1 and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and rc.class_id=11 and sa.leave_type <>'present' and rg.group_id=7 group by rc.class_id,rc.title,rg.group_id,rg.title,sa.leave_type
            ")->queryAll();
         if(count($query) > 0){
         $overallViewCls=$this->renderPartial('statistics/overallgrp',['query'=>$query]);

         }else{
            $overallViewCls = 'Not Found';
         }
         //echo '<pre>';print_r($query);

         return json_encode(['overallgrps'=>$overallViewCls]);
         


        
    }


    public function actionGetSection()
    {
        $class_id=Yii::$app->request->post('id');

        $group_id = Yii::$app->request->post('depdrop_all_params')['group-id'];
        if (!empty($class_id)) {
            $count_group = RefGroup::find()->where(['fk_class_id'=>$class_id,'fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->count();
            if($count_group ==0){
                $out = Yii::$app->common->getSection($class_id,Null);
                return   Json::encode(['output'=>$out, 'selected'=>'']);
            }else{
                return false;
            }
        }
        elseif(!empty($class_id) && !empty($group_id)){
            $out = Yii::$app->common->getSection($class_id,$group_id);
            return   Json::encode(['output'=>$out, 'selected'=>'']);
        } else{
            $count_group = RefGroup::find()->where(['fk_class_id'=>$class_id,'fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->count();
            if($count_group ==0){
                $out = Yii::$app->common->getSection($class_id,Null);
                return   Json::encode(['output'=>$out, 'selected'=>'']);
            }else{
                return false;
            }
        }

    }


    /*public function actionGetClasses(){
    
        $class_id=Yii::$app->request->post('id');
        $group_id=Yii::$app->request->post('group_id');
       


        if (!empty($class_id) && empty($group_id)) {
            $count_group = RefGroup::find()->where(['fk_class_id'=>$class_id,'fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->count();
            if($count_group ==0){
                $out = Yii::$app->common->getSection($class_id,Null);
                return   json_encode(['output'=>$out, 'selected'=>'']);
            }else{
                return false;
            }
        }
        elseif(!empty($class_id) && !empty($group_id)){
            $out = Yii::$app->common->getSection($class_id,$group_id);
            return   json_encode(['output'=>$out, 'selected'=>'']);
        } else{
            $count_group = RefGroup::find()->where(['fk_class_id'=>$class_id,'fk_branch_id'=>Yii::$app->common->getBranch(),'status'=>'active'])->count();
            if($count_group ==0){
                $out = Yii::$app->common->getSection($class_id,Null);
                return json_encode(['output'=>$out, 'selected'=>'']);
            }else{
                return false;
            }
        }
    }*/
    public function actionGetClasses(){
    
        $id=Yii::$app->request->post('id');
        $group=RefGroup::find()->where(['fk_class_id'=>$id,'fk_branch_id'=>yii::$app->common->getBranch()])->all();
        $section=RefSection::find()->where(['class_id'=>$id,'fk_branch_id'=>yii::$app->common->getBranch()])->all();
        if(!empty($group)){
           $options = "<option value=''>Select Group</option>";
        foreach($group as $group)
        {
            $options .= "<option value='".$group->group_id."'>".$group->title."</option>";
        }
        return json_encode(['notempty'=>$options]);
        }else{
           $optionsSectn = "<option value=''>Select Group</option>";
        foreach($section as $sectionxx)
        {
            $optionsSectn .= "<option value='".$sectionxx->section_id."'>".$sectionxx->title."</option>";
        }
        return json_encode(['notempty'=>$optionsSectn]);

        }

        


        

    
   }

    /* public function actionGetClasses(){
    
        $id=Yii::$app->request->post('id');
        $group=RefGroup::find()->where(['fk_class_id'=>$id,'fk_branch_id'=>yii::$app->common->getBranch()])->all();

        $options = "<option value=''>Select Group</option>";
        foreach($group as $group)
        {
            $options .= "<option value='".$group->group_id."'>".$group->title."</option>";
        }
        return $options;

    
   }*///end of classes

   public function actionGetSections(){

        $id=Yii::$app->request->post('id');
        $section=RefSection::find()->where(['fk_group_id'=>$id])->all();
        $options= "<option value=''>Select Section</option>";
       foreach($section as $section)
       {
        $options .= "<option value='".$section->section_id."'>".$section->title."</option>";
        }
        return $options;
        }//end of Section

        public function actionTest(){
      $request = Yii::$app->request;
        $model = new StudentInfo();
        /*
        *   Process for non-ajax request
        */
        return $this->render('test', [
            'model' => $model,
        ]);
    }


    // transport
    public function actionGetZoneGeneric(){
         $zoneQuery=yii::$app->db->createCommand("select count(si.stu_id) as `no_of_students_availed_transport`,z.id as `zone_id`,z.title as `zone_name` from student_info si inner join stop s on s.id=si.fk_stop_id inner join route r on r.id=s.fk_route_id inner join zone z on z.id=r.fk_zone_id WHERE si.fk_branch_id=".yii::$app->common->getBranch()." AND si.is_active=1 group by z.id,z.title")->queryAll();

        $zoneView=$this->renderAjax('statistics/zone-generic',['zone'=>$zoneQuery]);

        return json_encode(['zonegenric'=>$zoneView]);
    }

     public function actionGetZoneGenericPdf(){
        $zoneQuery=yii::$app->db->createCommand("select count(si.stu_id) as `no_of_students_availed_transport`,z.id as `zone_id`,z.title as `zone_name` from student_info si inner join stop s on s.id=si.fk_stop_id inner join route r on r.id=s.fk_route_id inner join zone z on z.id=r.fk_zone_id WHERE si.fk_branch_id=".yii::$app->common->getBranch()." AND si.is_active=1 group by z.id,z.title")->queryAll();
        $zoneView=$this->renderAjax('statistics/zone-generic-pdf',['zone'=>$zoneQuery]);

        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Over All Transport Zone Wise</h3>");
        $mpdf->WriteHTML($zoneView);
        $mpdf->Output('overall-transport-zone-wise-'.date("d-m-Y").'.pdf', 'D'); 


     }

    public function actionGetrouteZonewise(){
        $zoneid=yii::$app->request->post('zoneid');
        $routeQuery=yii::$app->db->createCommand("select count(si.stu_id) as `no_of_students_availed_transport`,z.id as `zone_id`,z.title as `zone_name`,r.id as `route_id`,r.title as `route_name` from student_info si inner join stop s on s.id=si.fk_stop_id inner join route r on r.id=s.fk_route_id inner join zone z on z.id=r.fk_zone_id WHERE si.fk_branch_id=".yii::$app->common->getBranch()." AND si.is_active=1 and z.id=".$zoneid." group by z.id,z.title,r.id,r.title")->queryAll();
          // echo '<pre>';print_r($routeQuery);die;

        $routeView=$this->renderAjax('statistics/route-zone',['route'=>$routeQuery,'zoneid'=>$zoneid]);

        return json_encode(['zoneRoutes'=>$routeView]);
    }

    public function actionGetroutewisePdf(){
        $zoneid=yii::$app->request->get('zoneid');
        $routeQuery=yii::$app->db->createCommand("select count(si.stu_id) as `no_of_students_availed_transport`,z.id as `zone_id`,z.title as `zone_name`,r.id as `route_id`,r.title as `route_name` from student_info si inner join stop s on s.id=si.fk_stop_id inner join route r on r.id=s.fk_route_id inner join zone z on z.id=r.fk_zone_id WHERE si.fk_branch_id=".yii::$app->common->getBranch()." AND si.is_active=1 and z.id=".$zoneid." group by z.id,z.title,r.id,r.title")->queryAll();
          // echo '<pre>';print_r($routeQuery);die;

        $routeView=$this->renderAjax('statistics/route-zone-pdf',['route'=>$routeQuery]);

        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Over All Transport route Wise</h3>");
        $mpdf->WriteHTML($routeView);
        $mpdf->Output('overall-transport-route-wise-'.date("d-m-Y").'.pdf', 'D'); 

        return json_encode(['zoneRoutes'=>$routeView]);
    }


    public function actionGetstopRoutewise(){
        $routeid=yii::$app->request->post('routeid');
        $zoneid=yii::$app->request->post('zoneid');
        $stopQuery=yii::$app->db->createCommand("select count(si.stu_id) as `no_of_students_availed_transport`,z.id as `zone_id`,z.title as `zone_name`,r.id as `route_id`,r.title as `route_name`,s.id as ` stop_id`,s.title as `stop_name` from student_info si inner join stop s on s.id=si.fk_stop_id inner join route r on r.id=s.fk_route_id inner join zone z on z.id=r.fk_zone_id WHERE si.fk_branch_id=".yii::$app->common->getBranch()." AND si.is_active=1 and z.id=".$zoneid." and r.id=".$routeid." group by z.id,z.title,r.id,r.title,s.id,s.title")->queryAll();
          // echo '<pre>';print_r($routeQuery);die;

        $stopView=$this->renderAjax('statistics/stop-route',['stop'=>$stopQuery,'routeid'=>$routeid,'zoneid'=>$zoneid]);

        return json_encode(['stopRoutes'=>$stopView]);
    }


    public function actionGetstopRoutewisePdf(){
         $routeid=yii::$app->request->get('routeid');
         $zoneid=yii::$app->request->get('zoneid');
        $stopQuery=yii::$app->db->createCommand("select count(si.stu_id) as `no_of_students_availed_transport`,z.id as `zone_id`,z.title as `zone_name`,r.id as `route_id`,r.title as `route_name`,s.id as ` stop_id`,s.title as `stop_name` from student_info si inner join stop s on s.id=si.fk_stop_id inner join route r on r.id=s.fk_route_id inner join zone z on z.id=r.fk_zone_id WHERE si.fk_branch_id=".yii::$app->common->getBranch()." AND si.is_active=1 and z.id=".$zoneid." and r.id=".$routeid." group by z.id,z.title,r.id,r.title,s.id,s.title")->queryAll();
           

        $stopView=$this->renderAjax('statistics/stop-route-pdf',['stop'=>$stopQuery]);

        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Over All Transport stop Wise</h3>");
        $mpdf->WriteHTML($stopView);
        $mpdf->Output('overall-transport-stop-wise-'.date("d-m-Y").'.pdf', 'D'); 



        

        //return json_encode(['stopRoutes'=>$stopView]);
    }

    public function actionGetstudentStopwise(){
        $stopid=yii::$app->request->post('stopid');
      //  $zoneid=yii::$app->request->post('zoneid');
        $stuQuery=yii::$app->db->createCommand("select DISTINCT(si.stu_id),concat (u.first_name,' ',u.middle_name,' ',u.last_name) as student_name, concat(spi.first_name,' ',spi.middle_name,' ',spi.last_name) as `father_name`,rc.title as `class_name`,rg.title as `group_name`,rs.title as `section_name`,si.contact_no, si.emergency_contact_no,z.title as `zone_name`,r.title as `route_name`, s.title as `stop_name` from student_info si inner join student_parents_info spi on spi.stu_id=si.stu_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id left join ref_section rs on rs.section_id=si.section_id inner join user u on u.id=si.user_id inner join stop s on s.id=si.fk_stop_id inner join route r on r.id=s.fk_route_id inner join zone z on z.id=r.fk_zone_id inner join transport_main tm on tm.fk_route_id=r.id inner join vehicle_info vi on vi.id=tm.fk_vechicle_info_id where si.fk_branch_id=".yii::$app->common->getBranch()." and si.is_active=1 and vi.Name like 'Bus%' and s.id=".$stopid."")->queryAll();
           //echo '<pre>';print_r($stuQuery);die;

        $stuView=$this->renderAjax('statistics/student-stop',['student'=>$stuQuery]);

        return json_encode(['stuView'=>$stuView]);
    }
    // end of transport



    /**
     * @return Action Finances
     */
    public function actionFinances()
    {
        
        return $this->render('finances', [
        ]);
    }


    public function actionOverllCashFlow(){
         $start= Yii::$app->request->post('start');
         $end = Yii::$app->request->post('end');

         $startcnvrt=date('Y-m-d',strtotime($start));
         $endcnvrt=date('Y-m-d',strtotime($end));
         $query=yii::$app->db->createCommand("
                select fhw.fk_branch_id,CAST(fcr.transaction_date AS DATE) AS DATE_PURCHASED,dayname(fcr.transaction_date), sum(fhw.payment_received) as `fee_received`,MIN(fhw.fk_chalan_id) from fee_head_wise fhw inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and CAST(fcr.transaction_date AS DATE) >= '".$startcnvrt."' and CAST(fcr.transaction_date AS DATE) <= '".$endcnvrt."' GROUP by fhw.fk_branch_id, CAST(fcr.transaction_date AS DATE),dayname(fcr.transaction_date)
            ")->queryAll();

         

        //echo $query;die;
         //echo '<pre>';print_r($query);die;
         if(count($query)>0){
         $cashflowView=$this->renderAjax('finance/cashflow',['query'=>$query,'startcnvrt'=>$startcnvrt,'endcnvrt'=>$endcnvrt]);
     }else{
         $cashflowView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
     }
         return json_encode(['cashflowhere'=>$cashflowView]);
     
     }

    public function actionOverllCashFlowPdf(){
         $start= Yii::$app->request->get('start');
         $end = Yii::$app->request->get('end');

         $startcnvrt=date('Y-m-d',strtotime($start));
         $endcnvrt=date('Y-m-d',strtotime($end));
         $query=yii::$app->db->createCommand("
                select fhw.fk_branch_id,CAST(fcr.transaction_date AS DATE) AS DATE_PURCHASED,dayname(fcr.transaction_date), sum(fhw.payment_received) as `fee_received`,MAX(fhw.transport_fare) as transport_fare from fee_head_wise fhw inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and CAST(fcr.transaction_date AS DATE) >= '".$startcnvrt."' and CAST(fcr.transaction_date AS DATE) <= '".$endcnvrt."' GROUP by fhw.fk_branch_id, CAST(fcr.transaction_date AS DATE),dayname(fcr.transaction_date)
            ")->queryAll();
         //echo $query;die;
         //echo '<pre>';print_r($query);
         if(count($query)>0){
         $cashflowView = $this->renderPartial('finance/cashflowpdf',['query'=>$query,'startcnvrt'=>$startcnvrt,'endcnvrt'=>$endcnvrt]);
 
          $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $mpdf->WriteHTML("<h3 style='text-align:center'>Daily Cash Flow</h3>");
        $mpdf->WriteHTML($cashflowView);
        $mpdf->Output('daily-cash-flow-'.date("d-m-Y").'.pdf', 'D');

         }else{
             $cashflowView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
             return json_encode(['cashflowhere'=>$cashflowView]);
         }
         
     
     }

     /*student ledger pdf*/
    public function actionStudentLedgerPdf()
    {
        if(Yii::$app->request->get()){
            $stu_id = Yii::$app->request->get('stu_id');
            $class_id = Yii::$app->request->get('class_id');
            $getStudentInfo = Yii::$app->common->getStudent($stu_id);
            $getStu=$getStudentInfo->user_id;
            $studentName= Yii::$app->common->getName($getStudentInfo->user_id);

            $getChalans=Yii::$app->db->createCommand("select fhw.fk_branch_id,fhw.fk_stu_id, ftd.challan_no,ftd.id,ftd.manual_recept_no,ftd.transaction_date as `fee_submission_date` from fee_head_wise fhw inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id where fhw.fk_stu_id=".$stu_id." and fhw.fk_branch_id=".Yii::$app->common->getBranch()." GROUP BY fhw.fk_branch_id,ftd.id, ftd.challan_no, ftd.transaction_date")->queryAll();

            //echo $query;die;
            //echo '<pre>';print_r($query);
            if(count($getStudentInfo)>0){
                $stuView=$this->renderPartial('finance/student-ledger',['stu_id'=>$stu_id,'getStudentInfo'=>$getStudentInfo,'userid'=>$getStu,'getChalans'=>$getChalans]);
                $this->layout = 'pdf';
                $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                $stylesheet = file_get_contents('css/std-ledger-pdf.css');
                $mpdf->WriteHTML($stylesheet,1);
                $mpdf->WriteHTML("<h3 style='text-align:center'>Student Ledger</h3>");
                $mpdf->WriteHTML($stuView,2);
                $mpdf->Output('Student-Ledger-'.$getStudentInfo->class->title.'-'.$studentName.'-'.date("d-m-Y").'.pdf', 'D');
            }else{
                $stuView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
            }
                     }
    }

    public function actionGetStuClasswise(){
        $class_id=intval(yii::$app->request->post('id'));
        $getStu=StudentInfo::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'class_id'=>$class_id])->all();

        /*$getStu = \app\models\User::find()
            ->select(['student_info.stu_id',"concat(user.first_name, ' ' ,  user.last_name) as name"])
            ->innerJoin('student_info','student_info.user_id = user.id')
            ->where(['user.fk_branch_id'=>Yii::$app->common->getBranch(),'user.fk_role_id'=>3,'student_info.class_id'=>$class_id,'student_info.is_active'=>1])->asArray()->all();*/
            //echo '<pre>';print_r($getStu);die;

        $option="<option>Select Students</option>";
        foreach ($getStu as $getStudents) {
            $option.="<option value=".$getStudents->stu_id.">".Yii::$app->common->getName($getStudents->user_id)."</option>";
        }
   

        return json_encode(['studata'=>$option]);

     }

    public function actionShowStuData(){
         $stu_id= Yii::$app->request->post('stu_id');

        /* $getStudentInfo=Yii::$app->db->createCommand("select si.stu_id as `student id`, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name`,rc.title as `class_name`,rg.title as `group_name`,rs.title as `section_name`from student_info si
            inner join user u  on u.id=si.user_id
            inner join ref_class rc on rc.class_id=si.class_id
            inner join ref_group rg on rg.group_id=si.group_id
            inner join ref_section rs on rs.section_id=si.section_id
            where si.stu_id=".$stu_id)->queryAll();*/

            $getStudentInfo=StudentInfo::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'stu_id'=>$stu_id])->one();
            $getStu=$getStudentInfo->user_id;
             $father=$getStudentInfo->stu_id;

           $getChalans=Yii::$app->db->createCommand("select fhw.fk_branch_id,fhw.fk_stu_id, ftd.challan_no,ftd.id,ftd.manual_recept_no,ftd.transaction_date as `fee_submission_date` from fee_head_wise fhw inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id where fhw.fk_stu_id=".$stu_id." and fhw.fk_branch_id=".Yii::$app->common->getBranch()." GROUP BY fhw.fk_branch_id,ftd.id, ftd.challan_no, ftd.transaction_date")->queryAll();

         //echo $getChalans;die;
         //echo '<pre>';print_r($query);
         if(count($getStudentInfo)>0){
         $stuView=$this->renderAjax('finance/student-ledger',['stu_id'=>$stu_id,'father'=>$father,'getStudentInfo'=>$getStudentInfo,'userid'=>$getStu,'getChalans'=>$getChalans]);
     }else{
         $stuView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
     }
         return json_encode(['studatas'=>$stuView,'countChallan'=>count($getChalans)]);
     
     }     

   /*student wise report*/
    public function actionShowStuDataHeadReport(){
        $stu_id= Yii::$app->request->post('stu_id');

        /* $getStudentInfo=Yii::$app->db->createCommand("select si.stu_id as `student id`, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name`,rc.title as `class_name`,rg.title as `group_name`,rs.title as `section_name`from student_info si
            inner join user u  on u.id=si.user_id
            inner join ref_class rc on rc.class_id=si.class_id
            inner join ref_group rg on rg.group_id=si.group_id
            inner join ref_section rs on rs.section_id=si.section_id
            where si.stu_id=".$stu_id)->queryAll();*/

        $getStudentInfo=StudentInfo::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'stu_id'=>$stu_id])->one();
        $getStu=$getStudentInfo->user_id;

        $getChalans=Yii::$app->db->createCommand("select fhw.fk_branch_id,fhw.fk_stu_id,ftd.manual_recept_no,ftd.id,ftd.manual_recept_no,ftd.transaction_date as `fee_submission_date` from fee_head_wise fhw inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id where fhw.fk_stu_id=".$stu_id." and fhw.fk_branch_id=".Yii::$app->common->getBranch()." GROUP BY fhw.fk_branch_id,ftd.id,ftd.manual_recept_no, ftd.transaction_date")->queryAll();

        //echo $getChalans;die;
        //echo '<pre>';print_r($getChalans);die;
        if(count($getStudentInfo)>0){
            $stuView=$this->renderAjax('finance/show-student-data-head-report',['stu_id'=>$stu_id,'getStudentInfo'=>$getStudentInfo,'userid'=>$getStu,'getChalans'=>$getChalans]);
        }else{
            $stuView= "<div class='row'><div class='Alert alert-warning'><strong>Receipt Not Found!</strong></div> </div>";
        }
        return json_encode(['studatas'=>$stuView,'countChallan'=>count($getChalans)]);

    }

 /*get student headwise*/
    public function actionGetStuReceiptWise(){
        $class_id=intval(yii::$app->request->post('id'));
        $getStu=StudentInfo::find()->Select(['stu_id','class_id','section_id','group_id'])->where(['fk_branch_id'=>Yii::$app->common->getBranch(),'class_id'=>$class_id])->asArray()->all();

        /*$getStu = \app\models\User::find()
            ->select(['student_info.stu_id',"concat(user.first_name, ' ' ,  user.last_name) as name"])
            ->innerJoin('student_info','student_info.user_id = user.id')
            ->where(['user.fk_branch_id'=>Yii::$app->common->getBranch(),'user.fk_role_id'=>3,'student_info.class_id'=>$class_id,'student_info.is_active'=>1])->asArray()->all();*/
        //echo '<pre>';print_r($getStu);die;

        if(count($getStu)>0){
            $stuView=$this->renderAjax('finance/get-student-receipt-wise',['students'=>$getStu]);
        }else{
            $stuView= "<div class='row'><div class='Alert alert-warning'><strong>Students not found!</strong></div> </div>";
        }
        return json_encode(['studata'=>$stuView]);

    }

     public function actionHeadwisePaymentRecv(){
         $start= Yii::$app->request->post('start');
         $end = Yii::$app->request->post('end');


          $getStu=StudentInfo::find()->Select(['stu_id','class_id','section_id','group_id'])->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->asArray()->all();

         $startcnvrt=date('Y-m-d',strtotime($start));
         $endcnvrt=date('Y-m-d',strtotime($end));
         $query=yii::$app->db->createCommand("
                select fh.fk_branch_id,fh.title, sum(fhw.payment_received) as `payment_received` from fee_head_wise fhw 
                    right join fee_particulars fp on fp.id=fhw.fk_fee_particular_id
                    right join fee_heads fh on fh.id=fp.fk_fee_head_id
                    where fh.fk_branch_id=".yii::$app->common->getBranch()." and fhw.created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999'
                    group by fh.fk_branch_id,fh.title
            ")->queryAll();
         //echo $query;die;
        $transportFare= yii::$app->db->createCommand("select sum(transport_fare) as transport_fare from fee_head_wise where fk_branch_id=".yii::$app->common->getBranch()." and created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999' ")->queryOne();
       // echo $transportFare;die;
        //echo $transportFare['transport_fare'];die;
       // echo $transport_farenew;die;

         $transportFares=yii::$app->db->createCommand("select fhw.fk_branch_id,rc.title as `class name`,rg.title as `group_name`,rs.title as `section_name`,si.stu_id,u.username, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name` ,sum(fhw.transport_fare) from fee_head_wise fhw  inner join fee_heads fh on fh.id=fhw.fk_fee_head_id inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id inner join student_info si on si.stu_id=fhw.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id left join ref_section rs on rs.section_id=si.section_id inner join user u on u.id=si.user_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and fhw.created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999'  GROUP by fhw.transport_fare,  fhw.fk_branch_id,rc.title,rg.title,rs.title,si.stu_id,u.username,concat (u.first_name,' ',u.middle_name,' ',u.last_name)")->queryAll();
        // echo $sumHeadx;die;

         $transportFarex=yii::$app->db->createCommand("
                select fh.fk_branch_id,fh.title,sum(fhw.transport_fare) as `transport_fare` from fee_head_wise fhw 
                    right join fee_particulars fp on fp.id=fhw.fk_fee_particular_id
                    right join fee_heads fh on fh.id=fp.fk_fee_head_id
                    where fh.fk_branch_id=".yii::$app->common->getBranch()." and fhw.created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999'
                    group by fhw.transport_fare,fh.fk_branch_id,fh.title
            ")->queryOne();

           $query_extrahead= yii::$app->db->createCommand("select fh.fk_branch_id,fh.title, sum(fhw.payment_received) as `payment_received` 
                            from fee_head_wise fhw 
                            right join fee_heads fh on fh.id=fhw.fk_fee_head_id 
                            where fh.fk_branch_id=".yii::$app->common->getBranch()." and fhw.created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999'
                            and fhw.fk_fee_particular_id IS NULL and fh.extra_head = 1
                            group by fh.fk_branch_id,fh.title")
             ->queryAll();

                 
         if(count($query)>0){
         $cashflowView=$this->renderAjax('finance/headwise-payment-recv',['getStu'=>$getStu,'query'=>$query,'extrahead_query'=>$query_extrahead,'transportFare'=>$transportFare,'startcnvrt'=>$startcnvrt,'endcnvrt'=>$endcnvrt]);
     }else{
         $cashflowView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
     }
         return json_encode(['cashflowhere'=>$cashflowView]);
     
     }
 
     public function actionHeadwisePaymentRecvPdf(){
           $start= Yii::$app->request->get('start');
         $end = Yii::$app->request->get('end');

         $startcnvrt=date('Y-m-d',strtotime($start));
         $endcnvrt=date('Y-m-d',strtotime($end));
         $query=yii::$app->db->createCommand("
                select fh.fk_branch_id,fh.title, sum(fhw.payment_received) as `payment_received` from fee_head_wise fhw 
                    right join fee_particulars fp on fp.id=fhw.fk_fee_particular_id
                    right join fee_heads fh on fh.id=fp.fk_fee_head_id
                    where fh.fk_branch_id=".yii::$app->common->getBranch()." and fhw.created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999'
                    group by fh.fk_branch_id,fh.title
            ")->queryAll();
            $query_extrahead= yii::$app->db->createCommand("select fh.fk_branch_id,fh.title, sum(fhw.payment_received) as `payment_received` 
                            from fee_head_wise fhw 
                            right join fee_heads fh on fh.id=fhw.fk_fee_head_id 
                            where fh.fk_branch_id=".yii::$app->common->getBranch()." and fhw.created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999'
                            and fhw.fk_fee_particular_id IS NULL and fh.extra_head = 1
                            group by fh.fk_branch_id,fh.title")
             ->queryAll();

             $transportFare= yii::$app->db->createCommand("select sum(transport_fare) as transport_fare from fee_head_wise where fk_branch_id=".yii::$app->common->getBranch()." and created_date BETWEEN '".$startcnvrt."' and '".$endcnvrt." 23:59:59.999' ")->queryOne();

         ///echo $query;die;
         //echo '<pre>';print_r($query);
         if(count($query)>0){ 
         $cashflowView=$this->renderAjax('finance/headwise-payment-recv-pdf',['query'=>$query,'extrahead_query'=>$query_extrahead,'transportFare'=>$transportFare]);
         $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $mpdf->WriteHTML("<h3 style='text-align:center'>Head Wise Payment Received</h3>");
        $mpdf->WriteHTML($cashflowView);
        $mpdf->Output('headwise-payment-recv-'.date("d-m-Y").'.pdf', 'D'); 
         $cashflowView=$this->renderAjax('finance/headwise-payment-recv',['query'=>$query,'extrahead_query'=>$query_extrahead,'transportFare'=>$transportFare]);
 
     }else{
         $cashflowView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
     }
         return json_encode(['cashflowhere'=>$cashflowView]);
     
     }





     public function actionDailyCashflowClaswise(){
         $date= Yii::$app->request->post('date');
         
         $query=yii::$app->db->createCommand("
                select MAX(fhw.transport_fare),fhw.fk_branch_id,rc.title,rc.class_id,sum(fhw.payment_received) from fee_head_wise fhw inner join fee_heads fh on fh.id=fhw.fk_fee_head_id inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id inner join student_info si on si.stu_id=fhw.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and cast(fcr.transaction_date as date)='".$date."' GROUP by fhw.fk_branch_id,rc.title,rc.class_id
            ")->queryAll();
        // echo $query;die;

        /* $getTransport=yii::$app->db->createCommand("SELECT fee_head_wise.id,fee_head_wise.id,fee_head_wise.fk_chalan_id, fee_transaction_details.transaction_date,fee_transaction_details.id,fee_head_wise.transport_fare
        FROM fee_head_wise
        INNER JOIN fee_transaction_details ON fee_head_wise.fk_chalan_id=fee_transaction_details.id where fee_transaction_details.transaction_date='".$date."' GROUP BY(fk_chalan_id)")->queryAll();*/
         //echo $getTransport;die;


        /* $tr = FeeHeadWise::find()
            ->select(['student_parents_info.*','student_info.fk_branch_id'])
            ->innerJoin('student_info','student_info.stu_id = student_parents_info.stu_id')
            ->where(['student_parents_info.cnic'=>$cnic,'student_info.fk_branch_id'=>yii::$app->common->getBranch()])->asArray()->all();*/
         //*extra head*/
         $query_extrahead =yii::$app->db->createCommand("select fhw.fk_branch_id,rc.title,rc.class_id,sum(fhw.payment_received) from fee_head_wise fhw inner join fee_heads fh on fh.id=fhw.fk_fee_head_id inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id inner join student_info si on si.stu_id=fhw.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and fhw.fk_fee_particular_id IS NULL and fh.extra_head = 1 and cast(fcr.transaction_date as date)='".$date."' GROUP by fhw.fk_branch_id,rc.title,rc.class_id")->queryAll();

         //echo $query;die;
         /*echo '<pre>';print_r($query_extrahead);
         exit;*/
         if(count($query)>0){
         $cashflowView=$this->renderAjax('finance/cashinflow-classwise',['query'=>$query,'date'=>$date,'query_extrahead'=>$query_extrahead]);
     }else{
         $cashflowView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
     }
         return json_encode(['cashflowclass'=>$cashflowView]);
     
     }


     public function actionClassWiseFee(){
         $class_id= Yii::$app->request->post('classid');
         $dates= Yii::$app->request->post('dates');
       
         $query=yii::$app->db->createCommand("select fhw.transport_fare,fhw.fk_branch_id,rc.title as `class name`,rg.title as `group_name`,rs.title as `section_name`,si.stu_id,u.username, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name` ,sum(fhw.payment_received),u.id from fee_head_wise fhw  inner join fee_heads fh on fh.id=fhw.fk_fee_head_id inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id inner join student_info si on si.stu_id=fhw.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id left join ref_section rs on rs.section_id=si.section_id inner join user u on u.id=si.user_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and rc.class_id=".$class_id." and fcr.transaction_date ='".$dates."' GROUP by fhw.fk_branch_id,rc.title,rg.title,rs.title,si.stu_id,u.username,concat (u.first_name,' ',u.middle_name,' ',u.last_name),u.id,fhw.transport_fare")->queryAll();
         //echo $query;die;

         $sumHead=yii::$app->db->createCommand("select fhw.fk_branch_id,rc.title as `class name`,rg.title as `group_name`,rs.title as `section_name`,si.stu_id,u.username, concat(u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name` ,fhw.transport_fare from fee_head_wise fhw  inner join fee_heads fh on fh.id=fhw.fk_fee_head_id inner join fee_transaction_details fcr on fcr.id=fhw.fk_chalan_id inner join student_info si on si.stu_id=fhw.fk_stu_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id left join ref_section rs on rs.section_id=si.section_id inner join user u on u.id=si.user_id where fhw.fk_branch_id=".yii::$app->common->getBranch()." and rc.class_id=".$class_id." and fcr.transaction_date ='".$dates."' GROUP by fhw.transport_fare,  fhw.fk_branch_id,rc.title,rg.title,rs.title,si.stu_id,u.username,concat (u.first_name,' ',u.middle_name,' ',u.last_name)")->queryOne();
         //echo $sumHead['transport_fare'];die;
         //echo '<pre>';print_r($sumHead);die;



         //echo $query;die;
         //echo '<pre>';print_r($query);die;
         if(count($query)>0){
         $cashflowView=$this->renderAjax('finance/cashinflow-classwiseget',['query'=>$query,'date'=>$dates,'class_id'=>$class_id,'sumHead'=>$sumHead]);
     }else{
         $cashflowView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
     }
         return json_encode(['cashflowclasswise'=>$cashflowView]);
     
     }


     // yearly admissin report
     public function actionYearlyAdmission(){
        $year=yii::$app->request->post('year');

        $yearAdmission=yii::$app->db->createCommand("SELECT count(*) as `Total_No_of_students_Newly_confirmed_admitted` FROM student_info si2 inner join ref_class rc on rc.class_id=si2.class_id where si2.fk_branch_id=".yii::$app->common->getBranch()." and si2.is_active =1 and si2.stu_id not in (select fk_stu_id from stu_reg_log_association) AND cast(si2.registration_date as date) like '".$year."%'")->queryAll(); 

        $admisnViewYear=$this->renderAjax('statistics/yearly-admission',['year'=>$yearAdmission,'getyear'=>$year]);

        return json_encode(['getYearadmission'=>$admisnViewYear]);
     }

     public function actionYearlyadmissionStudentsnoClasswise(){
        $years=yii::$app->request->post('years');

        $yearAdmissions=yii::$app->db->createCommand("SELECT rc.title as `class_wise`,rc.class_id, count(*) as `No_of_students` FROM student_info si2 inner join ref_class rc on rc.class_id=si2.class_id where si2.fk_branch_id=".yii::$app->common->getBranch()." and si2.is_active =1 and si2.stu_id not in (select fk_stu_id from stu_reg_log_association) and cast(si2.registration_date as date) like '".$years."%' group by rc.title,rc.class_id")->queryAll(); 

        //echo '<pre>';print_r($yearAdmissions);die;

        $admisnViewsYear=$this->renderAjax('statistics/yearly-admission-classwise',['years'=>$yearAdmissions,'getyear'=>$years]);

        return json_encode(['getYearadmissionClasswise'=>$admisnViewsYear]);
     }




        public function actionClasswisePdf(){
         
         $years=yii::$app->request->get('years');
         $attrname= yii::$app->request->get('attrname');

         $yearAdmissions=yii::$app->db->createCommand("SELECT rc.title as `class_wise`,rc.class_id, count(*) as `No_of_students` FROM student_info si2 inner join ref_class rc on rc.class_id=si2.class_id where si2.fk_branch_id=".yii::$app->common->getBranch()." and si2.is_active =1 and si2.stu_id not in (select fk_stu_id from stu_reg_log_association) and cast(si2.registration_date as date) like '".$years."%' group by rc.title,rc.class_id")->queryAll(); 
        // echo '<pre>';print_r($yearAdmissions);die;
         
         
         if($attrname == "Generate Report"){
            $admisnViewsYear=$this->renderPartial('statistics/yearly-admission-classwiseReport',['years'=>$yearAdmissions,'getyear'=>$years]);
         }else{
            $admisnViewsYear=$this->renderAjax('statistics/yearly-admission-classwise',['years'=>$yearAdmissions,'getyear'=>$years]);
         }
         

        $this->layout = 'pdf';
        $mpdf = new mPDF('A4');
        $mpdf->WriteHTML("<h3 style='text-align:center'>Details Of Student Enrolled in Year '".$years."'.</h3>");
        $mpdf->WriteHTML($admisnViewsYear);
        $mpdf->Output('student-enrolled-in-year-'.date("d-m-Y").'.pdf', 'D');


        return json_encode(['getYearadmissionClasswise'=>$admisnViewsYear]);

     
     
     }// end of class wise pdf




      public function actionYearlyadmissionStudentsnoClasswiseStudent(){
        $classid=yii::$app->request->post('classid');
        $years=yii::$app->request->post('years');
        $yearAdmissionstudents=yii::$app->db->createCommand("select si.stu_id as `student_id`,u.username as `registration_no`,concat(u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name`, spi.first_name as `father_name`,rc.title as `class_name`,rg.title as `group_name`,rs.title as `section_name`,si.registration_date from student_info si inner join user u on u.id=si.user_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id inner join ref_section rs on rs.section_id=si.section_id inner join student_parents_info spi on spi.stu_id=si.stu_id where si.fk_branch_id=".yii::$app->common->getBranch()." and si.is_active =1 and si.stu_id not in (select fk_stu_id from stu_reg_log_association) and cast(si.registration_date as date) like '".$years."%' and si.class_id=".$classid."")->getRawSql(); 
        echo $yearAdmissionstudents;die;
        //echo '<pre>';print_r($yearAdmissionstudents);die;


        $admisnViewsYearClass=$this->renderAjax('statistics/yearly-admission-classwise-students',['yearAdmissionstudents'=>$yearAdmissionstudents,'years'=>$years,'classid'=>$classid]);

        return json_encode(['getYearadmissionClasswiseStudents'=>$admisnViewsYearClass]);
     }



     public function actionYearlyadmissionStudentsnoClasswiseStudentpdf(){
         $classid=yii::$app->request->get('classid');
         $years=yii::$app->request->get('years');

        $yearAdmissionstudents=yii::$app->db->createCommand("select si.stu_id as `student_id`,u.username as `registration_no`,concat(u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name`, spi.first_name as `father_name`,rc.title as `class_name`,rg.title as `group_name`,rs.title as `section_name`,si.registration_date from student_info si inner join user u on u.id=si.user_id inner join ref_class rc on rc.class_id=si.class_id left join ref_group rg on rg.group_id=si.group_id inner join ref_section rs on rs.section_id=si.section_id inner join student_parents_info spi on spi.stu_id=si.stu_id where si.fk_branch_id=".yii::$app->common->getBranch()." and si.is_active =1 and si.stu_id not in (select fk_stu_id from stu_reg_log_association) and cast(si.registration_date as date) like '".$years."%' and si.class_id=".$classid."")->queryAll(); 
        //echo '<pre>';print_r($yearAdmissionstudents);die;

        $admisnViewsYearClass=$this->renderAjax('statistics/yearly-admission-classwise-studentspdf',['yearAdmissionstudents'=>$yearAdmissionstudents,'years'=>$years]);

         $this->layout = 'pdf';
        $mpdf = new mPDF('A4');
        $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        // $mpdf->WriteHTML("<h3 style='text-align:center'>Details Of Student Enrolled in '".$yearAdmissionstudentx['class_name']."' '".$yearAdmissionstudentx['group_name']."' '".$yearAdmissionstudentx['section_name']."' in '".$years."'.</h3>");
        $mpdf->WriteHTML($admisnViewsYearClass);
        $mpdf->Output('student-enrolled-in-year-'.date("d-m-Y").'.pdf', 'D');


        
        

        return json_encode(['getYearadmissionClasswiseStudents'=>$admisnViewsYearClass]);
     }


     // end of yearly admission report

    public function actionClassWiseResultsheet(){
        if(Yii::$app->request->isAjax){
            $data= Yii::$app->request->post();
            if($data['class_id']){
                $students= StudentInfo::find()
                    ->select(['student_info.stu_id','u.username roll_no','u.id user_id'])
                    ->innerJoin('user u','u.id=student_info.user_id')
                    ->where(['student_info.fk_branch_id'=>Yii::$app->common->getBranch(),'student_info.class_id'=>$data['class_id'],'student_info.group_id'=>($data['group_id'])?$data['group_id']:null,'student_info.section_id'=>$data['section']])
                    ->asArray()
                    ->all();

                /*total subjects*/
                $subjects = Exam::find()
                    ->select([
                        'sb.id subject_id',
                        'sb.title subject',
                        'sum(exam.total_marks) total_marks'
                    ])
                    ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                    ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                    ->leftJoin('ref_group g','g.group_id=exam.fk_group_id ')
                    ->leftJoin('ref_section s','s.section_id=exam.fk_section_id')
                    ->innerJoin('subjects sb','sb.id=exam.fk_subject_id and c.class_id = sb.fk_class_id and g.group_id=sb.fk_group_id')
                    ->where(['et.id'=>$data['exam_type'], 'c.class_id'=>$data['class_id'],'g.group_id'=>($data['group_id'])?$data['group_id']:null,'s.section_id'=>$data['section']])
                    ->groupBy(['sb.title','sb.id'])->asArray()->all();

                if(count($students)){
                    $studentexam_arr=[];
                    $examsubjects_arr=[];
                    foreach ($students as  $skey=>$stu_id){
                        $subjects_data = Exam::find()
                            ->select([
                                'st.stu_id',
                                'concat(u.first_name," ",u.last_name) student_name',
                                'c.class_id',
                                'c.title',
                                'g.group_id',
                                'g.title',
                                's.section_id',
                                's.title',
                                'sb.title subject',
                                'sum(exam.total_marks) total_marks',
                                'sum(exam.passing_marks) passing_marks',
                                'round(sum(sm.marks_obtained),2) marks_obtained'
                            ])
                            ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                            ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                            ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                            ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                            ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                            ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                            ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                            ->innerJoin('user u','u.id=st.user_id')
                            ->where(['et.id'=>$data['exam_type'],'exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$data['class_id'],'g.group_id'=>($data['group_id'])?$data['group_id']:null,'s.section_id'=>$data['section'],'st.stu_id'=>$stu_id['stu_id'] ])
                            ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();


                        if(count($subjects_data)>0){
                            $studentexam_arr[$stu_id['stu_id']]['student_id']=$stu_id['roll_no'];
                            $studentexam_arr[$stu_id['stu_id']]['name']=$stu_id['user_id'];
                            foreach ($subjects_data as $indata){
                                $studentexam_arr[$stu_id['stu_id']][] = $indata['marks_obtained'];
                                if($skey==0){
                                    $examsubjects_arr['heads'][] = $indata['subject'];
                                    $examsubjects_arr['total_marks'][] = $indata['total_marks'];
                                }
                            }
                        }
                    }
                    $examtype = ExamType::findOne($data['exam_type']);
                    $details = $this->renderPartial('academics/class_wise_resultsheet',[
                        'query'=>$studentexam_arr,
                        'subjects'=>$subjects,
                        'class_id'=>$data['class_id'],
                        'group_id'=>($data['group_id'])?$data['group_id']:null,
                        'section_id'=>$data['section'],
                        'examtype'=>$examtype,
                        'heads_marks'=>$examsubjects_arr
                    ]);
                    return json_encode(['status'=>1,'details'=>$details]);
                }
            }
        }
        else{
            $data= Yii::$app->request->get();
            if($data['fk_class_id']){
                $students= StudentInfo::find()
                    ->select(['student_info.stu_id','u.username roll_no','u.id user_id'])
                    ->innerJoin('user u','u.id=student_info.user_id')
                    ->where(['student_info.fk_branch_id'=>Yii::$app->common->getBranch(),'student_info.class_id'=>$data['fk_class_id'],'student_info.group_id'=>($data['fk_group_id'])?$data['fk_group_id']:null,'student_info.section_id'=>$data['fk_section_id']])
                    ->asArray()
                    ->all();

                /*total subjects*/
                $subjects = Exam::find()
                    ->select([
                        'sb.id subject_id',
                        'sb.title subject',
                        'sum(exam.total_marks) total_marks'
                    ])
                    ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                    ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                    ->leftJoin('ref_group g','g.group_id=exam.fk_group_id ')
                    ->leftJoin('ref_section s','s.section_id=exam.fk_section_id')
                    ->innerJoin('subjects sb','sb.id=exam.fk_subject_id and c.class_id = sb.fk_class_id and g.group_id=sb.fk_group_id')
                    ->where(['et.id'=>$data['fk_exam_type'], 'c.class_id'=>$data['fk_class_id'],'g.group_id'=>($data['fk_group_id'])?$data['fk_group_id']:null,'s.section_id'=>$data['fk_section_id']])
                    ->groupBy(['sb.title','sb.id'])->asArray()->all();

                if(count($students)){
                    $studentexam_arr=[];
                    $examsubjects_arr=[];
                    foreach ($students as  $skey=>$stu_id){
                        $subjects_data = Exam::find()
                            ->select([
                                'st.stu_id',
                                'concat(u.first_name," ",u.last_name) student_name',
                                'c.class_id',
                                'c.title',
                                'g.group_id',
                                'g.title',
                                's.section_id',
                                's.title',
                                'sb.title subject',
                                'sum(exam.total_marks) total_marks',
                                'sum(exam.passing_marks) passing_marks',
                                'round(sum(sm.marks_obtained),2) marks_obtained'
                            ])
                            ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                            ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                            ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                            ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                            ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                            ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                            ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                            ->innerJoin('user u','u.id=st.user_id')
                            ->where(['et.id'=>$data['fk_exam_type'],'exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$data['fk_class_id'],'g.group_id'=>($data['fk_group_id'])?$data['fk_group_id']:null,'s.section_id'=>$data['fk_section_id'],'st.stu_id'=>$stu_id['stu_id'] ])
                            ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();



                        if(count($subjects_data)>0){
                            $sumTotalMarks = 0;
                            $studentexam_arr[$stu_id['stu_id']]['student_id']=$stu_id['roll_no'];
                            $studentexam_arr[$stu_id['stu_id']]['name']=$stu_id['user_id'];
                            $std = $stu_id['stu_id'];
                            foreach ($subjects_data as $indata){
                                if($std == $stu_id['stu_id']){
                                    $sumTotalMarks  =  $sumTotalMarks + $indata['marks_obtained'];
                                    $studentToralMarks [$stu_id['stu_id']] = $sumTotalMarks;
                                }
                                $studentexam_arr[$stu_id['stu_id']][] = $indata['marks_obtained'];
                                if($skey==0){
                                    $examsubjects_arr['heads'][] = $indata['subject'];
                                    $examsubjects_arr['total_marks'][] = $indata['total_marks'];
                                }

                                /*sum condition*/
                                if($std != $stu_id['stu_id']){
                                    $sumTotalMarks  = 0;
                                }
                            }
                        }
                    }
                    /*maintain student id's and sort desc.*/
                    natcasesort($studentToralMarks);
                    $sortArr = array_reverse($studentToralMarks, true);
                    $position  = [];
                    $counter= 1;
                    $stdMarks = 0;
                    /*custom sort*/
                    foreach($sortArr as $key=>$totalStdObtainMarks){
                        if($stdMarks ==0){
                            $stdMarks = $totalStdObtainMarks;
                        }
                        if($stdMarks == $totalStdObtainMarks){
                            //echo $stdMarks.'----'.$totalStdObtainMarks.'----' .$counter."<br/>";
                            $position[] = ['position'=>$counter,'student_id'=>$key,'marks'=>$totalStdObtainMarks];
                        }else{
                            $counter = $counter+1;
                            $position[] = ['position'=>$counter,'student_id'=>$key,'marks'=>$totalStdObtainMarks];
                            //echo $stdMarks.'----'.$totalStdObtainMarks.'----' .$counter."-No pos - <br/>";
                        }
                        $stdMarks = $totalStdObtainMarks;
                    }
                    $examtype = ExamType::findOne($data['fk_exam_type']);
                    $resultsheet= Yii::$app->common->getCGSName($data['fk_class_id'],$data['fk_group_id'],$data['fk_section_id']).' - '.ucfirst($examtype->type);
                    $details = $this->renderPartial('academics/class_wise_resultsheet',[
                        'query'=>$studentexam_arr,
                        'subjects'=>$subjects,
                        'class_id'=>$data['fk_class_id'],
                        'group_id'=>($data['fk_group_id'])?$data['fk_group_id']:null,
                        'section_id'=>$data['fk_section_id'],
                        'examtype'=>$examtype,
                        'heads_marks'=>$examsubjects_arr,
                        'positions'=>$position
                    ]);
                    $this->layout = 'pdf';
                    //$mpdf = new mPDF('', 'A4');
                    $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                    $stylesheet = file_get_contents('css/pdf.css'); // external css
                    $mpdf->WriteHTML($stylesheet,1);
                    $mpdf->WriteHTML($details);
                    $mpdf->Output('Result-sheet-'.$resultsheet.'.pdf', 'D');
                }
            }
        }
    }

    public function actionTopPositionSheet(){
        if(Yii::$app->request->isAjax){
            $data= Yii::$app->request->post();
            if($data['class_id']){
                $students= StudentInfo::find()
                    ->select(['student_info.stu_id','u.username roll_no','u.id user_id'])
                    ->innerJoin('user u','u.id=student_info.user_id')
                    ->where(['student_info.fk_branch_id'=>Yii::$app->common->getBranch(),'student_info.class_id'=>$data['class_id'],'student_info.group_id'=>($data['group_id'])?$data['group_id']:null,'student_info.section_id'=>$data['section']])
                    ->asArray()
                    ->all();

                /*total subjects*/
                $subjects = Exam::find()
                    ->select([
                        'sb.id subject_id',
                        'sb.title subject',
                        'sum(exam.total_marks) total_marks'
                    ])
                    ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                    ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                    ->leftJoin('ref_group g','g.group_id=exam.fk_group_id ')
                    ->leftJoin('ref_section s','s.section_id=exam.fk_section_id')
                    ->innerJoin('subjects sb','sb.id=exam.fk_subject_id and c.class_id = sb.fk_class_id and g.group_id=sb.fk_group_id')
                    ->where(['et.id'=>$data['exam_type'], 'c.class_id'=>$data['class_id'],'g.group_id'=>($data['group_id'])?$data['group_id']:null,'s.section_id'=>$data['section']])
                    ->groupBy(['sb.title','sb.id'])->asArray()->all();

                if(count($students)){
                    $studentexam_arr=[];
                    $examsubjects_arr=[];
                    foreach ($students as  $skey=>$stu_id){
                        $subjects_data = Exam::find()
                            ->select([
                                'st.stu_id',
                                'concat(u.first_name," ",u.last_name) student_name',
                                'c.class_id',
                                'c.title',
                                'g.group_id',
                                'g.title',
                                's.section_id',
                                's.title',
                                'sb.title subject',
                                'sum(exam.total_marks) total_marks',
                                'sum(exam.passing_marks) passing_marks',
                                'round(sum(sm.marks_obtained),2) marks_obtained'
                            ])
                            ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                            ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                            ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                            ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                            ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                            ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                            ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                            ->innerJoin('user u','u.id=st.user_id')
                            ->where(['et.id'=>$data['exam_type'],'exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$data['class_id'],'g.group_id'=>($data['group_id'])?$data['group_id']:null,'s.section_id'=>$data['section'],'st.stu_id'=>$stu_id['stu_id'] ])
                            ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();


                        if(count($subjects_data)>0){
                            $studentexam_arr[$stu_id['stu_id']]['student_id']=$stu_id['roll_no'];
                            $studentexam_arr[$stu_id['stu_id']]['name']=$stu_id['user_id'];
                            foreach ($subjects_data as $indata){
                                $studentexam_arr[$stu_id['stu_id']][] = $indata['marks_obtained'];
                                if($skey==0){
                                    $examsubjects_arr['heads'][] = $indata['subject'];
                                    $examsubjects_arr['total_marks'][] = $indata['total_marks'];
                                }
                            }
                        }
                    }
                    $examtype = ExamType::findOne($data['exam_type']);
                    $details = $this->renderPartial('academics/class_wise_resultsheet',[
                        'query'=>$studentexam_arr,
                        'subjects'=>$subjects,
                        'class_id'=>$data['class_id'],
                        'group_id'=>($data['group_id'])?$data['group_id']:null,
                        'section_id'=>$data['section'],
                        'examtype'=>$examtype,
                        'heads_marks'=>$examsubjects_arr
                    ]);
                    return json_encode(['status'=>1,'details'=>$details]);
                }
            }
        }
        else{
            $data= Yii::$app->request->get();
            if($data['fk_class_id']){
                $students= StudentInfo::find()
                    ->select(['student_info.stu_id','u.username roll_no','u.id user_id'])
                    ->innerJoin('user u','u.id=student_info.user_id')
                    ->where(['student_info.fk_branch_id'=>Yii::$app->common->getBranch(),'student_info.class_id'=>$data['fk_class_id'],'student_info.group_id'=>($data['fk_group_id'])?$data['fk_group_id']:null,'student_info.section_id'=>$data['fk_section_id']])
                    ->asArray()
                    ->all();

                /*total subjects*/
                $subjects = Exam::find()
                    ->select([
                        'sb.id subject_id',
                        'sb.title subject',
                        'sum(exam.total_marks) total_marks'
                    ])
                    ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                    ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                    ->leftJoin('ref_group g','g.group_id=exam.fk_group_id ')
                    ->leftJoin('ref_section s','s.section_id=exam.fk_section_id')
                    ->innerJoin('subjects sb','sb.id=exam.fk_subject_id and c.class_id = sb.fk_class_id and g.group_id=sb.fk_group_id')
                    ->where(['et.id'=>$data['fk_exam_type'], 'c.class_id'=>$data['fk_class_id'],'g.group_id'=>($data['fk_group_id'])?$data['fk_group_id']:null,'s.section_id'=>$data['fk_section_id']])
                    ->groupBy(['sb.title','sb.id'])->asArray()->all();

                if(count($students)){
                    $studentexam_arr=[];
                    $examsubjects_arr=[];
                    foreach ($students as  $skey=>$stu_id){
                        $subjects_data = Exam::find()
                            ->select([
                                'st.stu_id',
                                'concat(u.first_name," ",u.last_name) student_name',
                                'c.class_id',
                                'c.title',
                                'g.group_id',
                                'g.title',
                                's.section_id',
                                's.title',
                                'sb.title subject',
                                'sum(exam.total_marks) total_marks',
                                'sum(exam.passing_marks) passing_marks',
                                'round(sum(sm.marks_obtained),2) marks_obtained'
                            ])
                            ->innerJoin('exam_type et','et.id=exam.fk_exam_type')
                            ->innerJoin('ref_class c','c.class_id=exam.fk_class_id')
                            ->innerJoin('subjects sb','sb.id=exam.fk_subject_id')
                            ->leftJoin('student_marks sm','sm.fk_exam_id=exam.id')
                            ->leftJoin('student_info st',' st.stu_id=sm.fk_student_id')
                            ->leftJoin('ref_group g','g.group_id=exam.fk_group_id')
                            ->leftJoin('ref_section s','s.class_id=exam.fk_class_id')
                            ->innerJoin('user u','u.id=st.user_id')
                            ->where(['et.id'=>$data['fk_exam_type'],'exam.fk_branch_id'=>Yii::$app->common->getBranch(),'c.class_id'=>$data['fk_class_id'],'g.group_id'=>($data['fk_group_id'])?$data['fk_group_id']:null,'s.section_id'=>$data['fk_section_id'],'st.stu_id'=>$stu_id['stu_id'] ])
                            ->groupBy(['st.stu_id','c.class_id','c.title','g.group_id','g.title','s.section_id','s.title','sb.title'])->asArray()->all();



                        if(count($subjects_data)>0){
                            $sumTotalMarks = 0;
                            $studentexam_arr[$stu_id['stu_id']]['student_id']=$stu_id['roll_no'];
                            $studentexam_arr[$stu_id['stu_id']]['name']=$stu_id['user_id'];
                            $std = $stu_id['stu_id'];
                            foreach ($subjects_data as $indata){
                                if($std == $stu_id['stu_id']){
                                    $sumTotalMarks  =  $sumTotalMarks + $indata['marks_obtained'];
                                    $studentToralMarks [$stu_id['stu_id']] = $sumTotalMarks;
                                }
                                $studentexam_arr[$stu_id['stu_id']][] = $indata['marks_obtained'];
                                if($skey==0){
                                    $examsubjects_arr['heads'][] = $indata['subject'];
                                    $examsubjects_arr['total_marks'][] = $indata['total_marks'];
                                }

                                /*sum condition*/
                                if($std != $stu_id['stu_id']){
                                    $sumTotalMarks  = 0;
                                }
                            }
                        }
                    }
                    /*maintain student id's and sort desc.*/
                    natcasesort($studentToralMarks);
                    $sortArr = array_reverse($studentToralMarks, true);
                    $position  = [];
                    $counter= 1;
                    $stdMarks = 0;
                    /*custom sort*/
                    foreach($sortArr as $key=>$totalStdObtainMarks){
                        if($stdMarks ==0){
                            $stdMarks = $totalStdObtainMarks;
                        }
                        if($stdMarks == $totalStdObtainMarks){
                            //echo $stdMarks.'----'.$totalStdObtainMarks.'----' .$counter."<br/>";
                            $position[] = ['position'=>$counter,'student_id'=>$key,'marks'=>$totalStdObtainMarks];
                        }else{
                            $counter = $counter+1;
                            $position[] = ['position'=>$counter,'student_id'=>$key,'marks'=>$totalStdObtainMarks];
                            //echo $stdMarks.'----'.$totalStdObtainMarks.'----' .$counter."-No pos - <br/>";
                        }
                        $stdMarks = $totalStdObtainMarks;
                    }
                    $examtype = ExamType::findOne($data['fk_exam_type']);
                    $resultsheet= Yii::$app->common->getCGSName($data['fk_class_id'],$data['fk_group_id'],$data['fk_section_id']).' - '.ucfirst($examtype->type);
                    $query_data = [];
                    //Customize data from position.
                    foreach ($position as $i => $row) {
                        $query_data[$i]['query'] = $studentexam_arr[$row['student_id']];
                        $query_data[$i]['postion'] = $row;
                    }
                    $details = $this->renderPartial('academics/top-position',[
                        'query'=>$studentexam_arr,
                        'subjects'=>$subjects,
                        'class_id'=>$data['fk_class_id'],
                        'group_id'=>($data['fk_group_id'])?$data['fk_group_id']:null,
                        'section_id'=>$data['fk_section_id'],
                        'examtype'=>$examtype,
                        'heads_marks'=>$examsubjects_arr,
                        'positions'=>$position,
                        'query_data'=>$query_data
                    ]);
                    $this->layout = 'pdf';
                    //$mpdf = new mPDF('', 'A4');
                    $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
                    $stylesheet = file_get_contents('css/pdf.css'); // external css
                    $mpdf->WriteHTML($stylesheet,1);
                    $mpdf->WriteHTML($details);
                    $mpdf->Output('Result-sheet-'.$resultsheet.'.pdf', 'D');
                }
            }
        }
    }


    public function actionNewAdmissionClasswisePdf(){
        $newadmissionview=$this->renderAjax('statistics/new-admission-classwise-pdf');
        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>New Admission Class Wise</h3>");
        $mpdf->WriteHTML($newadmissionview);
        $mpdf->Output('new-admission-class-wise-'.date("d-m-Y").'.pdf', 'D'); 

    }

     public function actionNewPromotionClasswisePdf(){
        $newadmissionview=$this->renderAjax('statistics/new-promotion-classwise-pdf');
        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Promotion Class Wise</h3>");
        $mpdf->WriteHTML($newadmissionview);
        $mpdf->Output('promotion-class-wise-'.date("d-m-Y").'.pdf', 'D'); 

    }


    public function actionOverAllTransportPdf(){
        $newadmissionview=$this->renderAjax('statistics/overall-transport-pdf');
        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Over All Transport Student  Wise</h3>");
        $mpdf->WriteHTML($newadmissionview);
        $mpdf->Output('overall-transport-student-wise-'.date("d-m-Y").'.pdf', 'D'); 

    }
 

public function actionStudentsOverallReportPdf(){

        $startdate=yii::$app->request->get('startdate');
        $enddate=yii::$app->request->get('enddate');
        $startcnvrt=date('Y-m-d',strtotime($startdate));
        $endcnvrt=date('Y-m-d',strtotime($enddate));
        $getChalans=Yii::$app->db->createCommand("select fhw.fk_branch_id,fhw.fk_stu_id,ftd.manual_recept_no,ftd.id,ftd.manual_recept_no,ftd.transaction_date as `fee_submission_date` from fee_head_wise fhw inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id where fhw.fk_branch_id=".Yii::$app->common->getBranch()." and CAST(ftd.transaction_date AS DATE) >= '".$startcnvrt."' and CAST(ftd.transaction_date AS DATE) <= '".$endcnvrt."' GROUP BY fhw.fk_branch_id,fhw.fk_stu_id,ftd.id,ftd.manual_recept_no, ftd.transaction_date ORDER BY ftd.manual_recept_no ASC")->queryAll();

        if(count($getChalans)>0){
            $newadmissionview=$this->renderAjax('finance/overall-student-reports-pdf',['getChalans'=>$getChalans]);
        }else{
            $newadmissionview= "<div class='row'><div class='Alert alert-warning'><center><strong>Not Found!</strong></center></div> </div>";
        } 
        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
        $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Students over all report</h3>");
        $mpdf->WriteHTML($newadmissionview);
        $mpdf->Output('overall-student-reports-'.date("d-m-Y").'.pdf', 'D'); 

    }
    

 public function actionStudentOverllReport(){
         $startdate=yii::$app->request->post('startdate');
         $enddate=yii::$app->request->post('enddate');
         $startcnvrt=date('Y-m-d',strtotime($startdate));
         $endcnvrt=date('Y-m-d',strtotime($enddate));

         $getChalans=Yii::$app->db->createCommand("select fhw.fk_branch_id,fhw.fk_stu_id,ftd.manual_recept_no,ftd.id,ftd.manual_recept_no,ftd.transaction_date as `fee_submission_date` from fee_head_wise fhw inner join fee_transaction_details ftd on ftd.id=fhw.fk_chalan_id where fhw.fk_branch_id=".Yii::$app->common->getBranch()." and CAST(ftd.transaction_date AS DATE) >= '".$startcnvrt."' and CAST(ftd.transaction_date AS DATE) <= '".$endcnvrt."' GROUP BY fhw.fk_branch_id,fhw.fk_stu_id,ftd.id,ftd.manual_recept_no, ftd.transaction_date ORDER BY ftd.manual_recept_no ASC")->queryAll();

         if(count($getChalans)>0){
          $overallstudents= $this->renderAjax('finance/overall-students',['startcnvrt'=>$startcnvrt,'endcnvrt'=>$endcnvrt]);
         }else{
         $overallstudents= "<div class='row'><div class='Alert alert-warning'><center><strong>Not Found!</strong></center></div> </div>";
         }
        return json_encode(['overallstudents'=>$overallstudents]);


    }
    /*================ */

      public function actionLeaveSchool(){
         $year=yii::$app->request->post('years');
        $leaveInfo=StudentLeaveInfo::find()->where(['like','created_date',$year])->count();
        
        $showleavestu=$this->renderAjax('statistics/leave-school',['year'=>$year,'leaveInfo'=>$leaveInfo]);

        return json_encode(['showleavestu'=>$showleavestu]);
     }

     public function actionLeaveSchoolPdf(){
         $year=yii::$app->request->get('years');
        $leaveInfo=StudentLeaveInfo::find()->where(['like','created_date',$year])->count();
        
        $showleavestu=$this->renderAjax('statistics/leave-school-pdf',['year'=>$year,'leaveInfo'=>$leaveInfo]);

        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
       // $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        //$mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Previous students report of year($year)</h3>");
        $mpdf->WriteHTML($showleavestu);
        $mpdf->Output('Previous-student-report-'.date("d-m-Y").'.pdf', 'D'); 


        return json_encode(['showleavestu'=>$showleavestu]);
     }


     public function actionLeaveSchollClass(){
         $year=yii::$app->request->post('years');
       //$leaveInfo=StudentLeaveInfo::find()->where(['like','created_date',$year])->all();


          $leaveInfo=yii::$app->db->createCommand("SELECT count(*) as total_student,class_id from student_leave_info where created_date like '".$year."%' GROUP BY class_id")->queryAll();
         // echo $leaveInfo;die;

        $showleavestu=$this->renderAjax('statistics/leave-school-year',['year'=>$year,'leaveInfo'=>$leaveInfo]);

        return json_encode(['showleavestu'=>$showleavestu]);
     }


      public function actionLeaveSchollClassPdf(){
         $year=yii::$app->request->get('years');
         $leaveInfo=yii::$app->db->createCommand("SELECT count(*) as total_student,class_id from student_leave_info where created_date like '".$year."%' GROUP BY class_id")->queryAll();
         $showleavestu=$this->renderAjax('statistics/leave-school-year-pdf',['year'=>$year,'leaveInfo'=>$leaveInfo]);
        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
       // $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        //$mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Previous students class report of year($year)</h3>");
        $mpdf->WriteHTML($showleavestu);
        $mpdf->Output('Previous-student-class-report-'.date("d-m-Y").'.pdf', 'D'); 

        return json_encode(['showleavestu'=>$showleavestu]);
     }

     public function actionLeaveScholClassStudent(){
         $year=yii::$app->request->post('years');
         $clas=yii::$app->request->post('clas');
       $leaveInfo=StudentLeaveInfo::find()->where(['class_id'=>$clas])->andWhere(['like','created_date',$year])->all();

         // echo $leaveInfo;die;

        $showleavestu=$this->renderAjax('statistics/leave-school-year-student',['year'=>$year,'leaveInfo'=>$leaveInfo]);

        return json_encode(['showleavestu'=>$showleavestu]);
     }

     public function actionLeaveScholClassStudentPdf(){
          $year=yii::$app->request->get('years');
          $clas=yii::$app->request->get('clas');

       $leaveInfo=StudentLeaveInfo::find()->where(['class_id'=>$clas])->andWhere(['like','created_date',$year])->all();
        $showleavestu=$this->renderAjax('statistics/leave-school-year-student-pdf',['year'=>$year,'leaveInfo'=>$leaveInfo]);
        $this->layout = 'pdf';
        $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
       // $stylesheet = file_get_contents('css/std-ledger-pdf.css');
        //$mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML("<h3 style='text-align:center'>Previous students in class report of year($year)</h3>");
        $mpdf->WriteHTML($showleavestu);
        $mpdf->Output('Previous-student-class students-report-'.date("d-m-Y").'.pdf', 'D'); 


        return json_encode(['showleavestu'=>$showleavestu]);
     }

     /*=============== end of leave report*/

}//end of class
