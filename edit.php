<?php include('functions.php');
$mod_user=getUserById($_SESSION['user']['id']);
	
if(isset($_POST['save'])){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password_1=$_POST['password_1'];
    $password_2=$_POST['password_2'];
    $department=$_POST['department'];
    $photo=$_FILES['photo']['name'];
 $photo_tmp=$_FILES['photo']['tmp_name'];
 move_uploaded_file($photo_tmp,"images/$photo");
$query= "UPDATE users SET";
$query .="username ='{$username}' ,";
$query .="email ='{$email}' ,";
$query .="password_1 ='{$password_1}' ,";
$query .="password_2 ='{$password_2}' ,";
$query .="department ='{$department}' ,";
$query .="photo ='{$photo}' ,";
$query.="WHERE id='{$mod_user['id']}'";

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

    <title>EDIT
</title>
<link rel="stylesheet" href="style.css">
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
		           <button type="submit" class="btn" name="logout">Logout</button>
	               </div>
                 </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                   <li><a href="index.php">
                   Home</a>
                   </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <form method="post" action="index.php" enctype="multipart/form-data">
    <?php echo display_error(); ?>
	<div class="input-group">
<label>
    Username 
</label>
		<input type="text" name="username" value="<?php echo $mod_user['username'];?>">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="email" name="email" value="<?php echo $mod_user['email'];?>">
	</div>
    <div class="input-group">
		<label>Image</label>
		<input type="file" name="photo" >
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1">
	</div>
	<div class="input-group">
		<label>Confirm password</label>
		<input type="password" name="password_2">
	</div>
    <div class="input-group">
    <label>Department</label>
    <input type="text" name="department" value="<?php echo $mod_user['department'];?>">
    </div>
	<div class="input-group">
		<button type="submit" class="btn" name="save">Save</button>
	</div>
	
</form>
