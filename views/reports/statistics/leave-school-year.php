<?php 
  use yii\helpers\Url;
  use app\models\RefClass;
 
 ?>     

           <div class="row">
    
                  <div class="col-md-12">
                  <table class="table table-striped">
                          <thead>
                          <tr>
                            <th>SR</th>
                          
                            <th>Class</th>
                            <th>No of Students</th>
                          </tr>
                           </thead>
                           <tbody>
                            <?php
                            $count=0;
                           // echo '<pre>';print_r($year);die;
                             foreach ($leaveInfo as $leaveInfo) {
                              $count++;
                              $class=RefClass::find()->where(['class_id'=>$leaveInfo['class_id']])->one();

                              ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $class->title; ?></td>
                                
                                <td>
                                <a class="leaveYearstud" data-clas="<?php echo $leaveInfo['class_id']?>" href="javascript:void(0)" data-url=<?= Url::to(['reports/leave-schol-class-student'])?> data-year=<?= $year;?>>
                                <?php echo $leaveInfo['total_student']; ?>
                                
                                </a>
                                </td>
                                <td></td>

                                 <td></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>
                     </div>
                     </div>