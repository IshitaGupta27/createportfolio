<!DOCTYPE html>
<html>
<head>
	<title>Portfolio</title>
	<style>
		body{
			margin-top: 100px;
		}
	</style>
</head>
<body>
<?php

  if(isset($_POST['SUBMIT']))
  {
    $name=$_POST['name'];
    $age=$_POST['age'];
    $stat=$_POST['status'];
    $edqual=$_POST['current'];
    $hobbies=$_POST['hobbies'];
    $about=$_POST['about'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $stamp= date("Y-m-d H:i:s:ms");

    $host='localhost';
    $user='root';
    $pass='';
    $dbname='portfolio';
    $conn=new mysqli($host,$user,$pass,$dbname);
    
    if(isset($_FILES['image']))
    {
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $ext=pathinfo($file_name,PATHINFO_EXTENSION);
      $filename=basename($file_name,$ext);
      $upload=false;
      if(empty($errors)==true)
      {
         move_uploaded_file($file_tmp,"img/".$file_name);
         $upload=true;
      }
      else
      {
         print_r($errors);
      }
    }
    if($upload==true)
    {
      $newFileName=$filename.$ext;
    }

    $sql="INSERT INTO new_registration(created_at,Name,filepath,filename,Age,Status,Qualifications,Hobbies,About,Email_id,Contact) 
    VALUES('$stamp','$name','img','".$newFileName."','$age','$stat','$edqual','$hobbies','$about','$email','$phone')";
    $result=$conn->query($sql);
    if (!$result)
    {
      echo $conn->error ;
    }
    else
    {
      //echo 'data inserted';
    }
    $query1 = "SELECT * from new_registration WHERE created_at = ( Select max(created_at) from new_registration )";
    $results = mysqli_query($conn, $query1);
    if(mysqli_num_rows($results) > 0)
    {
      while($row = mysqli_fetch_assoc($results))
      {
        $url = $row["filepath"]."/".$row["filename"];
        $Name = $row["Name"];
        $Age = $row["Age"];
        $Hobbies = $row["Hobbies"];
        $Qualifications = $row["Qualifications"];
        $About = $row["About"];
        $Status = $row["Status"];
        $Email_id = $row["Email_id"];
        $Contact = $row["Contact"];
      }
    }
  }
?>

<style>
.aside1{
  width: 50%;
  min-height: 100%;
  padding-left: 15px;
  margin-left: 120px;
  margin-right: 40px;
  float: left;
  background-color: lightgray;
  text-align: left;
  font-size: 20px;
}
</style>
<div class="aside1">
  <br><br>
  <b><h1 style="font-style: italic;"><?php echo $Name; ?></h1></b>
  <?php echo $Status; ?><br><br>
  <p>
    <?php echo $About; ?>
  </p>
</div>
<style>
.vl {
  border-left: 6px solid green;
  height: 550px;
  position: absolute;
  left: 64%;
  margin-left: -3px;
  top: 20%;
}
</style>
<div class="vl">
</div>
<style>
.aside {
  width: 25%;
  padding-left: 15px;
  margin-left: 15px;
  margin-right: 70px;
  float: right;
  font-style: italic;
  background-color: lightgray;
  text-align: center;
}
</style>
<div class="aside">
  <br>
  <h2> About </h2>
  <img src="<?php echo $url; ?>" height="300px">
  <br> <br>
  <p align="left">
    <b> Age: </b><?php echo $Age; ?><br><br>
    <b> Educational Qualifications: </b><?php echo $Qualifications; ?><br><br>
    <b> Hobbies: </b><?php echo $Hobbies; ?><br><br>
    <b> E-mail id: </b><?php echo $Email_id; ?><br><br>
    <b> Contact no: </b><?php echo $Contact; ?><br><br>
  </p>
</div>
</body>
</html>