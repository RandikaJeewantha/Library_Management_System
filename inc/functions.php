<?php

	function verify_query($result_set) {

		global $connection;

		if (!$result_set) {

			die("Database query failed!" . mysqli_error($connection));
		}
	}

	function check_req_fields($req_fields) {

		$errors = array();

		foreach ($req_fields as $field) {

			if (empty(trim($_POST[$field]))) {

				$errors[] = $field.' is required.';
			}
		}

		return $errors;
	}

	function check_max_len($max_len_fields) {

		$errors = array();

		foreach ($max_len_fields as $field => $max_len) {

			if (strlen(trim($_POST[$field])) > $max_len) {

				$errors[] = $field.' must be less than '.$max_len.' characters.';
			}
		}

		return $errors;
	}

	function topbar() {

		if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
			echo '<div id="date">' .date("l - d . m . Y"). '</div>';
			echo '<div class="loggedin">Welcome &nbsp;&nbsp;&nbsp; <a href="userPassword.php">'.$_SESSION["first_name"].'</a> &nbsp;!&nbsp;&nbsp;&nbsp; <<&nbsp;&nbsp;&nbsp; <a href="logOut.php">Log Out</a> &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="home.php">Home</a>&nbsp;&nbsp;&nbsp;>></div>';
		}

		else {
			echo '<div id="date">' .date("l - d . m . Y"). '</div>';
			echo '<div class="loggedin">Welcome &nbsp;&nbsp;&nbsp; <a href="modifyUser.php">'.$_SESSION["first_name"].'</a> &nbsp;!&nbsp;&nbsp;&nbsp; <<&nbsp;&nbsp;&nbsp; <a href="logOut.php">Log Out</a> &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="home.php">Home</a>&nbsp;&nbsp;&nbsp;>></div>';
		}
	}

	function row_count($query) {

		global $connection;
		$num_row = array();
		
		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			$num_row = mysqli_num_rows($result_set);
		}

		return $num_row;
	}

	function side_menu() {

		echo '<div id="menu">

			<label>SUSL Library</label><br><br>

			<div id="Book">
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/book.png" height="40px" width="40px"></div>
					<div id="button_text">
						Book<br>
					</div>
				</div>
			</a>
			</div><br>

			<div id="Category">
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/category.png" height="40px" width="40px"></div>
					<div id="button_text">
						Category<br>
					</div>
				</div>
			</a>
			</div><br>

			<div id="Author">
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/author.png" height="40px" width="40px"></div>
					<div id="button_text">
						Author<br>
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
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/teacher.png" height="40px" width="40px"></div>
					<div id="button_text">
						Teacher<br>
					</div>
				</div>
			</a>
			</div><br>

			<div id="Issue_History">
			<a id="link" href="#">
				<div id="button-div">
					<div id="img_div"><img src="../asserts/images/total-out.png" height="40px" width="40px"></div>
					<div id="button_text">
						Issue History<br><br>
					</div>
				</div>
			</a>
			</div>
		</div>';
	}

	function available_books(){
		global $connection;

		$queries = "SELECT book_id, quantity FROM books INNER JOIN borrow ON books.book_id = borrow.borrow_book_id ";
		$books = mysqli_query($connection, $queries);
		verify_query($books);

		while ($count = mysqli_fetch_assoc($books)) {
			$book_id = $count['book_id'];
			$book_borrow_count = mysqli_num_rows(mysqli_query($connection, 'SELECT * FROM borrow WHERE borrow_book_id = "$book_id" '));
			$quanty = $count['quantity'];

			if ($book_borrow_count < $quanty) {
				$query = 'UPDATE books SET is_available = "1" WHERE book_id = "$book_id" ';
				$up = mysqli_query($connection, $query);
				verify_query($up);
			}

			else {
				$query = 'UPDATE books SET is_available = "0" WHERE book_id = "$book_id" ';
				$up = mysqli_query($connection, $query);
				verify_query($up);
			}
		}
	}

?>
