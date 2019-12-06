<html>

	<head>

		<title> File Manager </title>

		<link href="style.css" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">



	</head>

	<body class="loggedin">

		<nav class="navtop">

			<div>

				<h1>File Manager</h1>

				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>

				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

				<a href="filemanager.php"><i class="fas fa-file-alt"></i>File Manager</a>

				<a href="messages.php"><i class="fas fa-comments"></i>Messages</a>

			</div>

		</nav>



<form method="POST" action="upload.php" enctype="multipart/form-data">

    <input type="file" name="file">

    <input type="submit" value="Upload">

</form>

<?php



// This will return all files in that folder

$files = scandir("uploads");



// If you are using windows, first 2 indexes are "." and "..",

// if you are using Mac, you may need to start the loop from 3,

// because the 3rd index in Mac is ".DS_Store" (auto-generated file by Mac)

for ($a = 2; $a < count($files); $a++)

{

    ?>

    <p>

    	<!-- Displaying file name !-->

        <?php echo $files[$a]; ?>



        <!-- href should be complete file path !-->

        <!-- download attribute should be the name after it downloads !-->

        <a href="uploads/<?php echo $files[$a]; ?>" download="<?php echo $files[$a]; ?>">

            Download

        </a>

	<a href="delete.php?name=uploads/<?php echo $files[$a]; ?>" style="color: red;">

	    Delete

	</a>

    </p>

    <?php

}

?>

	</body>

</html>




