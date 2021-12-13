<?php
$this->registerJS("
    var attendance_details = ".json_encode($attenance_data,JSON_NUMERIC_CHECK).";
    console.log(attendance_details);
     var chart = $('#container_attendance').highcharts();
        chart.series[0].setData(attendance_details);
    ", \yii\web\View::POS_READY);