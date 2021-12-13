<?php
use yii\helpers\Url;
use yii\helpers\Html;
 

?>
<div class="col-md-6">
    <div class=" shade fee-res-left cscroll table-bord">
    	<div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fst_center">No.</th>
                <th>Challan</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <?php
            $i=1;
            foreach ($query as $item){
                ?>
                <tr>
                    <td class="fst_center"><?=$i?></td>
                    <td><?=$item['challan_no']?></td>
                    <td><?=strtoupper($item['name'])?></td>
                    <td>
                        <a href="javascript:void(0);" title="View" id="view-challan-details" data-url="<?=Url::to(['fee/challan-details-form'])?>" data-challanid="<?=$item['challan_id']?>" data-stdid="<?=$item['stu_id']?>"><img src="<?= Url::to('@web/img/view-table.svg') ?>" alt="MIS" /></a>
                    </td>
                </tr> 
                <?php
                $i++;
            }
            ?>
            <tbody>
            </tbody>
        </table>
    </div>
    <?php
		$this->registerJS("$('.cscroll').mCustomScrollbar({theme:'minimal-dark'});", \yii\web\View::POS_LOAD); 
	 ?>
    </div>
</div>
<div class="col-md-6 fee-res-right table-bord" id="fee-head-details">
	
</div>


