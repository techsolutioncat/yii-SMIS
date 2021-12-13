<?php use yii\helpers\Url;?> 
 <style>
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
</style>



                  <table class="table table-striped" align="center">
                        <thead>
                           <tr>
                            <th>SR</th>
                            <th>Title</th>
                            <th>Payment Received</th>
                            
                            </tr>
                        </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            $total=0;
                            foreach ($query as $queryy) {
                              $count++;
                              $total=$total+$queryy['payment_received'];
                              ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><?= $queryy['title'];?></td>
                                <td><?= $queryy['payment_received'];?></td>
                                
                            </tr>
                            <?php }
                            foreach ($extrahead_query as $query_extrahead) {
                            $count++;
                            $total=$total+$query_extrahead['payment_received'];
                            ?>
                            <tr>
                                <td><?= $count; ?></td>
                                <td><?= $query_extrahead['title'];?></td>
                                <td><?= $query_extrahead['payment_received'];?></td>

                            </tr>
                            <?php } ?>
                             <tr>
                               <td><?= $count + 1;?></td>
                               <td>Transport fare</td>
                               <td><?php echo $transportFare['transport_fare']; ?></td>
                                
                               </td>
                               
                           
                           </tr> 
                            <tr><th></th><td></td>
                            <th>Total: Rs. <?php echo $total; ?></th></tr>

                            </tbody>
                     </table>
                




                



