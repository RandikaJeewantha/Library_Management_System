<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: preSign.php?err=cannot-access');
	}

	available_books();

	$errors = '';

	$book_name = '';
	$book_id = '';
	$available = '';
	$b_name = '';
	$email = '';
	$user_id = '';

	if (isset($_POST['issue'])) {

		$book_name = $_POST['book_name'];
		$book_id = $_POST['book_id'];
		$email = $_POST['email'];

		$req_fields = array('book_name', 'book_id', 'email');

		if ($err = check_req_fields($req_fields)) {
			$errors .= '<br>Some Fields Are Empty';
		}

		$max_len_fields = array('book_name' => 300, 'book_id' => 5, 'email' => 100);
		
		if ($err = check_max_len($max_len_fields)) {
			$errors .= '<br>Some Fields Are Exceed Maximum Range Words';
		}

		$query = "SELECT * FROM books WHERE book_id = '$book_id'";
		$books = mysqli_query($connection, $query);
		verify_query($books);

		while ($book = mysqli_fetch_assoc($books)) {

			$available = $book['is_available'];
			$b_name = $book['book_name'];
			$b_id = $book['book_id'];
		}

		if ($available == 0) {
				$errors .= "<br>That Book Not Available !";

		}

		if (!($book_name == $b_name AND $book_id == $b_id)) {

			$errors .= "<br>NOt Book Id Related TO Book Name That You Entered !";

		}

		$email = mysqli_real_escape_string($connection, $_POST['email']);

		$queries = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
		$users = mysqli_query($connection, $queries);
		verify_query($users);

		while ($user = mysqli_fetch_assoc($users)) {
			$user_id = $user['id'];
		}
		
		if (!empty($errors)) {
			echo "<script type='text/javascript'>alert('$errors');</script>";
		}

		if (empty($errors)) {

			while ($user = mysqli_fetch_assoc($users)) {
				$user_id = $user['id'];
			}

			$query = "UPDATE borrow SET issued_date = NOW()";
			$result = mysqli_query($connection, $query);
			verify_query($result);

			$query = 'UPDATE borrow SET returned_date = DATE_ADD(NOW(), INTERVAL 10 DAY) ';
			$result = mysqli_query($connection, $query);
			verify_query($result);

			$query = "INSERT INTO borrow (book_borrow_user, borrow_book_id) VALUES ( '$user_id', '$b_id')";
			$result = mysqli_query($connection, $query);
			verify_query($result);

			if ($result) {
				echo "<script type='text/javascript'>alert('Successfully Added !');</script>";
				header('Location: Issues.php?issed_added=true');
			}

			if (!$result) {
				echo "<script type='text/javascript'>alert('Can't Add New Records !!!');</script>";
			}
		}
	}
?> 
