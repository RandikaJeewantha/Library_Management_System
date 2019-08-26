<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: preSign.php?err=cannot-access');
	}

	available_books();

	$book_id = "";

	function books_issue($id) {
		global $connection;
		$book_list = '';
		$queries = "SELECT book_name, book_id FROM books INNER JOIN borrow ON books.book_id = borrow.borrow_book_id WHERE book_borrow_user = $id ";
		$books = mysqli_query($connection, $queries);
		verify_query($books);

		while ($book = mysqli_fetch_assoc($books)) {
				
			$book_list .= "<a href=\"book.php?book_name={$book['book_name']}\">";
			$book_list .= $book['book_name'];
			$book_list .= "</a>";
			$book_list .= "<br>";
		}

		return $book_list;
	}

	function delete($id) {
		global $connection;
		$delete_list = '';
		$queries = "SELECT borrow_book_id FROM books INNER JOIN borrow ON books.book_id = borrow.borrow_book_id WHERE book_borrow_user = $id ";
		$deletions = mysqli_query($connection, $queries);
		verify_query($deletions);

		while ($delete = mysqli_fetch_assoc($deletions)) {
				
			$delete_list .= "<a href=\"delete_issues.php?book_id={$delete['borrow_book_id']}&user_id={$id}\">";
			$delete_list .= "Delete";
			$delete_list .= "</a>";
			$delete_list .= "<br>";
		}

		return $delete_list;
	}

	function Issued_date($id) {
		global $connection;
		$issued_list = '';
		$queries = "SELECT issued_date FROM books INNER JOIN borrow ON books.book_id = borrow.borrow_book_id WHERE book_borrow_user = $id ";
		$query = mysqli_query($connection, $queries);
		verify_query($query);

		while ($que = mysqli_fetch_assoc($query)) {
				
			$issued_list .= $que['issued_date'];
			$issued_list .= "<br>";
		}

		return $issued_list;
	}

	function return_date($id) {
		global $connection;
		$return_list = '';
		$queries = "SELECT returned_date FROM books INNER JOIN borrow ON books.book_id = borrow.borrow_book_id WHERE book_borrow_user = $id ";
		$query = mysqli_query($connection, $queries);
		verify_query($query);

		while ($que = mysqli_fetch_assoc($query)) {
				
			$return_list .= $que['returned_date'];
			$return_list .= "<br>";
		}

		return $return_list;
	}
 
	$user_list = '';

	$query = "SELECT DISTINCT user_type, first_name, email, id FROM borrow INNER JOIN user ON borrow.book_borrow_user = user.id ";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_book = books_issue($user['id']);
		$books_issued = Issued_date($user['id']);
		$books_return = return_date($user['id']);
		$delete = delete($user['id']);

		$user_list .= "<tr>";
		$user_list .= "<td>{$user['user_type']}</td>";
		$user_list .= "<td>{$user['first_name']}</td>";
		$user_list .= "<td>{$user['email']}</td>";
		$user_list .= "<td>{$user_book}</td>";
		$user_list .= "<td>{$books_issued}</td>";
		$user_list .= "<td>{$books_return}</td>";
		$user_list .= "<td>{$delete}</td>";
		$user_list .= "</tr>";
	}

?>

<!DOCTYPE html>
<html>
	
	<head>
		<title>Issue History</title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/all.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/Issues.css">
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header>

		<div class="data">
			
			<h1>Issue History&nbsp;&nbsp;</h1>

			<table class="masterlist">
				<tr>
					<th>User Type</th>
					<th>First Name</th>
					<th>Email</th>
					<th>Issued Books</th>
					<th>Issued Date</th>
					<th>Return Date</th>
					<th>Delete</th>
				</tr>

				<?php echo $user_list; ?>

			</table>

		</div>
	</body>
</html>
