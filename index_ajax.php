<?php
  include 'database.php';
  $limit = 5;

  if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
  $start_from = ($page-1) * $limit; 

      $sql = "SELECT `classes`.*,college.college_name FROM classes LEFT JOIN college ON classes.college_id = college.id LEFT JOIN levels ON levels.classes_id = classes.id"; 

      if(isset($_GET['query']) && $_GET['query'] != '' && $_GET['query'] != null)
      {
        //$_SESSION['query'] = $_GET['query'];

        // $_value = $_SESSION['query'];
        $sql .=' WHERE classes.title LIKE "%'.trim($_GET['query']).'%" ';
        $sql .=' OR college.college_name LIKE "%'.trim($_GET['query']).'%" ';
        $sql .=' OR levels.value LIKE "%'.trim($_GET['query']).'%" ';


        /*$sql .=' WHERE classes.title LIKE "%'.str_replace(' ', '%', $_GET['query']).'%" ';
        $sql .=' OR college.college_name LIKE "%'.str_replace(' ', '%', $_GET['query']).'%" ';
        $sql .=' OR levels.value LIKE "%'.str_replace(' ', '%', $_GET['query']).'%" ';*/
      }
      
      $sql .=" GROUP BY classes.id";

      $sql .=" ORDER BY id DESC LIMIT $start_from, $limit";
      
      $rs_result = mysqli_query($conn, $sql); 

?>


  <br>
 <table class="table table-bordered table-striped">  
<thead>  
  <tr>  
  <th>Collage</th>  
  <th>Class</th>  
  <th>Level's</th>  
  <th>Action</th>  
  </tr>  
</thead>  
<tbody>  
<?php 
if($rs_result){ 
while ($row = mysqli_fetch_array($rs_result)) {  

  $classes_id =$row['id'];
  $sql3 = $sql = "SELECT `levels`.* FROM levels  WHERE levels.classes_id =  $classes_id;";

  $levels_result = mysqli_query($conn, $sql3); 

  $levels_list = '';
  $levels_count = 0;
  if($levels_result){ 
    while ($r = mysqli_fetch_array($levels_result)) 
    { 
      if($levels_count == 0)
      {
          $levels_list .= $r['value'];
      }
      else
      {
         $levels_list .= ','.$r['value'];
      }
      $levels_count++;
    }
  }

?>  
    <tr>  
    <td><?=$row['college_name'];?></td>
    <td><?=$row['title'];?></td>
    <td><?=$levels_list;?></td>
    <td>
      <a href="upload/<?php echo $row['syllabus']; ?>" class="btn btn-success" target="_blank">Download</a>
      <a href="edit_class.php?update_id=<?php echo $row['id']; ?>" class="btn btn-info" > Edit </a>
      <a href="delete.php?del_id=<?php echo $row['id']; ?>" class="btn btn-danger" > Delete</a>
    </td>  
    </tr>  
<?php  
}
}
else
{
?>
      <tr><td colspan="4"> No Record Found </td></tr>
<?php
} 
?>  
</tbody>  
</table>