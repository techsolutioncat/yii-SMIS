<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

$examtype_array = ArrayHelper::map(\app\models\ExamType::find()->where(['fk_branch_id'=>Yii::$app->common->getBranch()])->all(), 'id', 'type');
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ExamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<style>
    table{
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    tbody{
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    thead{
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tr{
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    th{
        vertical-align: bottom;
        border-bottom: 2px solid #CCCCCC;
    }
    td{
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-bottom: 1px solid #CCCCCC;
    }
	
	.roll_no{
		border: 1px solid black;
		width: 47%;
		float: left;
		margin-left:20px;
		margin-bottom:50px;
	}
	.r_slip{
		font-size:12px;
		margin-left:30px !important;
		
	}
	.r_heading{
		font-size:13px;
		margin-left:5px;
		text-align:left;
		font-weight:bold;

	}
	.right{
		text-align:right;
		margin-right: 10px;
		border:1px solid black;
		margin-left
	}
	.p_break{
		page-break-after: always;
	}
				
           		

</style>
<h3 style="text-align: center;"><?="Roll No. Slips".'-'.$modelExam->fkClass->title.'-'.$modelExam->fkSection->title?></h3>
<div class="create-award-list-form ">
    <input type="hidden" id="total-marks" value="<?=$modelExam->total_marks?>"/>
    <div class="table-responsive" >
       

               <br>
               <br>

            <?php
                $i=1;
                foreach ($dataprovider as $key=>$data){
                    $student = \app\models\StudentInfo::findOne($data['stu_id']);
                    $current = \app\models\StudentMarks::find()->where(['fk_exam_id'=>$modelExam->id,'fk_student_id'=>$student->stu_id])->One();
                    //return $student->user->first_name.' '.$student->user->last_name;
                ?>
                
                        
						<div class = "roll_no">
						
						<div class="r_heading">New Islamia Public School & College Charsadda <br>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Roll Number Slip<br>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Annual examination 2018	</div>
                           <div class="right" style="margin-left:180px"> Roll No. &nbsp; &nbsp; &nbsp; <?=$student->user->username.'-'.$modelExam->fkSection->title ;?></div>
								<br><div style="margin-left:5px"><?=Yii::t('app','Reg. No')?>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u> <?=$student->user->username;?> </u>          <br>
                      
                                <?=Yii::t('app','Student')?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u><?=$student->user->first_name.' '.$student->user->last_name;?> </u>        <br>
                        
                            <?php
                            $studentParent = \app\models\StudentParentsInfo::find()->where(['stu_id'=>$data['stu_id']])->One();
                            if($studentParent->first_name){
                                $student_parent = $studentParent->first_name.' '.$studentParent->last_name;
                            }else{
                                $student_parent = 'N/A';
                            }
                            ?>
                              <?=Yii::t('app','Parent Name')?> : &nbsp; <u><?=$student_parent;?></u>       <br>  
								 <?='Class'?> : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u><?= $modelExam->fkClass->title.'-'.$modelExam->fkSection->title ?> </u>
								 
								 <br> <?='Balance:'?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ______________
								 </div>  <br><br><br> <div style="margin-left:240px; text-decoration: overline;"><?=Yii::t('app','Accounts Seal')?></div><br>
								 
								 
						   </div>
						   <div class = "roll_no">
						
						<div class="r_heading">New Islamia Public School & College Charsadda <br>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Roll Number Slip<br>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Annual examination 2018	</div>
                            <div class="right" style="margin-left:180px"> Roll No. &nbsp; &nbsp; &nbsp; <?=$student->user->username.'-'.$modelExam->fkSection->title ;?></div>
								<br><div style="margin-left:5px"><?=Yii::t('app','Reg. No')?>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u> <?=$student->user->username;?> </u>          <br>
                      
                                <?=Yii::t('app','Student')?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u><?=$student->user->first_name.' '.$student->user->last_name;?> </u>        <br>
                        
                            <?php
                            $studentParent = \app\models\StudentParentsInfo::find()->where(['stu_id'=>$data['stu_id']])->One();
                            if($studentParent->first_name){
                                $student_parent = $studentParent->first_name.' '.$studentParent->last_name;
                            }else{
                                $student_parent = 'N/A';
                            }
                            ?>
                              <?=Yii::t('app','Parent Name')?> : &nbsp; <u><?=$student_parent;?></u>       <br>  
								 <?='Class'?> : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u><?= $modelExam->fkClass->title.'-'.$modelExam->fkSection->title ?> </u>
								 
								 <br> <?='Balance:'?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ______________
								 </div>  <br><br><br> <div style="margin-left:240px; text-decoration: overline;"><?=Yii::t('app','Accounts Seal')?></div><br>
								 
								 
						   </div>
						   
                       
                    <?php
					
					if($i % 3 ==0)
					{
						{echo '<div class="p_break"></div>';}
					}
                    $i++;
                }

            ?>
            
    </div>
</div>

