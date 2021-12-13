<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\EmplEducationalHistoryInfo;
$this->registerCss(" 
 
@media print{    
 
    .footer{
        display:none;
    }
 }

");
?>
<div class="employee-generate-pdf-biometirc">
    <h3 style="text-align: center;margin-bottom: 20px;">Employees Biometric Id's</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Biometric ID</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
            foreach ($query as $items){
                $name= '';
                if($items['first_name']){
                    $name .=$items['first_name'];
                }
                if($items['middle_name']){
                    $name .= ' '.$items['middle_name'];
                }
                if($items['last_name']){
                    $name .= ' '.$items['last_name'];
                }
                ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$name?></td>
                    <td><?=$items['id']?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
</div>

