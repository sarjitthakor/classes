<?php

   include('database.php');

   $sql2 = "SELECT * FROM college"; 

   $college_list = mysqli_query($conn, $sql2);  

 
    $error_college_id = "";
    $error_title = "";
    $error_contact_no = "";
    $error_email = "";
    $error_price = "";
    $error_description = "";
    $error_levels = "";
    $error_syllabus = "";
    $error = 0;

  if(isset($_POST['Submit'])){ 

    $college_id= $_POST["college_id"] ;
    $title= trim($_POST["title"]);
    $contact_no= trim($_POST["contact_no"]);
    $email= trim($_POST["email"]);
    $price= trim($_POST["price"]);
    $description = $_POST["description"];
    $levels= $_POST["levels"];

    if($college_id =="") {
      $error_college_id = "<span class='error'>Please select College Name.</span>";
      $error = 1;
    }

    if($title =="") {
      $error_title = "<span class='error'>Please enter Title.</span>";
      $error = 1;
    }

    if($contact_no =="") {
      $error_contact_no = "<span class='error'>Please enter Contact No.</span>";
      $error = 1;
    }

    if($email == "") {
    $error_email=  "<span class='error'>Please enter your email</span>";
    $error = 1; 
    } 
    elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)){
    $error_email= "<span class='error'>Please enter valide email.</span>";
    $error = 1;
    }

    if($price == "")
    {
      $error_price =  "<span class='error'>Please enter Price.</span>";
      $error = 1;
    }

    if($description == "")
    {
      $error_description =  "<span class='error'>Please enter Description.</span>";
      $error = 1;
    }

    if(!empty($levels) && count($levels)>0){
        foreach ($levels as $key => $_value) {
            if($_value == ''){
                $error_levels = "<span class='error'>Please Enter Levels</span>";
                $error = 1; 
            }
        }  
    }

    $allowed_image_extension = array(
        "pdf",
        "docx"
    );

    $syllabus_name =  time().'-'.$_FILES["syllabus"]["name"];
    $file_extension = pathinfo($_FILES["syllabus"]["name"], PATHINFO_EXTENSION);
    
    if (! file_exists($_FILES["syllabus"]["tmp_name"])) {
        
        $error_syllabus = "<span class='error'>Please Choose file to upload.</span>";
        $error = 1; 
    }    
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $error_syllabus = "<span class='error'>Upload valiid files. Only PDF and DOC are allowed.</span>";
        $error = 1;
    } 
    else if (($_FILES["syllabus"]["size"] > 8000000)) {
        $error_syllabus = "<span class='error'>File size exceeds 8MB.</span>";
        $error = 1;
    } 
    else 
    {
        $target = "upload/" . basename(time().'-'.$_FILES["syllabus"]["name"]);
        move_uploaded_file($_FILES["syllabus"]["tmp_name"], $target);
    }

    if($error == 0)
    {
       $_insert_sql = "INSERT INTO classes ( college_id,title,contact_no,email,price,description,syllabus)
        VALUES ('$college_id', '$title','$contact_no','$email','$price','$description','$syllabus_name')";


        if (mysqli_query($conn, $_insert_sql)) 
        {
            $last_id = mysqli_insert_id($conn);
            
            if(!empty($levels) && count($levels)>0){
                foreach ($levels as $key => $_value) {
                  
                    $_insert_multi_sql = "INSERT INTO levels (classes_id,value)
                      VALUES ('$last_id', '$_value')";
                    mysqli_query($conn, $_insert_multi_sql);
                }  
            }

            header("Location: index.php"); 
        }

    }
    
  }


?>

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
      <!-- Form Started -->
      <div class="container form-top">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
            <div class="panel panel-danger">
              <div class="panel-body">
                <form name= "add_class" id= "add_class" method= "post" action= "" enctype="multipart/form-data">
                  <div class="form-group">
                    <label> College Name</label>
                    <select class="form-control select2" name="college_id" id="college_id">
                      <option value=""> Select college</option>

                      <?php 
                      
                      while ($row = mysqli_fetch_array($college_list)) {
                      ?> 
                      <option value="<?=$row['id']?>" ><?= $row['college_name']?></option>

                      <?php }  ?>
                    </select>
                    <?php echo $error_college_id; ?>
                  </div>

                  <div class="form-group">
                    <label> Title </label>
                    <input type="text" name="title" class="form-control" placeholder="Enter Title">
                    <?php echo $error_title; ?>
                  </div>

                  <div class="form-group">
                    <label> Contact No </label>
                    <input type="number" name="contact_no" class="form-control" placeholder="Enter Contact No">
                    <?php echo $error_contact_no; ?>
                  </div>

                  <div class="form-group">
                    <label> Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email">
                    <?php echo $error_email; ?>
                  </div>

                  <div class="form-group">
                    <label> Price </label>
                    <input type="number" name="price" class="form-control" placeholder="Enter Price">
                    <?php echo $error_price; ?>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                        <label> Levels </label> 
                        <?php echo $error_levels; ?> 
                      </div>
                    </div>
                    <div class="row">
                      <div class="field_wrapper">
                        <div class="app_class">
                          <div class="col-md-9">
                            <input class="form-control" type="text" name="levels[]" value=""/>
                          </div>
                          <div class="col-md-3">
                            <a href="javascript:void(0);" class="add_button" ><h3><i class="fa fa-plus fa-3" aria-hidden="true"></i></h3></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label> Description</label>
                    <textarea rows="3" name="description" class="form-control" placeholder="Type Your Description"></textarea>
                    <?php echo $error_description; ?>
                  </div>

                  <div class="form-group">
                    <label>Syllabus (Only PDF and DOC are allowed)</label>
                    <input type="file" name="syllabus" class="form-control">
                    <?php echo $error_syllabus; ?>
                  </div>

                  <div class="form-group">
                    <button type="submit" name= "Submit" class="btn btn-info">Submit </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- Form Ended -->
    </div>
  </body>
</html>
<?php  include('js.php'); ?>
<script type="text/javascript">
$(document).ready(function(){
    
    var addButton = $('.add_button'); 
    var wrapper = $('.field_wrapper'); 
    var fieldHTML = '<div class="app_class"><div class="col-md-9"><input class="form-control" type="text" name="levels[]" value=""/></div><div class="col-md-3"><a href="javascript:void(0);" class="remove_button"><h3><i class="fa fa-minus fa-3" aria-hidden="true"></i></h3></a></div></div>';  
    var x = 1; 
    
    
    $(addButton).click(function(){
       $(wrapper).append(fieldHTML);   
    });
    
  
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        //$(this).parent('.app_class').remove();
        $(this). closest('.app_class'). remove()  
        x--; 
    });
});
</script>

<style type="text/css">
  .error 
  {
    color: red;
  }
</style>