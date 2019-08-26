<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: preSign.php?err=cannot-access');
	}

	$errors ='';

	$book_name = '';
	$author = '';
	$category = '';
	$quantity = '';
	$available = "";
	$result = false;
	$id = '';
	$id = $_SESSION['b_id']; 

	if (isset($_POST['modify'])) {

		$book_name = $_POST['book_name'];
		$author = $_POST['author'];
		$category = $_POST['category'];
		$quantity = $_POST['quantity'];
		$available = $_POST['available'];
		
		$req_fields = array('book_name', 'author', 'category', 'quantity', 'available');
		$errors = check_req_fields($req_fields);

		$max_len_fields = array('book_name' => 300, 'author' => 100, 'category' => 100, 'quantity' => 5, 'available' => 1);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		if (empty($errors)) {
			$book_name = mysqli_real_escape_string($connection, $_POST['book_name']);
			$author = mysqli_real_escape_string($connection, $_POST['author']);
			$category = mysqli_real_escape_string($connection, $_POST['category']);
			$available = mysqli_real_escape_string($connection, $_POST['available']);
			$quantity = mysqli_real_escape_string($connection, $_POST['quantity']);

			$query = "UPDATE books SET book_name = '{$book_name}', book_author = '{$author}', category = '{$category}', quantity = '{$quantity}', is_available = '{$available}' WHERE book_id = $id LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				echo "<script type='text/javascript'>alert('Successfully Modified');</script>";
				header('Location: book.php?modified=true');
			}

			if (!$result) {
				echo "<script type='text/javascript'>alert('Failed to Modify the new records.');</script>";
			}
		}

		else {
			echo "<script type='text/javascript'>alert('$errors');</script>";
		}
	}
?>
