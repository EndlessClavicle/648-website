<?php

// We need to use sessions, so you should always start sessions using the below code.

session_start();

// If the user is not logged in redirect to the login page...

if (!isset($_SESSION['loggedin'])) {

	header('Location: index.html');

	exit();

}

?>

<!DOCTYPE html>

<html>

	<head>

		<meta charset="utf-8">

		<title>Home Page</title>

		<link href="style.css" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

	</head>

	<body class="loggedin">

		<nav class="navtop">

			<div>

				<h1>Home</h1>

				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>

				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

				<a href="filemanager.php"><i class="fas fa-file-alt"></i>File Manager</a>

				<a href="messages.php"><i class="fas fa-comments"></i>Messages</a>

				<a href="tsuaojap.com:3000"><i class="fas fa-folder-plus"></i>Text Editor</a>

			</div>

		</nav>

		<div class="content">

			<p>Welcome back, <?=$_SESSION['name']?>!</p>

		</div>

	</body>

</html>


