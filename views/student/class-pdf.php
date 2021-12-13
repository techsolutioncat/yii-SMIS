<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\widgets\Alert;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use app\models\StudentInfo;
use app\models\StudentParentsInfo;
//echo '<pre>';print_r($dataprovider);die;
//echo 'herealdsjhklakjkdshfalksjddfhalskjdfhlaksjdfhlaksdfasdfsa';
/* @var $this yii\web\View */


?>
<style>


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

table{

/* width:950px;
margin-left:19%;
border-collapse: separate;
border-spacing: 5px; */

}

th, tr, td  {
border:1px solid #469DC8;
padding:10px;
font-size:1.5em;
}

tr:nth-child(even){background-color: #f2f2f2}

#h3_custom{
margin-top:-40px;
float:right; 
color:#39538A;
font-size:23px;
text-align:center;

}

#stud_details{
padding:5px;

background-color: #469DC8;
font-size:19px;
font-weight:bold;

}

#listing{
cell-padding:1;
cell-spacing:1;
}

#centered{
margin-left:200px !important;
margin-top:80px;
color:#39538A;
font-size:19px;
width:800px;

}

#footer_table{
border:0;
margin-top:0px;
}



#dmc_footer{
margin-top:0px;

font-size:19px;
font-weight:bold;
text-align:center;
border:0px !important;
}

  
</style>

<?php 

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

<table class="table table-bordered">
    <thead>
      <tr>
      <th>Sr</th>
      <?php if($regclass == 1){?>
        
    
           <?php }else{?>
         <th>Reg. No.</th>
            <?php } ?>
        <?php if($thisinputname == 1){?>
        
    
           <?php }else{?>
            <th class="fullnameClassHeader">Full Name</th>
            <?php } ?>
        

       <?php if($parntclass == 1){}else{?>
        
        <th>Parent Name</th>
        <?php }?>


       
      <?php if($grpclass == 1){?>
        
    
           <?php }else{?>
            <th><?=Yii::t('app','Group')?></th>
            <?php } ?>
    

        <?php if($sectinclass == 1){?>
        
    
           <?php }else{?>
            <th><?=Yii::t('app','Section')?></th>
            <?php } ?>
        
    <?php if($classcntct == 1){?>
        
    
           <?php }else{?>
            <th><?=Yii::t('app','Parent Contact')?></th>
            <?php } ?>

        

         <?php if($dobclass == 1){?>
        
    
           <?php }else{?>
            <th><?=Yii::t('app','DOB')?></th>
            <?php } ?>

        <?php if($adrsclass == 1){?>
        
    
           <?php }else{?>
            <th><?=Yii::t('app','Address')?></th>
            <?php } ?>
      </tr>
    </thead>
    <tbody>
    <?php 
    $sr=0;
    foreach ($dataprovider as $data) {
        $sr++;
        ?>
      <tr>
      <td><?=$sr; ?></td>

      <?php if($regclass == 1){?>
         
    
            <?php }else{?>
            <td><?= $data->user->username; ?></td>
            <?php } ?>
        

      <?php if($thisinputname == 1){?>
        
    
           <?php }else{?>
           <td class="fullnameClass">

        <?php echo Yii::$app->common->getName($data->user_id); ?>
            
        </td>
            <?php } ?>


        

       <?php if($parntclass == 1){?>
        
    
           <?php }else{?>
            <td>
       
          <?php echo Yii::$app->common->getParentName($data->stu_id); ?>
                    
       </td>
    
            <?php } ?>


        

          

          
  


        


           <td>
          <?php if($grpclass == 1){?>
        
    
           <?php }else{?>
           <?php if(!empty($data->group->title)){echo $data->group->title;}else{echo "N/A";} ?>
            <?php } ?> 
            </td>
            

          <?php if($sectinclass == 1){?>
           <?php }else{?>
           <td>
          <?= $data->section->title; ?>
            
            </td>
            <?php } ?>
        
        
        <?php if($classcntct == 1){?> 
        <?php }else{?>
           <td>
             
            <?php 
        $name = StudentParentsInfo::find()->where(['stu_id'=>$data->stu_id])->one();
        echo $name->contact_no;


         ?>
        
         </td>
          <?php } ?>

        

<?php if($dobclass == 1){?>
        
    
           <?php }else{?>
            <td>
             
            <?= date('d M,Y',strtotime($data->dob)); ?>
            </td>
            <?php } ?>
            

        

        

        <?php if($adrsclass == 1){?>
        
    
           <?php }else{?>
            <td><?php if($data->location1){
                echo $data->location1;
            }else{
                echo 'N/A';
                } ?></td>
            <?php } ?>


      </tr>
      <?php } ?>
      
      
    </tbody>
  </table>
