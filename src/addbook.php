<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: preSign.php?err=cannot-access');
	}

	available_books();

	$errors = array();

	$book_name = '';
	$author = '';
	$exist_categories = '';
	$category = '';
	$quantity = '';
	$result = false;

	if (isset($_POST['add'])) {

		$book_name = $_POST['book_name'];
		$author = $_POST['author'];
		$exist_categories = $_POST['exist_categories'];
		$category = $_POST['category'];
		$quantity = $_POST['quantity'];

		if (empty(trim($exist_categories))) {
			$category = $_POST['category'];
		}

		else {
			$category = $_POST['exist_categories'];
		}
		
		$req_fields = array('book_name', 'author', 'quantity', 'category');
		$errors = array_merge($errors, check_req_fields($req_fields));

		$max_len_fields = array('book_name' => 300, 'author' => 100, 'quantity' => 5, 'category' => 100);
		$errors = array_merge($errors, check_max_len($max_len_fields));
		
		foreach ($errors as $key) {
			echo "<script type='text/javascript'>alert('$key');</script>";
		}


		$book_name = mysqli_real_escape_string($connection, $_POST['book_name']);
		$author = mysqli_real_escape_string($connection, $_POST['author']);
		$query = "SELECT * FROM books WHERE book_name = '{$book_name}' AND book_author = '{$author}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				echo "<script type='text/javascript'>alert('Book is already exists !!!');</script>";
			}
		}

		if (empty($errors)) {
			$category = mysqli_real_escape_string($connection, $_POST['category']); 
			$quantity = mysqli_real_escape_string($connection, $_POST['quantity']);

			$query = "INSERT INTO books (book_name, book_author, category, quantity) VALUES ( '{$book_name}', '{$author}', '{$category}', '{$quantity}')";

			$result = mysqli_query($connection, $query);

			if ($result) {
				header('Location: book.php?user_added=true');
			}

			if (!$result) {
				echo "<script type='text/javascript'>alert('Can't Add New Records !!!');</script>";
			}
		}
	}
?> 
