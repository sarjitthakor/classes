<?php

   include('database.php'); 
   $limit = 5;
     
         /*$sql = "SELECT COUNT(`classes`.`id`) FROM classes";*/
         $sql = "SELECT COUNT(`classes`.`id`) FROM classes LEFT JOIN college ON classes.college_id = college.id LEFT JOIN levels ON levels.classes_id = classes.id";

   
         /*if(isset($_SESSION['query']) && $_SESSION['query'] != '' && $_SESSION['query'] != null)
         {
           $_value = $_SESSION['query'];
           $sql .=' WHERE classes.title LIKE "%'.str_replace(' ', '%', $_value).'%" ';
           $sql .=' OR college.college_name LIKE "%'.str_replace(' ', '%', $_value).'%" ';
           $sql .=' OR levels.value LIKE "%'.str_replace(' ', '%', $_value).'%" '; 
   
           echo $sql;  
         }*/
   
   $rs_result = mysqli_query($conn, $sql);  
   $row = mysqli_fetch_row($rs_result);
    
   $total_records = $row[0];  
   $total_pages = ceil($total_records / $limit); 
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Classes List</title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <?php  include('css.php'); ?>
      <head>
   <body>
      <div class="container">
         <div class="table-wrapper">
            <div class="table-title">
               <div class="row">
                  <div class="col-sm-6">
                     <h2>Classes List</h2>
                     <br>
                  </div>
               </div>
            </div>
            <div class="serach">
               <div class="col-sm-6">
                  <label>Search:</label> 
                  <input type='text' name='search' class="img-url" id='search_box' required="required">
                  <button  id="serach_btn" name="serach_btn" class="btn btn-info" > <span>Search </span> </button>
                  <button id="serach_clear" name="serach_clear" class="btn btn-danger" > <span>Clear </span></button>
               </div>
               <div class="col-sm-6">
                  <a href="add_class.php" class="btn btn-success" > <span>Add New Class </span></a> 
               </div>
               <br>
            </div>
            <div id="target-content">loading...</div>
            <div class="clearfix">
               <ul class="pagination">
                  <?php 
                     if(!empty($total_pages)){
                       for($i=1; $i<=$total_pages; $i++){
                           if($i == 1){
                             ?>
                  <li class="pageitem active" id="<?php echo $i;?>"><a href="JavaScript:Void(0);" data-id="<?php echo $i;?>" class="page-link" ><?php echo $i;?></a></li>
                  <?php 
                     }
                     else{
                       ?>
                  <li class="pageitem" id="<?php echo $i;?>"><a href="JavaScript:Void(0);" class="page-link" data-id="<?php echo $i;?>"><?php echo $i;?></a></li>
                  <?php
                     }
                     }
                     }
                     ?>
               </ul>
               </ul>
            </div>
         </div>
      </div>
      <?php  include('js.php'); ?>
      <script>
         $(document).ready(function() {
         
           load_data();
         
           function load_data(query = null)
           {
         
               if(query != null)
               {
                   var query = encodeURIComponent(query); 
                   $("#target-content").load("index_ajax.php?page=1&query="+query);
               }
               else
               {
                 $("#target-content").load("index_ajax.php?page=1");
               }
               /*var query = query;*/
               
               // $("#target-content").load('index_ajax.php?page=1&query='+query);
               $(".page-link").click(function(){
                 var id = $(this).attr("data-id");
                 var select_id = $(this).parent().attr("id");
                 $.ajax({
                   url: "index_ajax.php",
                   type: "GET",
                   data: {
                     page : id,query:query
                   },
                   cache: false,
                   success: function(dataResult){
                     $("#target-content").html(dataResult);
                     $(".pageitem").removeClass("active");
                     $("#"+select_id).addClass("active");
                     
                   }
                 });
               });
           }
         
           $('#serach_btn').click(function(){
             
             var query = $('#search_box').val();
             load_data(query);
           });
         
         
           $('#serach_clear').click(function(){
             load_data();
           });
         
         });
         
      </script>
   </body>
</html>