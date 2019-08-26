<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<!DOCTYPE html>
<html>
	
	<head>
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/home.css">
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

		<div id="Dashboard2">

			<div id="total_issue_today">
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/issue-today.png" height="40px" width="40px"></div>
					<div id="button_text">
						<?php 
							if (mysqli_query($connection, 'SELECT * FROM books INNER JOIN borrow ON books.book_id = borrow.borrow_book_id WHERE issued_date = date("Y-m-d")')) {
								echo mysqli_num_rows(mysqli_query($connection, 'SELECT * FROM books INNER JOIN borrow ON books.book_id = borrow.borrow_book_id WHERE issued_date = date("Y-m-d")'));
							}
						?><br>
						Total Issues Today
					</div>
				</div>
			</a>
			</div><br><br><br>

			<div id="total_out">
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/total-out.png" height="40px" width="40px"></div>
					<div id="button_text">
						<?php 
							if (mysqli_query($connection, 'SELECT * FROM borrow')) {
								echo mysqli_num_rows(mysqli_query($connection, 'SELECT * FROM borrow'));
							}
						?><br>
						Total Books Out
					</div>
				</div>
			</a>
			</div>
		</div>

		<div id="Dashboard1">

			<label>Dashboard</label><br><br>

			<div id="total_books">
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/book.png" height="40px" width="40px"></div>
					<div id="button_text">
						<?php 
							if (mysqli_query($connection, "SELECT * FROM books")) {
								echo mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books"));
							}
						?><br>
						Total Books
					</div>
				</div>
			</a>
			</div><br>

			<div id="total_students">
			<a id="link" href="student.php">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/student.png" height="40px" width="40px"></div>
					<div id="button_text">
						<?php 
							if (mysqli_query($connection, 'SELECT * FROM user WHERE user_type = "Student"')) {
								echo mysqli_num_rows(mysqli_query($connection, 'SELECT * FROM user WHERE user_type = "Student"'));
							}
						?><br>
						Total Students
					</div>
				</div>
			</a>
			</div><br>

			<div id="total_teachers">
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/teacher.png" height="40px" width="40px"></div>
					<div id="button_text">
						<?php 
							if (mysqli_query($connection, 'SELECT * FROM user WHERE user_type = "Teacher"')) {
								echo mysqli_num_rows(mysqli_query($connection, 'SELECT * FROM user WHERE user_type = "Teacher"'));
							}
						?><br>
						Total Teachers
					</div>
				</div>
			</a>
			</div><br>
		</div>

	</body>
	
</html>
