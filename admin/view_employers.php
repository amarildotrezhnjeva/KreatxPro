<?php 
include('../functions.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <title>Home</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
	.header {
		background: #003366;
	}
	button[name=register_btn] {
		background: #003366;
	}
	</style>
      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/blog-home.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="input-group">
            <a href="?logout=true" type="submit" class="btn" name="logout">Logout</a>

               </div>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="create_user.php">Create_User</a>
                </li>
                <li>
                    <a href="view_employers.php">View Employers</a>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<div class="container">
  <h2>hello</h2>
  <h6>All employees<h6>            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Email</th>
        <th>User_Role</th>
        <th>Image</th>
        <th>Department</th>

      </tr>
    </thead>
   <tbody>
   <?php
   $query="SELECT * FROM users";
   $users_selected=mysqli_query($db,$query);
   while($row=mysqli_fetch_assoc($users_selected)){
       $username=$row['username'];
       $user_id=$row['id'];
       $email=$row['email'];
       $user_role=$row['user_role'];
       $image=$row['photo'];
       $department=$row['department'];
   echo "<tr>";
   echo "<td> $user_id </td>";
   echo "<td> $username </td>";
   echo "<td> $email </td>";
   echo "<td> $user_role </td>";
   echo "<td>  $image</td>";
   echo "<td> $department </td>";?>

 <td> <a href="edit.php?id=<?=$user_id;?>"> Edit </a></td>

 <?php  echo "</tr>";
   }?>

  </tbody>
</table>
</div>
