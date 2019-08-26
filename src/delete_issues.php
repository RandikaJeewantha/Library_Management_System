<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: preSign.php?err=cannot-access');
	}

	available_books();

	if (isset($_GET['user_id']) && isset($_GET['book_id']) ) {
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		$book_id = mysqli_real_escape_string($connection, $_GET['book_id']);
		
		$query = "DELETE FROM borrow WHERE borrow_book_id = $book_id AND book_borrow_user = $user_id ";

		$result = mysqli_query($connection, $query);

		verify_query($result);

		if ($result) {
			echo "<script type='text/javascript'>alert('Successfully Deleted !');</script>";
			header('Location: Issues.php?msg=issue-deleted');
		}

		else {
			echo "<script type='text/javascript'>alert('UnSuccessfull !');</script>";
			header('Location: Issues.php?msg=issue-failed');
		}
	}

	else {
		header('Location: Issues.php');
	}

?>