<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: preSign.php?err=cannot-access');
	}

	available_books();

	$book_name = '';
	$author = '';
	$category = '';
	$quantity = '';
	$search_results = "<br>";
	$available = "";
	$search_book_name = "";
	$id = "-1";

	if (isset($_GET['search_book_name'])) {
		$search_book_name = mysqli_real_escape_string($connection, $_GET['search_book_name']);

		$query = "SELECT book_id, book_author, category, quantity, is_available FROM books WHERE book_name ='$search_book_name' LIMIT 1";
		$result = mysqli_query($connection, $query);
		verify_query($result);

		while ($r = mysqli_fetch_assoc($result)) {
			$author = $r['book_author'];
			$category = $r['category'];
			$quantity = $r['quantity'];
			$available = $r['is_available'];
			$id = $r['book_id'];
		}

		if ($available == 1) {
			$available = "Available";
		}
		else{
			$available = "Not Available";
		}

		$_SESSION['b_id'] = $id;

		$book_name = $search_book_name;
	}

	if (isset($_GET['query'])) {

		$query = $_GET['query']; 
		$min_length = 3;

		if(strlen(trim($query)) >= $min_length){
         
        	$query = htmlspecialchars($query); 
         
        	$query = mysqli_real_escape_string($connection, $query);
         
        	$raw_results = mysqli_query($connection, "SELECT * FROM books WHERE `book_name` LIKE '%".$query."%'");
         
        	if(mysqli_num_rows($raw_results) > 0){
             
            	while($results = mysqli_fetch_assoc($raw_results)){
                	$search_results .=  "<p><h3><a href=\"book.php?search_book_name={$results['book_name']}\">{$results['book_name']}</a></h3></p>";
            	}
             
        	}

        	else{
           		$search_results .= "No results";
        	}
         
    	}

    	else{ 
       		$search_results .= "Search Word's Minimum Length Is ".$min_length;
    	}
    }
?>	

<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/book.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header>

		<div class="master">
			
			<div class="add_book">

				<br><h1>Adding Books</h1>

				<p>
					<?php 

						if (!empty($errors)) {
							foreach ($errors as $error) {
								$error = ucfirst(str_replace("_", " ", $error));
								echo "<< &nbsp;&nbsp;".$error."&nbsp;&nbsp; >><br>";
							}
						}
					?>
				</p><br>

				<form action="addbook.php" method="POST">
				
					<input type="name" name="book_name" placeholder="Book Name" ><br><br><br>
					<input type="name" name="author" placeholder="Author Name" ><br><br><br>
					<select name="exist_categories">
						<option value="">Existance Categories</option>
						<option value="Librarian">Librarian</option>
						<option value="Teacher">Teacher</option>
						<option value="Student">Student</option>
						<option value="Book Keeper">Book Keeper</option>
					</select><br><br><br>
					<input type="text" name="category" placeholder="Or Add New Category Eg: Novel" ><br><br><br>
					<input type="text" name="quantity" placeholder="Quantity" ><br><br><br>

					<button type="submit" name="add">Add</button><br><br>

				</form>

			</div>

			<div class="search">
				<form action="book.php" method="GET">
        			<input type="text" name="query" id="text" placeholder="Search Name Of Book For Find It Available Or Not" /> 
        			<input type="submit" value="Search" id="button" /><br>

        			<?php echo $search_results; ?>
   				</form>

   			</div>

   			<div class="modify">

   				<form action="modify.php" method="POST">

   					<label>Book Name :</label><input type="name" name="book_name" <?php echo 'value="'.$book_name.'"'; ?> ><br><br>
					<label>Author Name :</label><input type="name" name="author" <?php echo 'value="'.$author.'"'; ?> ><br><br>
					<label>Category :</label><input type="text" name="category" <?php echo 'value="'.$category.'"'; ?> ><br><br>
					<label>Quantity :</label><input type="text" name="quantity" <?php echo 'value="'.$quantity.'"'; ?> ><br><br>
					<label>Available Or Not :</label><input type="text" name="available" <?php echo 'value="'.$available.'"'; ?> ><br><br>

					<button type="submit" name="modify">Modify</button><br><br>
   				</form>

			</div>

			<div class="issue">

				<br><h1>Issue Books</h1>

   				<form action="issue_book.php?email={$email}" method="POST">

   					<label>Book Id :</label><input type="name" name="book_id" <?php echo 'value="'.$id.'"'; ?> ><br><br>
   					<label>Book Name :</label><input type="name" name="book_name" <?php echo 'value="'.$book_name.'"'; ?> ><br><br>
   					<label>Student Email :</label><select name="email">
						<?php 

							$query = "SELECT email FROM user ORDER BY email ASC";
							$users = mysqli_query($connection, $query);
							verify_query($users);

							while ($user = mysqli_fetch_assoc($users)) {

								$email = $user['email'];
								echo "<option value=\"{$email}\" name=\"{$email}\">{$user['email']}</option>";
							}
						?>
					</select><br><br><br>

					<button type="submit" name="issue">Issue</button><br><br>
   				</form>

			</div>

		</div>

	</body>

</html>