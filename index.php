<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>

<?php 
	if(isset($_POST['submit'])) {

		$errors = array();

		if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1)  {
			$errors[] = "UserName is Missing / Invalid";
		}

		if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1)  {
			$errors[] = "Password is Missing / Invalid";
		}

		if (empty($errors)) {
			$email = mysqli_real_escape_string($connection, $_POST['email']);
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password);

			$query = "SELECT * FROM user WHERE email = '{$email}' AND password = '{$hashed_password}' AND is_deleted = 0 LIMIT 1";
			$result_set = mysqli_query($connection, $query);

			verify_query($result_set);

			if (mysqli_num_rows($result_set) == 1) {
				$user = mysqli_fetch_assoc($result_set);
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['first_name'] = $user['first_name'];
				$_SESSION['user_type'] = $user['user_type'];

				$query = "UPDATE user SET last_login = NOW()";
				$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

				$result_set = mysqli_query($connection, $query);
				verify_query($result_set);

				header('Location: src/home.php');
			}

			else {
				$errors[] = 'Invalid UserName / Password!';
			}
		}
	}	
?>


<!DOCTYPE html>
<html lang="en">
	
	<head>
		<meta charset="utf-8">
		<title>Log In</title>
		<link rel="stylesheet" type="text/css" href="asserts/css/index.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	</head>
	
	<body>
		<div class="middle">
			<form action="index.php" method="POST">
				<h1>W e l c o m e . . . </h1>

				<?php 
					if (isset($errors) && !empty($errors)) {
						echo '<p class="error"><i> <<   Invalid Username / Password !   >></i></p>';
						}
				?>

				<?php 
					if (isset($_GET['logout'])) {
						echo '<p class="logOut"><i><<    Logged Out </i>    >></p>';
					}
				?>
				
				<h4>Sign into get start... </h4>

				<h3> User Name <input id ="userName" type="email" name="email" placeholder="Email"> </h3>
				<h3> User Password <input id ="password" type="password" name="password" placeholder="Password"> </h3>
				<button id ="signBtn" type="submit" name="submit">Sign in</button>
			</form>
			
		</div>

		<button id="guest"><a href="src/guestHome.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guest User&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></button>

		<button type="button" id="logOut"><a href="src/logOut.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Log Out&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></button>

		<button type="button" id="users"><a href="src/users.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Users&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></button>

	</body>

</html>

<?php mysqli_close($connection); ?>
