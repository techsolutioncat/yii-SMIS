<?php 
  use yii\helpers\Url;
  use app\models\RefClass;
 
 ?>     
  <style>
th, tr, td  {
border:1px solid #469DC8;
padding:10px;
font-size:1.5em;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>  
          
                  <table class="table table-striped" align="center">
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
                                <?php echo $leaveInfo['total_student']; ?>
                                </a>
                                </td>
                               
                            </tr>
                            <?php } ?>
                            </tbody>
                     </table>
                     