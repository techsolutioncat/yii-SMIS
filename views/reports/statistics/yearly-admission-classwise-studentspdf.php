<?php 
  use yii\helpers\Url;


if(!empty(Yii::$app->common->getBranchDetail()->logo)){
    $logo = '/uploads/school-logo/'.Yii::$app->common->getBranchDetail()->logo;
}else{
    $logo = '/img/logo.png';
}
?>

         <div class="row">
             <div class="logos">
       <img src="<?= Url::to('@web').$logo ?>" alt="<?=Yii::$app->common->getBranchDetail()->name.'-logo'?>">
                 
             </div>
         </div>
 
      
                  <table class="table table-striped">
                  <?php  foreach ($yearAdmissionstudents as $yearAdmissionstudent) { }?>
                  <caption>Student Enrolled in <?php echo $yearAdmissionstudent['class_name']?> <?php if($yearAdmissionstudent['group_name'] == ''){}else{ echo $yearAdmissionstudent['group_name'] ;}?><?php echo  $yearAdmissionstudent['section_name'] .' in '.$years ?> </caption>
                          <thead>
                          <tr>
                            <th>SR</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            
                            <th>Registeration No.</th>
                            <th>Registeration Date</th>
                          

                            
                           </tr>
                           </thead>
                           <tbody>
                            <?php
                            $count=0;
                            $sum=0;
                           // echo '<pre>';print_r($yearAdmissionstudents);die;
                             foreach ($yearAdmissionstudents as $yearAdmissionstudentx) {
                              
                          //  echo '<pre>';print_r($yearAdmissionstudentx);
                            //continue;
                            //die;
                              $count++;

                              ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $yearAdmissionstudentx['student_name']; ?></td>
                                <td><?php echo $yearAdmissionstudentx['father_name']; ?></td>
                              
                                <td><?php echo $yearAdmissionstudentx['registration_no']; ?></td>
                                <td><?php echo $yearAdmissionstudentx['registration_date']; ?></td>
                                
                            </tr>
                            <?php }  ?>
                            </tbody>
                            
                     </table>
                     </div>