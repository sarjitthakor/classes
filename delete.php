<?php

   include('database.php');

   if(isset($_GET['del_levels_id']) && $_GET['del_levels_id'] > 0)
   {
      $update_id = $_GET['update_id'];
      $del_levels_id = $_GET['del_levels_id'];
      $sql2 = "DELETE FROM levels WHERE id = $del_levels_id";
      $delete = mysqli_query($conn, $sql2);

      header("Location: edit_class.php?update_id=$update_id"); 
   }


   if(isset($_GET['del_id']) && $_GET['del_id'] > 0)
   {

      $del_id = $_GET['del_id']; 


      $up_sql = "SELECT classes.syllabus FROM classes where classes.id= $del_id";

      $qry = mysqli_query($conn,$up_sql); 

      $data = mysqli_fetch_array($qry);

      unlink("upload/" .$data['syllabus']);


      $sql2 = "DELETE FROM classes WHERE id = $del_id";
      $delete = mysqli_query($conn, $sql2);

      $sql3 = "DELETE FROM levels WHERE classes_id = $del_id";
      $delete = mysqli_query($conn, $sql3);

      header("Location: index.php"); 

   }

   
?>