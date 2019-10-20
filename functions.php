<?php 
session_start();

// connect to database

$db = mysqli_connect('localhost', 'root', '', 'departamente');

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);
	 $department=e($_POST['department']);
	 $photo = null;
	 if(!empty($_FILES['photo'])){
     $photo=$_FILES['photo']['name'];
     $photo_tmp=$_FILES['photo']['tmp_name'];
	 move_uploaded_file($photo_tmp,"images/$photo");
	 
	 }
	 // form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
    }
    if(empty($department)){
		array_push($errors,"department is required");
		
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

        if (isset($_POST['user_role'])) {//control if the user is employer or admin in the registration form 
			//we don't have a user type field so automatically the user is just employer
			
			$user_role = e($_POST['user_role']);
			$query = "INSERT INTO users (username, email, user_role,department, password,photo) 
					  VALUES('$username', '$email', '$user_role','$department', '$password','$photo')";
		
			if (mysqli_query($db, $query)) {
				$_SESSION['success']  = "New user successfully created!!";
			header('location: index.php');
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($db);
			}
			
		}else{
			$query = "INSERT INTO users (username, email, user_role,department, password,photo) 
					  VALUES('$username', '$email', 'user', '$department' ,'$password','$photo')";
			
			if (mysqli_query($db, $query)) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $query . "<br>" . mysqli_error($db);
			}

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);
			die(var_dump($logged_in_user_id));

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: profile.php');				
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}
// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}
// call the login() function if login_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_role'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/index.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}
function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_role'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}
if(isset($_POST['edit_btn'])){
	global $db;
if(isLoggedIn()&&!isAdmin()){
$logged_in_user_id=$_SESSION['user']['id'];

	
	edit($logged_in_user_id);}
	elseif(isAdmin){
		$loged_in_admin_id=$_SESSION['user']['id'];
		editAdmin($loged_in_admin_id);
	}
	
}

function edit($id){
$mod_user=getUserById($id);
	header('location: edit.php');
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

	}}

	function editAdmin($id){
		$mod_user=getUserById($id);
			header('location: admin/edit.php');
			if(isset($_POST['save'])){
				$username=$_POST['username'];
				$email=$_POST['email'];
				$user_type=$_POST['user_role'];
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
			$query .="user_role='{$user_type}'";
			$query.="WHERE id='{$mod_user['id']}'";
		
			}}
		
		


