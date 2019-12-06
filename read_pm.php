<?php

session_start();

//include('config.php');

$con = mysqli_connect('localhost','endlessclavicle','babycham12','phplogin');

if ( mysqli_connect_errno() ) {

	// If there is an error with the connection, stop the script and display the error.

	die ('Failed to connect to MySQL: ' . mysqli_connect_error());

}

?>

<html>

	<head>

		<title> Read Message </title>

		<link href="style.css" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">



	</head>

	<body class="loggedin">

		<nav class="navtop">

			<div>

				<h1>Message</h1>

				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>

				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

				<a href="filemanager.php"><i class="fas fa-file-alt"></i>File Manager</a>

				<a href="messages.php"><i class="fas fa-comments"></i>Messages</a>

			</div>

		</nav>



<?php

//We check if the user is logged

if(isset($_SESSION['name']))

{

//We check if the ID of the discussion is defined

if(isset($_GET['id']))

{

$id = intval($_GET['id']);

//echo $id;

//We get the title and the narators of the discussion

$mes = "Select m.subject as subject, m.message as message, m.timesent as timesent, m.from_id as from_id, u.userid as uid, u.username as user1, u2.userid as u2id, u2.username as user2 from messages m, users u, users u2 where m.id=".$id." and u.userid = m.to_id and u2.userid = m.from_id" ;

$req1 = mysqli_query($con,$mes);

$dn1 = mysqli_fetch_array($req1);

$subject = $dn1['subject'];

//echo "NUMROWS".mysqli_num_rows($req1);

//echo $dn1['message'];

//We check if the discussion exists

if(mysqli_num_rows($req1)==1)

{

//We check if the user have the right to read this discussion

if($dn1['uid']==$_SESSION['id'] or $dn1['u2id']==$_SESSION['id'])

{

//The discussion will be placed in read messages

if($dn1['uid']==$_SESSION['id'])

{

        $open = "update messages set opened='1' where id=".$id;

        $doit = mysqli_query($con,$open) or die("bad query: $open");

}

//We get the list of the messages

$lom = "SELECT m.timesent as timesent, m.message as message, u.userId as userid, u.username as username from messages m, users u where m.id= ".$id." and u.userId = m.from_id";

$req2 = mysqli_query($con,$lom);

//We check if the form has been sent

if(isset($_POST['message']) and $_POST['message']!='')

{

        $message = $_POST['message'];

        //We remove slashes depending on the configuration

        //if(get_magic_quotes_gpc())

        //{

         //       $message = stripslashes($message);

        //}

        //We protect the variables

        //$message = mysqli_real_escape_string(nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));

        //We send the message and we change the status of the discussion to unread for the recipient

        $smes ="insert into messages (to_id, from_id, timesent, subject, message, opened, recipientdelete, senderdelete) values(".$dn1['from_id'].", ".$_SESSION['id'].", CURRENT_TIMESTAMP(), 'Re: ".$subject."', '".$message."', '0', '0','0')";

        if(mysqli_query($con, $smes))

        {

?>

<div align="center">Your message has successfully been sent.<br />

<a href="read_pm.php?id=<?php echo $id; ?>">Go to the discussion</a></div>

<?php

        }

        else

        {

?>

<div>An error occurred when sending the message.<br />

<a href="read_pm.php?id=<?php echo $id; ?>">Go to the discussion</a></div>

<?php

        }

}

else

{

//We display the messages

?>

<div class="content">

<h1><?php echo "<b>Subject:</b> ".$dn1['subject']; ?></h1>

<table class="messages_table">

<?php

$sender = $dn1['user2'];

$stamp = $dn1['timesent'];

$mess = $dn1['message'];

while($dn2 = mysqli_fetch_array($req2))

{

?>

        <tr><td class="author center"><?php echo "<b>From:</b> ".$dn2['username']; ?></td></tr>

        <tr><td class="left"><?php echo "<b>Sent:</b> ".$dn2['timesent']; ?></td></tr>

	<tr><td><?php echo "<b>Message:</b> ". $dn2['message']; ?></td></tr>

<?php

}

//We display the reply form

?>

</table><br />

<div class="center">

    <form action="read_pm.php?id=<?php echo $id; ?>" method="post">

        <label for="message" class="center"><b>Reply</b></label><br />

        <textarea cols="40" rows="5" name="message" id="message"></textarea><br />

        <input type="submit" value="Send" />

    </form>

</div>

</div>

<?php

}

}

else

{

        echo '<div class="message">You dont have the rights to access this page.</div>';

}

}

else

{

        echo '<div class="message">This discussion does not exists.</div>';

}

}

else

{

        echo '<div class="message">The discussion ID is not defined.</div>';

}

}

else

{

        echo '<div class="message">You must be logged to access this page.</div>';

}

?>

                <div align="center"  class="foot"><a href="messages.php">Go to my Personal messages</a></div>

        </body>

</html>


