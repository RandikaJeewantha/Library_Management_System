<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: preSign.php?err=cannot-access');
	}

	available_books();

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
 
 
	$user_list = '';

	$query = "SELECT * FROM user WHERE is_deleted=0 AND user_type = 'Teacher' ORDER BY user_type";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_book = books_issue($user['id']);
		$user_list .= "<tr>";
		$user_list .= "<td>{$user['first_name']}</td>";
		$user_list .= "<td>{$user['last_name']}</td>";
		$user_list .= "<td>{$user['last_login']}</td>";
		$user_list .= "<td>{$user_book}</td>";
		$user_list .= "<td><a href=\"modifyUser.php?user_id={$user['id']}\">Edit</a></td>";
		$user_list .= "<td><a href=\"deleteUser.php?user_id={$user['id']}\">Delete</a></td>";
		$user_list .= "</tr>";
	}

?>

<!DOCTYPE html>
<html>
	
	<head>
		<title>Teachers</title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/all.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/student.css">
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header>

		<div class="data">
			
			<h1>Teachers&nbsp;&nbsp; <span><a href="addUser.php">+ Add New Teacher</a></span></h1>

			<table class="masterlist">
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Last Login</th>
					<th>Issued Books</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>

				<?php echo $user_list; ?>

			</table>

		</div>
	</body>
</html>
