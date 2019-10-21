
<?php include('../functions.php') ;
if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}
if(isset($_GET['id'])){
global $db;
    $id_edit=$_GET['id'];

$sql="SELECT * FROM users WHERE id={$id_edit}";
$results=mysqli_query($db,$sql);
while($row=mysqli_fetch_assoc($results)){
    $user_id=$row['id'];
    $username=$row['username'];
    $email=$row['email'];
    $user_role=$row['user_role'];
    $image=$row['photo'];
    $department=$row['department'];
    $password_1=$row['password'];
}}
if(isset($_POST['save'])){
    global $db;
    $username=$_POST['username'];
    $username=$_POST['email'];
    $user_role=$_POST['user_role'];
    $department=$_POST['department'];
    $password_1=$_POST['password_1'];
    $image=$_POST['image'];

$query= "UPDATE users SET";
    $query .="username ='{$username}' ,";
    $query .="user_role ='{$user_role}' ,";

	$query .="email ={'$email}' ,";
	$query .="password ='{$password_1}' , ";
	$query .="department ='{$department}' , ";
	$query .="photo ='{$image}', ";
    $query.="WHERE id={$user_id} ";
      $update=mysqli_query($db,$query);
      die(var_dump($update));
}?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		.header {
			background: #003366;
		}
		button[name=register_btn] {
			background: #003366;
		}
	</style>
    <title>Company</title>

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
                        <a href="view_employers.php">View Employers</a>
                      
                    </li>
                    <li>
                    <a class="navbar-brand" href="create_users.php">Create Users</a>

                      
                    </li>


                </ul>
            </div> 
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="header">
		<h2>Admin - edit</h2>
	</div>
	
	<form method="post" action="view_employers.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo $username;?>">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" value="<?php echo $email;?>">
		</div>
		<div class="input-group">
			<label>User type</label>
			<select name="user_role" id="user_role" >
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
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
			<label>Photo</label>
			<input type="file" name="image" value="<?php echo $image;?>" >
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="save"> Save</button>
		</div>
	</form>
</body>
</html>


   