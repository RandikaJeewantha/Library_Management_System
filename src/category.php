<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: preSign.php?err=cannot-access');
	}

	function display(){

		GLOBAL $connection;
		$query = "SELECT DISTINCT category FROM books ORDER BY category ASC";
		$categories = mysqli_query($connection, $query);

		verify_query($categories);
	
		while ($category = mysqli_fetch_assoc($categories)) {

			$book_list = '<br>';
			$C = $category['category'];

			$query = "SELECT book_name, book_author FROM books WHERE category = '$C' ";
			$books = mysqli_query($connection, $query);

			verify_query($books);

			$book_list .= "<table class='masterlist'><tr><th colspan='2'>{$C}</th></tr>";
			$book_list .= "<tr><th>Book Name</th><th>Book Author</th></tr>";

			while ($book = mysqli_fetch_assoc($books)) {
				$book_list .= "<tr><td>{$book['book_name']}</td><td>{$book['book_author']}</td></tr>";
			}

			$book_list .= "</table><br>";

			echo $book_list;
		}
	}
?>

<!DOCTYPE html>
<html>
	
	<head>
		<title>Category</title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/category.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header>

		<div id="menu">

			<label>SUSL Library</label><br><br>

			<div id="Book">
			<a id="link" href="book.php">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/book.png" height="40px" width="40px"></div>
					<div id="button_text">
						Book<br>
					</div>
				</div>
			</a>
			</div><br>

			<div id="Category">
			<a id="link" href="category.php">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/category.png" height="40px" width="40px"></div>
					<div id="button_text">
						Category<br>
					</div>
				</div>
			</a>
			</div><br>

			<div id="Student">
			<a id="link" href="student.php">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/student.png" height="40px" width="40px"></div>
					<div id="button_text">
						Student<br>
					</div>
				</div>
			</a>
			</div><br>

			<div id="Teacher">
			<a id="link" href="teacher.php">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/teacher.png" height="40px" width="40px"></div>
					<div id="button_text">
						Teacher<br>
					</div>
				</div>
			</a>
			</div><br>

			<div id="Issue_History">
			<a id="link" href="Issues.php">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/total-out.png" height="40px" width="40px"></div>
					<div id="button_text">
						Issue History<br><br>
					</div>
				</div>
			</a>
			</div>
		</div>

		<div class="right">

			<label> Categories </label><br>

			<?php display(); ?>
			
		</div>

	</body>
</html>
