<?php
  include 'database.php';
  $limit = 5;

  if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
  $start_from = ($page-1) * $limit; 

      $sql = "SELECT `product`.*,categories.category as category_name FROM product JOIN categories ON product.categories_id = categories.id "; 

      if(isset($_GET['query']) && $_GET['query'] != '')
      {
        $sql .=' WHERE product.title LIKE "%'.str_replace(' ', '%', $_GET['query']).'%" ';
      }
  
      $sql .=" ORDER BY id ASC LIMIT $start_from, $limit";

  $rs_result = mysqli_query($conn, $sql);  

?>


  <br>
 <table class="table table-bordered table-striped">  
<thead>  
  <tr>  
  <th>Title</th>  
  <th>Category Name</th>  
  <th>Price</th>  
  <th>Qty</th>  
  </tr>  
</thead>  
<tbody>  
<?php  
while ($row = mysqli_fetch_array($rs_result)) {  
?>  
    <tr>  
    <td><?=$row['title'];?></td>
    <td><?=$row['category_name'];?></td>
    <td><?=$row['price'];?></td>
    <td><?=$row['qty'];?></td>  
    </tr>  
<?php  
};  
?>  
</tbody>  
</table>