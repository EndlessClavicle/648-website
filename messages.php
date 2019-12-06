<?php

session_start();

//include('authenticate.php');

//$link = dbConnect();

$con = mysqli_connect('localhost','endlessclavicle','babycham12','phplogin');

if(mysqli_connect_errno()){

	die('connection failed.' . mysqli_connect_errno());

}

?>

<html>

	<head>

		<title> Personal Messages </title>

		<link href="style.css" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">



	</head>

	<body class="loggedin">

		<nav class="navtop">

			<div>

				<h1>Personal Messages</h1>

				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>

				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

				<a href="filemanager.php"><i class="fas fa-file-alt"></i>File Manager</a>

				<a href="messages.php"><i class="fas fa-comments"></i>Messages</a>

			</div>

		</nav>



		<div class="content">

<?php

if(isset($_SESSION['name']))

{

$read = "SELECT m.id, m.subject, m.timesent, u.userId, u.username as username FROM messages m, users u where ((m.to_id = ".$_SESSION['id']." and u.userId = m.from_id and m.opened = '0'))";

$req1 = mysqli_query($con, $read) or die("bad query: $read");

$unread = "SELECT m.id, m.subject, m.timesent, u.userId, u.username as username from messages m, users u where((m.to_id = ".$_SESSION['id']."  and m.opened = '1' and u.userId = m.from_id))";

$req2 = mysqli_query($con, $unread) or die("bad query: $unread");

$sent = "SELECT m.id, m.subject, m.timesent, u.userId, u.username as username FROM messages m, users u where ((m.from_id = ".$_SESSION['id']." and u.userId = m.to_id and m.senderdelete = '0'))";

$req3 = mysqli_query($con, $sent) or die("bad query: $sent");

?>

This is the list of your messages:<br />

<a href='new_pm.php'>New PM</a><br />

<h3> Unread Messages(<?php echo mysqli_num_rows($req1);?>):</h3>

<table cellspacing="15">

	<tr>

	<th>Subject</th>

	<th>From</th>

	<th>Time</th>

</tr>

<?php

while($dn1 = mysqli_fetch_array($req1))

{

?>

	<tr>

	<td class="left"><a href="read_pm.php?id=<?php echo $dn1['id']; ?>"><?php echo $dn1['subject']; ?></a></td>

	<td><?php echo $dn1['username'];?></td>

	<td><?php echo $dn1['timesent'];?></td>

	</tr>

<?php

}

if(mysqli_num_rows($req1) == 0)

{

?>

	<tr>

	<td colspan="4" class = "center">You have no unread messages.</td>

	</tr>

<?php

}

?>

</table>

<br />

<h3>Read Messages(<?php echo mysqli_num_rows($req2);?>):</h3>

<table cellspacing="15">

	<tr>

	<th>Subject</th>

        <th>From</th>

        <th>Time</th>

</tr>

<?php

while($dn2 = mysqli_fetch_array($req2))

{

?>

	<tr>

	<td class="left"><a href="read_pm.php?id=<?php echo $dn2['id']; ?>"><?php echo $dn2['subject']; ?></a></td>

	<td><?php echo $dn2['username'];?></td>

	<td><?php echo $dn2['timesent'];?></td>

	</tr>

<?php

}

if(mysqli_num_rows($req2) == 0)

{

?>

	<tr>

	<td colspan= "4" class ="center">You have no read messages.</td>

	</tr>

<?php

}

?>

</table>

<br />

<h3>Sent Messages(<?php echo mysqli_num_rows($req3);?>):</h3>

<table cellspacing="15">

	<tr>

	<th>Subject</th>

        <th>To</th>

        <th>Time</th>

</tr>

<?php

while($dn3 = mysqli_fetch_array($req3))

{

?>

	<tr>

	<td class="left"><a href="read_pm.php?id=<?php echo $dn3['id']; ?>"><?php echo $dn3['subject']; ?></a></td>

	<td><?php echo $dn3['username'];?></td>

	<td><?php echo $dn3['timesent'];?></td>

	</tr>

<?php

}

if(mysqli_num_rows($req3) == 0)

{

?>

	<tr>

	<td colspan= "4" class ="center">You have no sent messages.</td>

	</tr>

<?php

}

?>

</table>

<?php

}

else

{

	echo 'You must be logged in to access this page.';

}

?>

		</div>

	</body>

</html>


