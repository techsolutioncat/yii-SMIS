<?php $rows = empty($_POST['rows']) ? 0 : (int)$_POST['rows'] ; ?>

<?php if(0 !== $rows): ?>
	<?php foreach(range(1, $rows) as $key => $row): ?>
          <div>
            <!-- <p>Class <?php //echo $row; ?></p> -->
            <!-- Create a PHP array compatible set of inputs, using $row as the index -->
            <div class="row">
            <div class="col-md-6">
            <br />
            <!-- <?php // echo $row; ?> -->
            <input type="text" name="feeheads-title[]" class="form-control headss" />
            </div><br />
            <div class="col-md-6">
              <select class="form-control fee_modes" name="FeeHeads[fk_fee_method_id][<?php echo $key;?>]">
                <option value="">Select Fee Modes</option>
              </select>
            </div>
            </div>
          </div>
        <?php endforeach; ?>



      <?php endif; ?>