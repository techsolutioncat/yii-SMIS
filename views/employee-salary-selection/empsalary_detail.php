       
  <table class="table table-bordered">
    <thead>
    	
      <tr class="info">
        <th>Basic Salary: <?= $basic['Basic_Salary']?>
        <input type="hidden" id="getBasicSalary" value="<?= $basic['Basic_Salary']?>">
        </th>
        <th>Group: <?= $basic['salary_pay_group']?>
        <th>Stage: <?= $basic['salary_pay_stages']?>
      </tr>
      
      <tr>
        <th>Total Allownces</th>
        <th>Total Fix Deduction</th>
        
      </tr>
    </thead>
    <tbody>

    <?php
  // echo '<pre>';print_r($emp); die;
     foreach ($emp as $emp) {
       //print_r($basicsalary);
     
      ?>
      
    
      <tr>
      <td><strong><?=$emp['sa_title']?></strong>: <?= $emp['total_allownces'] ?></td>
      <td><strong><?=$emp['ded_title']?></strong>: <?= $emp['total_fix_deduction'] ?></td>
      
      </tr>
      <?php }?>
      
      <?php// foreach ($basicsalary as $basic) {
//print_r($basic);
      	?>
      	<input type="hidden" id="getGroupId" value="<?= $basic['group_id']?>">
      	<input type="hidden" id="getStageId" value="<?= $basic['stage_id']?>">
      	
      	<tr class="success">
      	<td><strong>Total Allownces: </strong><?= $basic['total_allownces']?>
	<input type="hidden" id="totalAllownce" value="<?= $basic['total_allownces']?>">
      	</td>
      	<td><strong>Total Deductions: </strong><?= $basic['total_fix_deduction']?>
	<input type="hidden" id="totalDeduction" value="<?= $basic['total_fix_deduction']?>">
      	</td>
      	</tr>
      	<tr>
      	<!-- <th>Gross Salary: <?//= $basic['gros_salary']?> -->
<input type="hidden" id="grosssalaary" value="<?= $basic['gros_salary']?>">
      	<th>
      	</tr>

      	
      <?php //} ?>

        
        
      
      
      
    </tbody>
  </table>

  </fieldset>  