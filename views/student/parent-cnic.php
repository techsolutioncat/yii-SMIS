<?php 

use app\models\SalaryAllownces;
 ?> 
        
  <table class="table table-striped">
    <thead>
    
      <tr>
        <th>Name</th>
        <th>Class</th>
        <th>Group</th>
        <th>Section</th>
        
      </tr>
    </thead>
    <tbody>
    <?php
    //print_r($parntcnic);die;
   // if(count($parntcnic) > 0){

     // $amount=0;
     foreach ($parntcnic as $cnic) {
       
      
      //print_r($cnic);die;
     
      ?>
      <tr>
        <td><?php if(empty($cnic['student_name'])){
          echo "N/A";
          }else{
            echo $cnic['student_name'];
            }?></td>
          <td><?php if(empty($cnic['class_name'])){
        echo "N/A";
        }else{
          echo $cnic['class_name'];
          }?></td>

      <td><?php if(empty($cnic['group_name'])){
        echo "N/A";
        }else{
          echo $cnic['group_name'];
          }?></td>

      <td><?php if(empty($cnic['section_name'])){
        echo "N/A";
        }else{
          echo $cnic['section_name'];
       }?>
         
       </td>
      </tr>
      <?php } ?>
      
    
      <!-- <tr>
      <td>
        <?php /*if(empty($cnic->stu->user->first_name)){
          echo "N/A";
      }else{
        echo $cnic->stu->user->first_name;
           }?>
      </td>
      <td>
        <?php if(empty($cnic->stu->class->title)){
          echo "N/A";
      }else{
        echo $cnic->stu->class->title;
        }?>
      
      </td>
      <td><?php if(empty($cnic->stu->group->title)){
          echo "N/A";
      }else{
        echo $cnic->stu->group->title;
        }?></td>
      <td><?php if(empty($cnic->stu->section->title)){
          echo "N/A";
      }else{
        echo $cnic->stu->section->title;
        }?></td>
      </tr>
      <?php }*/?>
      
        
         -->
      
      
      
    </tbody>
  </table>

  </fieldset>  