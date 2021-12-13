<?php

namespace app\controllers;

use Yii;
use app\models\RefDegreeType;
use app\models\RefClass;
use app\models\RefGroup;
use app\models\RefSection;
use app\models\StudentInfo;
use app\models\Branch;
use app\models\search\RefDegreeTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use mPDF;

/**
 * DegreeController implements the CRUD actions for RefDegreeType model.
 */
class BranchReportsController extends Controller
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

        /*CLASS WISE QUERY WITHOUT BRANCH*/
        $getclaswise = StudentInfo::find()
            ->select(['rc.class_id','rc.title class_name','count(*) No_of_new_admission_class_wise'])
            ->innerJoin('ref_class rc','rc.class_id = student_info.class_id')
            ->where(['NOT IN','stu_id','select fk_stu_id from stu_reg_log_association'])
            ->andWhere(['rc.status'=>'active'])
            ->andWhere(['student_info.is_active'=>1])
            /*->andWhere(['rc.fk_branch_id'=>9])*/
            ->groupBy(['rc.class_id','rc.title'])
            ->asArray()
            ->all();

        /* CLASS WISE STUDENT INACTIVE WITHOUT BRANCH*/
        $getclaswiseDeactive = StudentInfo::find()
            ->select(['rc.class_id','rc.title class_name','count(*) No_of_new_admission_class_wise'])
            ->innerJoin('ref_class rc','rc.class_id = student_info.class_id')
            ->where(['NOT IN','stu_id','select fk_stu_id from stu_reg_log_association'])
            ->andWhere(['rc.status'=>'active'])
            ->andWhere(['student_info.is_active'=>0])
            /*->andWhere(['rc.fk_branch_id'=>9])*/
            ->groupBy(['rc.class_id','rc.title'])
            ->asArray()
            ->all();
        /*PROMOTED STUDENT CLASS WISE.*/
        $promotedclaswise = StudentInfo::find()
            ->select(['rc.title class_name','count(*) No_of_new_promoted_class_wise'])
            ->innerJoin('ref_class rc','rc.class_id = student_info.class_id')
            ->where('student_info.stu_id in (select fk_stu_id from stu_reg_log_association)')
            ->groupBy(['rc.title'])
            ->asArray()
            ->all();

        /*query new add avg.*/
        $newadmisnAvg=yii::$app->db->createCommand("select abc.class_name,abc.No_Of_Student, ((abc.No_Of_Student)/ (select count(*) from student_info))*100 as `Average_Newly_Admitted_Students_per_Class` from (select rc.title as `class_name`, count(*) as `No_Of_Student` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id not in (select fk_stu_id from stu_reg_log_association) and si.is_active=1 GROUP by rc.title)abc
                ")->queryAll();

        $promtedclasswixeAvg=yii::$app->db->createCommand("select abc.class_name,abc.No_Of_Student, ((abc.No_Of_Student)/ (select count(*) from student_info))*100 as `Average_Promoted_Students_per_Class` from (select rc.title as `class_name`, count(*) as `No_Of_Student` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id in (select fk_stu_id from stu_reg_log_association) and si.is_active=1 GROUP by rc.title)abc")->queryAll();

        /**********************************transport queries starts here****************************************************/

        $transport= StudentInfo::find()
            ->select(['student_info.stu_id','concat (u.first_name," ",u.middle_name," ",u.last_name) student_name','z.title zone_name','r.title route_name','s.title stop_name','s.fare fare'])
            ->innerJoin('user u','u.id=student_info.user_id')
            ->innerJoin('stop s','s.id=student_info.fk_stop_id')
            ->innerJoin('route r','r.id=s.fk_route_id')
            ->innerJoin('zone z','z.id=r.fk_zone_id')
            ->where(['student_info.fk_branch_id'=>yii::$app->common->getBranch()])
            ->orderBy(['u.first_name'=>SORT_ASC])
            ->asArray()
            ->all();

        /*avail transport.*/

        $availTransport=StudentInfo::find()->where(['not', ['fk_stop_id' => null]])->count();


        /**********************************transport queries Ends here****************************************************/

        return $this->render('statistics', [
            'getclaswise'       => $getclaswise,
            'promotedclaswise'  => $promotedclaswise,
            'newadmisnAvg'      => $newadmisnAvg,
            'promtedclasswixeAvg' => $promtedclasswixeAvg,
            'getclaswiseDeactive' => $getclaswiseDeactive,
            'model'             => $model,
            'transport'         => $transport,
            'availTransport'    => $availTransport,
        ]);
    }

    public function actionStatistic(){
        $getAllBranches=Branch::find()->all();
         return $this->render('statisticsBranch',[
            'getAllBranches'=>$getAllBranches,
            ]);
    }

    /**
     * @return Action Acadamics
     */
    public function actionAcademics()
    {
        return $this->render('academics', [
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
            // echo '1';
            $where = "where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1  and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and rc.class_id=".$class." and sa.leave_type <>'present' 
                group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type";
        }else if(!empty($class) && !empty($grp) && empty($section)){
            // echo '2';

            $where = "where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1  and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and rc.class_id=".$class." and rg.group_id =".$grp."  and sa.leave_type <>'present'
                group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type";
        }else if(!empty($class) && !empty($grp) && !empty($section)){
            //echo '3';

            $where = "where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1  and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and rc.class_id=".$class."'and rg.group_id =".$grp."  and sa.leave_type <>'present'  and rs.section_id=".$section."
                group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type";
        }

        else{
            // echo '4';

            $where = "where si.fk_branch_id='".yii::$app->common->getBranch()."' and si.is_active=1  and sa.date BETWEEN '".$startcnvrt."' and '".$endcnvrt."' and sa.leave_type <>'present'
                group by rc.class_id,rc.title,rg.group_id,rg.title,rs.section_id,rs.title,sa.leave_type";
        }

        $query=yii::$app->db->createCommand("
                select count(sa.leave_type) as total,rc.class_id,rc.title,rg.group_id,rg.title as group_title,rs.section_id,rs.title as section_title,sa.leave_type from student_attendance sa 
                inner join student_info si on si.stu_id=sa.fk_stu_id
                inner join ref_class rc on rc.class_id=si.class_id 
                left join ref_group rg on rg.group_id=si.group_id
                left join ref_section rs on rs.section_id=si.section_id
                
            ".$where )->queryAll();
        //echo $query;die;
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
    public function actionGetAllZoneGeneric(){
        $zoneQuery =  StudentInfo::find()
            ->select(['z.id as zone_id','z.title as zone_name','count(student_info.stu_id) as no_of_students_availed_transport'])
            ->innerJoin('stop s','s.id=student_info.fk_stop_id')
            ->innerJoin('route r','r.id=s.fk_route_id ')
            ->innerJoin('zone z','z.id=r.fk_zone_id')
            ->where(['student_info.is_active'=>1])
            ->groupBy(['z.id','z.title'])
            ->asArray()
            ->all();

        $zoneView=$this->renderAjax('statistics/zone-generic',['zone'=>$zoneQuery]);

        return json_encode(['zonegenric'=>$zoneView]);
    }

    public function actionGetrouteZonewise(){
        $zoneid=yii::$app->request->post('zoneid');

        $routeQuery =  StudentInfo::find()
            ->select(['count(student_info.stu_id) no_of_students_availed_transport','z.id zone_id','z.title zone_name','r.id route_id','r.title route_name'])
            ->innerJoin('stop s','s.id = student_info.fk_stop_id')
            ->innerJoin('route r','r.id = s.fk_route_id ')
            ->innerJoin('zone z','z.id = r.fk_zone_id')
            ->where(['student_info.is_active'=>1,'z.id'=>$zoneid])
            ->groupBy(['z.id','z.title','r.id','r.title'])
            ->asArray()
            ->all();

        // echo '<pre>';print_r($routeQuery);die;

        $routeView=$this->renderAjax('statistics/route-zone',['route'=>$routeQuery]);

        return json_encode(['zoneRoutes'=>$routeView]);
    }


    public function actionGetstopRoutewise(){
        $routeid=yii::$app->request->post('routeid');
        $zoneid=yii::$app->request->post('zoneid');

        $stopQuery =  StudentInfo::find()
            ->select(['count(student_info.stu_id) no_of_students_availed_transport','z.id zone_id','z.title zone_name','r.id route_id','r.title route_name','s.id stop_id','s.title stop_name'])
            ->innerJoin('stop s','s.id = student_info.fk_stop_id')
            ->innerJoin('route r','r.id = s.fk_route_id ')
            ->innerJoin('zone z','z.id = r.fk_zone_id')
            ->where(['student_info.is_active'=>1,'z.id'=>$zoneid,'r.id'=>$routeid])
            ->groupBy(['z.id','z.title','r.id','r.title','s.id','s.title'])
            ->asArray()
            ->all();

        $stopView=$this->renderAjax('statistics/stop-route',['stop'=>$stopQuery]);

        return json_encode(['stopRoutes'=>$stopView]);
    }

    public function actionGetstudentStopwise(){
        $stopid=yii::$app->request->post('stopid');
        //  $zoneid=yii::$app->request->post('zoneid');
        /*yii::$app->db->createCommand("select DISTINCT(si.stu_id),concat (u.first_name,' ',u.middle_name,' ',u.last_name) as student_name, concat(spi.first_name,' ',spi.middle_name,' ',spi.last_name) as `father_name`,rs.title as `class_name`,rg.title as `group_name`,rs.title as `section_name`,si.contact_no, si.emergency_contact_no,z.title as `zone_name`,r.title as `route_name`, s.title as `stop_name` from student_info si
        inner join student_parents_info spi on spi.stu_id=si.stu_id
        inner join ref_class rc on rc.class_id=si.class_id
        left join ref_group rg on rg.group_id=si.group_id
        left join ref_section rs on rs.section_id=si.section_id
        inner join user u on u.id=si.user_id
        inner join stop s on s.id=si.fk_stop_id
        inner join route r on r.id=s.fk_route_id
        inner join zone z on z.id=r.fk_zone_id
        inner join transport_main tm on tm.fk_route_id=r.id
        inner join vehicle_info vi on vi.id=tm.fk_vechicle_info_id
        where si.fk_branch_id=".yii::$app->common->getBranch()." and si.is_active=1 and vi.Name like 'Bus%' and s.id=".$stopid."*/
        $stuQuery =  StudentInfo::find()
            ->select(['DISTINCT(student_info.stu_id)','concat (u.first_name," ",u.middle_name," ",u.last_name) as student_name','concat(spi.first_name," ",spi.middle_name," ",spi.last_name) as father_name','rs.title class_name','rg.title group_name','rs.title section_name','student_info.contact_no','student_info.emergency_contact_no','z.title zone_name','r.title route_name','s.title stop_name'])
            ->innerJoin('student_parents_info spi','spi.stu_id=student_info.stu_id')
            ->innerJoin('ref_class rc','rc.class_id=student_info.class_id')
            ->leftJoin('ref_group rg','rg.group_id=student_info.group_id')
            ->leftJoin('ref_section rs','rs.section_id=student_info.section_id')
            ->innerJoin('user u','u.id=student_info.user_id')
            ->innerJoin('stop s','s.id=student_info.fk_stop_id')
            ->innerJoin('route r','r.id = s.fk_route_id')
            ->innerJoin('zone z','z.id = r.fk_zone_id')
            ->innerJoin('transport_main tm','tm.fk_route_id=r.id')
            ->innerJoin('vehicle_info vi','vi.id=tm.fk_vechicle_info_id')
            ->where(['student_info.is_active'=>1,'s.id'=>$stopid])
            ->andWhere(['like','vi.Name','Bus'])
            ->asArray()
            ->createCommand()->getRawSql();
      /*  echo "select DISTINCT(si.stu_id),concat (u.first_name,' ',u.middle_name,' ',u.last_name) as student_name, concat(spi.first_name,' ',spi.middle_name,' ',spi.last_name) as `father_name`,rs.title as `class_name`,rg.title as `group_name`,rs.title as `section_name`,si.contact_no, si.emergency_contact_no,z.title as `zone_name`,r.title as `route_name`, s.title as `stop_name` from student_info si
        inner join student_parents_info spi on spi.stu_id=si.stu_id
        inner join ref_class rc on rc.class_id=si.class_id
        left join ref_group rg on rg.group_id=si.group_id
        left join ref_section rs on rs.section_id=si.section_id
        inner join user u on u.id=si.user_id
        inner join stop s on s.id=si.fk_stop_id
        inner join route r on r.id=s.fk_route_id
        inner join zone z on z.id=r.fk_zone_id
        inner join transport_main tm on tm.fk_route_id=r.id
        inner join vehicle_info vi on vi.id=tm.fk_vechicle_info_id
        where  si.is_active=1 and vi.Name like 'Bus%' and s.id=".$stopid;*/



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
                select fhw.fk_branch_id,CAST(fhw.created_date AS DATE) AS DATE_PURCHASED,dayname(fhw.created_date), sum(fhw.payment_received) as `fee_received` from fee_head_wise fhw where fhw.fk_branch_id=".yii::$app->common->getBranch()." and fhw.created_date between '".$startcnvrt."' and '".$endcnvrt."' GROUP by fhw.fk_branch_id , CAST(fhw.created_date AS DATE),dayname(fhw.created_date)
            ")->queryAll();
        //echo $query;die;
        //echo '<pre>';print_r($query);
        if(count($query)>0){
            $cashflowView=$this->renderAjax('finance/cashflow',['query'=>$query]);
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
                select fhw.fk_branch_id,CAST(fhw.created_date AS DATE) AS DATE_PURCHASED,dayname(fhw.created_date), sum(fhw.payment_received) as `fee_received` from fee_head_wise fhw where fhw.fk_branch_id=".yii::$app->common->getBranch()." and fhw.created_date between '".$startcnvrt."' and '".$endcnvrt."' GROUP by fhw.fk_branch_id , CAST(fhw.created_date AS DATE),dayname(fhw.created_date)
            ")->queryAll();
        //echo $query;die;
        //echo '<pre>';print_r($query);
        if(count($query)>0){
            $cashflowView = $this->renderPartial('finance/cashflow',['query'=>$query]);

            $this->layout = 'pdf';
            $mpdf = new mPDF('','', 0, '', 2, 2, 3, 3, 2, 2, 'A4');
            $mpdf->WriteHTML("<h3 style='text-align:center'>Cash Flow</h3>");
            $mpdf->WriteHTML($cashflowView);
            $mpdf->Output('daily-cash-flow-'.date("d-m-Y").'.pdf', 'D');

        }else{
            $cashflowView= "<div class='row'><div class='Alert alert-warning'><strong>Not Found!</strong></div> </div>";
            return json_encode(['cashflowhere'=>$cashflowView]);
        }


    }

    public function actionAllBranchReports(){
        $branchid=yii::$app->request->post('branchid');
        /*CLASS WISE QUERY WITHOUT BRANCH*/
        $getclaswise = StudentInfo::find()
            ->select(['rc.class_id','rc.title class_name','count(*) No_of_new_admission_class_wise'])
            ->innerJoin('ref_class rc','rc.class_id = student_info.class_id')
            ->where(['NOT IN','stu_id','select fk_stu_id from stu_reg_log_association'])
            ->andWhere(['rc.status'=>'active'])
            ->andWhere(['student_info.is_active'=>1])
            ->andWhere(['rc.fk_branch_id'=>$branchid])
            ->groupBy(['rc.class_id','rc.title'])
            ->asArray()
            ->all();
        /* CLASS WISE STUDENT INACTIVE WITHOUT BRANCH*/
        $getclaswiseDeactive = StudentInfo::find()
            ->select(['rc.class_id','rc.title class_name','count(*) No_of_new_admission_class_wise'])
            ->innerJoin('ref_class rc','rc.class_id = student_info.class_id')
            ->where(['NOT IN','stu_id','select fk_stu_id from stu_reg_log_association'])
            ->andWhere(['rc.status'=>'active'])
            ->andWhere(['student_info.is_active'=>0])
            ->andWhere(['rc.fk_branch_id'=>$branchid])
            ->groupBy(['rc.class_id','rc.title'])
            ->asArray()
            ->all();
            /*PROMOTED STUDENT CLASS WISE.*/
        $promotedclaswise = StudentInfo::find()
            ->select(['rc.title class_name','count(*) No_of_new_promoted_class_wise'])
            ->innerJoin('ref_class rc','rc.class_id = student_info.class_id')
            ->where('student_info.stu_id in (select fk_stu_id from stu_reg_log_association)')
            ->andWhere(['rc.fk_branch_id'=>$branchid])
            ->groupBy(['rc.title'])
            ->asArray()
            ->all();

        $newadmisnAvg=yii::$app->db->createCommand("select abc.class_name,abc.No_Of_Student, ((abc.No_Of_Student)/ (select count(*) from student_info))*100 as `Average_Newly_Admitted_Students_per_Class` from (select rc.title as `class_name`, count(*) as `No_Of_Student` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id not in (select fk_stu_id from stu_reg_log_association) and si.is_active=1 and rc.fk_branch_id=".$branchid." GROUP by rc.title)abc
            ")->queryAll();

        $promtedclasswixeAvg=yii::$app->db->createCommand("select abc.class_name,abc.No_Of_Student, ((abc.No_Of_Student)/ (select count(*) from student_info))*100 as `Average_Promoted_Students_per_Class` from (select rc.title as `class_name`, count(*) as `No_Of_Student` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id in (select fk_stu_id from stu_reg_log_association) and si.is_active=1 and si.fk_branch_id =".$branchid." GROUP by rc.title)abc")->queryAll();

        $transport= StudentInfo::find()
            ->select(['student_info.stu_id','concat (u.first_name," ",u.middle_name," ",u.last_name) student_name','z.title zone_name','r.title route_name','s.title stop_name','s.fare fare'])
            ->innerJoin('user u','u.id=student_info.user_id')
            ->innerJoin('stop s','s.id=student_info.fk_stop_id')
            ->innerJoin('route r','r.id=s.fk_route_id')
            ->innerJoin('zone z','z.id=r.fk_zone_id')
            ->where(['student_info.fk_branch_id'=>$branchid])
            ->orderBy(['u.first_name'=>SORT_ASC])
            ->asArray()
            ->all();

        /*avail transport.*/

        $availTransport=StudentInfo::find()->where(['not', ['fk_stop_id' => null]])
        ->andWhere(['fk_branch_id'=>$branchid])
        ->count();

        $zoneQuery =  StudentInfo::find()
            ->select(['z.id as zone_id','z.title as zone_name','count(student_info.stu_id) as no_of_students_availed_transport'])
            ->innerJoin('stop s','s.id=student_info.fk_stop_id')
            ->innerJoin('route r','r.id=s.fk_route_id ')
            ->innerJoin('zone z','z.id=r.fk_zone_id')
            ->where(['student_info.is_active'=>1])
            ->andWhere(['student_info.fk_branch_id'=>$branchid])
            ->groupBy(['z.id','z.title'])
            ->asArray()
            ->all();


        $viewBranches=$this->renderAjax('statistics/allbarches-reports-statistics',['getclaswise'=>$getclaswise,'getclaswiseDeactive'=>$getclaswiseDeactive,'promotedclaswise'=>$promotedclaswise,'newadmisnAvg'=>$newadmisnAvg,'promtedclasswixeAvg'=>$promtedclasswixeAvg,'availTransport'=>$availTransport,'transport'=>$transport,'zone'=>$zoneQuery]);

        return json_encode(['viewBranches'=>$viewBranches]);
    }
} // end of class

