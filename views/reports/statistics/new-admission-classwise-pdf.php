<?php 
use app\models\RefClass;

?>


          <table class="table table-striped" >
            <thead>
              <tr>
                <th>Class</th>
                <th>No of Students</th>
                <th>Percentage</th>
              </tr>
            </thead>
            <tbody>
              <?php 
    
                $getAllClasses=RefClass::find()->where(['fk_branch_id'=>yii::$app->common->getBranch(),'status'=>'active'])->all();
                foreach ($getAllClasses as $allclass) {
                  // echo "<pre>";print_r($allclass);
                  //continue;
    
    //continue;
                
               $newadmisnAvg=yii::$app->db->createCommand("select abc.class_id,abc.class_name,abc.No_Of_Student as `No_of_student_newly_admitted`, ( (abc.No_Of_Student) / (SELECT count(*) FROM student_info si2 inner join ref_class rc on rc.class_id=si2.class_id where si2.fk_branch_id=".yii::$app->common->getBranch()." and rc.title='".$allclass->title."' and si2.is_active =1) ) * 100 as `Percentage_of_newly_admitted_student` from (select rc.class_id, rc.title as class_name, count(*) as `No_Of_Student` from student_info si inner join ref_class rc on rc.class_id=si.class_id where si.stu_id not in (select fk_stu_id from stu_reg_log_association) and title = '".$allclass->title."' and si.fk_branch_id=".yii::$app->common->getBranch()." and si.is_active = 1 GROUP by rc.class_id, rc.title) abc")->queryAll();
                  /// echo '<pre>';print_r($newadmisnAvg);
                   //continue;
               $admissionarray=[];
               foreach ($newadmisnAvg as $newadmisnAvgx) {?>
              <tr>
                <td><?php echo $admissionarray[]=$newadmisnAvgx['class_name'];?></td>
                <td><?php echo $admissionarray[]=$newadmisnAvgx['No_of_student_newly_admitted'];?></td>
                <td><?php echo round($admissionarray[]=$newadmisnAvgx['Percentage_of_newly_admitted_student'],2).'%';?></td>
              </tr>
              <?php }
             }
                ?>
               
            
              
            </tbody>
          </table>
       