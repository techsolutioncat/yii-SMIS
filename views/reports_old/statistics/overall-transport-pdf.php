 <p>
    <?php $transport=yii::$app->db->createCommand("select si.stu_id,concat (u.first_name,' ',u.middle_name,' ',u.last_name) as `student_name`,z.title as `zone_name`,r.title as `route_name`, s.title as `stop_name`,s.fare as `fare` from student_info si
        inner join user u on u.id=si.user_id
        inner join stop s on s.id=si.fk_stop_id
        inner join route r on r.id=s.fk_route_id
        inner join zone z on z.id=r.fk_zone_id where si.fk_branch_id='".yii::$app->common->getBranch()."'
        ")->queryAll(); ?>
    </p>
    <table class="table table-striped">
    <thead>
    <tr>
    <th>Student Name</th>
    <th>Zone</th>
    <th>Route </th>
    <th>Stop</th>
    <th>Fare</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($transport as $transports) {
       //echo '<pre>';print_r($withdrawlStud);
        ?>
    <tr>
    <td>
    <?= $transports['student_name'] ?>
    </td>
    <td>
    <?= $transports['zone_name'] ?>
    </td>
    <td>
    <?= $transports['route_name'] ?>
    </td>
    <td>
    <?= $transports['stop_name'] ?>
    </td>
    <td>
    <?= $transports['fare'] ?>
    </td>
    </tr>
    <?php } ?>
    </tbody>
    </table> 