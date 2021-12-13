 <?php 
use yii\helpers\Url;

  ?>
 <table class="table table-bordered">
    <thead>
      <tr class="success">
        <th></th>
        <th>Select Class</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($clas as $classes) { ?>
      <tr>
        <td><input type="checkbox" value="<?php echo $classes->class_id ?>" id="class-id" class="classesVal" name="FeeGroup[fk_class_id][]"></td>
        <td><?php echo $classes->title?></td>
      </tr>
      <?php } ?>
    <tr class="info">
        <td></td>
        <td><input type="submit" id="assignFees" name="submit" value="Assign Fee" class="btn btn-success pull-right" data-url=<?php echo Url::to(['branch/create-assign-fee']) ?>></td>
    </tr>
    </tbody>
  </table>