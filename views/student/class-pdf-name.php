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
            <th class="fullnameClassHeader"><?=Yii::t('app','Full Name')?></th>
            <?php } ?>
        

       <?php if($parntclass == 1){}else{?>
        
        <th>Parent Name</th>
        <?php }?>


        

        <?php
         if($inputclass == 1){?>
        
    
           <?php }else{?>
            <th><?=Yii::t('app','Class')?></th>
            <?php } ?>

       
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
            <td><?= $data->username; ?></td>
            <?php } ?>
        

      <?php if($thisinputname == 1){?>
        
    
           <?php }else{?>
           <td class="fullnameClass">

        <?php echo Yii::$app->common->getName($data->id); ?>
            
        </td>
            <?php } ?>


        

       <?php if($parntclass == 1){?>
        
    
           <?php }else{?>
            <td>
        <?php
          $student = StudentInfo::find()->where(['user_id'=>$data->id])->one();
                     echo Yii::$app->common->getParentName($student['stu_id']); ?>
                    
       </td>
    
            <?php } ?>


        

          

          <?php if($inputclass == 1){?>
        
    
           <?php }else{?>
           
           <td><?php
          $cls = StudentInfo::find()->where(['user_id'=>$data->id])->one();
          if(empty($cls)){
            echo "N/A";
          }else{
            echo $cls->class->title;
          }
          ?></td>
            <?php } ?>
  


        


           <?php if($grpclass == 1){?>
        
    
           <?php }else{?>
           <td><?php
         $grp = StudentInfo::find()->where(['user_id'=>$data->id])->one();
         if(empty($grp)){
          echo "N/A";
          }else{
            echo $grp->group['title'];
          }


          ?></td>
            <?php } ?>


            <?php if($sectinclass == 1){?>
        
    
           <?php }else{?>
           
           <td><?php 
             $sctn = StudentInfo::find()->where(['user_id'=>$data->id])->one();
             if(empty($sctn)){

              }else{
                echo $sctn->section->title;
              }

             ?>
               
             </td>
            <?php } ?>
        
        

  <?php if($classcntct == 1){?>
        
    
           <?php }else{?>
           <td><?php
          // echo $data['id'];
        $student = StudentInfo::find()->where(['user_id'=>$data->id])->one();
        if(count($student)>0){
        $name = StudentParentsInfo::find()->where(['stu_id'=>$student->stu_id])->one();

        }
        if(empty($name->contact_no)){
          echo "N/A";
        }else{
         echo $name->contact_no; 
        }  ?></td>
            <?php } ?>

        


            <?php if($dobclass == 1){?>
        
    
           <?php }else{?>
            <td><?php
        $dob = StudentInfo::find()->where(['user_id'=>$data->id])->one();
        if(empty($dob)){

              }else{
                echo date('d M,Y',strtotime($dob->dob));
              }

          ?></td>
            <?php } ?>

        

        

        <?php if($adrsclass == 1){?>
        
    
           <?php }else{?>
            <td><?php

            $locatn1 = StudentInfo::find()->where(['user_id'=>$data->id])->one();
            if(empty($locatn1)){
              echo "N/A";
              }else{
              echo $locatn1->location1;
              }
           
      
                ?></td>
            <?php } ?>


      </tr>
      <?php } ?>
      
    </tbody>
  </table>
