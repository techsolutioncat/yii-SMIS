<?php
use app\assets\HighChartsAsset;
/* @var $this yii\web\View */
/* @var $model app\models\Exam */

 
$data = [];
$single = [];
$pi=[]; 
foreach($subjects_Query as $subjects){ 
    $data[]= [
        'type'=>'column',
        'name'=>$subjects['subject'],
        'data'=>[number_format((float)$subjects['marks_obtained'], 2, '.', '')]
    ];  
    $single[]= $subjects['subject'];
}

foreach ($pi_query as $key=>$piquery){
    $pi[]= [
            'name'=>$piquery['grade'],
            'y'=>$piquery['marks_obtain'],
            //'color'=>'#12A54'.$key,
            'drilldown'=>$piquery['grade']
        ];
}
?>

<div class="exam-annalysis">
    <div class="col-md-6"><div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div></div>
    <div class="col-md-6"><div id="container-pie" style="min-width: 310px; height: 400px; margin: 0 auto"></div></div> 
    <?php
    $this->registerJS("
    var details = ".json_encode($data,JSON_NUMERIC_CHECK).";
    var pi = ".json_encode($pi,JSON_NUMERIC_CHECK).";
    var subjects = ".json_encode($subjects).";", \yii\web\View::POS_BEGIN);
    $this->registerJsFile(Yii::getAlias('@web').'/js/highcharts.js',['depends' => [yii\web\JqueryAsset::className()],null]);
    $this->registerJsFile(Yii::getAlias('@web').'/js/highcharts-analysis.js',['depends' => [yii\web\JqueryAsset::className()],null]);
    ?>
</div>












