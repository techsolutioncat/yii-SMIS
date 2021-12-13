<?php 
  use yii\helpers\Url;
 ?>
 <style>
   th, tr, td  {
border:1px solid #469DC8;
padding:10px;
font-size:1.5em;
}

tr:nth-child(even){background-color: #f2f2f2}
.logos{
    margin-top:-50px;
    margin-left:10px;
}



#img_span{
margin-top:-10px;
width: 1100px;
height:250px;
margin-left:-10px;

}

 </style>
<?php 

if(!empty(Yii::$app->common->getBranchDetail()->logo)){
    $logo = '/uploads/school-logo/'.Yii::$app->common->getBranchDetail()->logo;
}else{
    $logo = '/img/logo.png';
}
?>

                       <a href="/mis/">
                           <img src="<?= Url::to('@web').$logo ?>" alt="<?=Yii::$app->common->getBranchDetail()->name.'-logo'?>">
                       </a>

        <div>
                  <table class="table table-striped" align="center">
                          <thead>
                          <tr>
                            <th>SR</th>
                            <th>Class</th>
                            <th>No Of Students</th>
                             </tr>
                           </thead>
                           <tbody>
                            <?php
                            $count=0;
                            $sum=0;
                           // echo '<pre>';print_r($year);die;
                             foreach ($years as $years) {
                              $count++;
                              $sum=$sum+$years['No_of_students'];

                              ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $years['class_wise']; ?></td>
                                <td><?php echo $years['No_of_students']; ?> </td>
                                
                            </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td></td>
                                <td></td>
                                <td>Total Students: <?= $sum; ?></td>
                              </tr>
                            </tfoot>
                     </table>
                     </div>