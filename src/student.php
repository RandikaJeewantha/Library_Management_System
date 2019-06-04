<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<!DOCTYPE html>
<html>
	
	<head>
		<title>Student</title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/all.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/student.css">
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header>

		<?php side_menu(); ?>
	</body>
</html>