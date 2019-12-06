<?php

session_start();

$con = mysqli_connect('localhost','endlessclavicle','babycham12','phplogin');

if ( mysqli_connect_errno() ) {

	// If there is an error with the connection, stop the script and display the error.

	die ('Failed to connect to MySQL: ' . mysqli_connect_error());

}

?>

<html >

    <head>

        <title>New PM</title>

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



<?php

//We check if the user is logged

if(isset($_SESSION['name']))

{

$form = true;

$otitle = '';

$orecip = '';

$omessage = '';

//We check if the form has been sent

if(isset($_POST['title'], $_POST['recip'], $_POST['tmessage']))

{

        $otitle = $_POST['title'];

        $orecip = $_POST['recip'];

        $omessage = $_POST['tmessage'];

        //We remove slashes depending on the configuration

        if(get_magic_quotes_gpc())

        {

                $otitle = stripslashes($otitle);

                $orecip = stripslashes($orecip);

                $omessage = stripslashes($omessage);

        }

        //We check if all the fields are filled

        if($_POST['title']!='' and $_POST['recip']!='' and $_POST['tmessage']!='')

        {

                //We protect the variables

                $title = @mysqli_real_escape_string($con,$otitle);

                $recip = @mysqli_real_escape_string($con,$orecip);

                $tmessage = @mysqli_real_escape_string(nl2br(htmlentities($con,$omessage, ENT_QUOTES, 'UTF-8')));

                //We check if the recipient exists

                $q1 = mysqli_query($con,"SELECT COUNT(userId) as recip, userId as recipid, username, (SELECT COUNT(*) FROM messages) as npm FROM users WHERE username = '".$orecip."' GROUP BY userId");

                $dn1 = mysqli_fetch_array($q1);

                $rcp = $dn1['recipid'];

                if($dn1['recip']==1)

                {

                        //We check if the recipient is not the actual user

                        if($dn1['recipid']!=$_SESSION['id'])

                        {

                                $id = $dn1['npm']+1;

                                //We send the message

                                if(mysqli_query($con,"INSERT into messages(to_id, from_id, subject, message, timesent, opened, recipientdelete, senderdelete) VALUES(".$rcp.",".$_SESSION['id'].", '".$otitle."', '".$omessage."', CURRENT_TIMESTAMP(), '0', '0','0')"))

                                {

?>

<div class="message">The message has successfully been sent.<br />

<a href="messages.php">List of my Personal messages</a></div>

<?php

         $form = false;

                                }

                                else

                                {

                                        //Otherwise, we say that an error occured

                                        $error = 'An error occurred while sending the message';

                                }

                        }

                        else

                        {

                                //Otherwise, we say the user cannot send a message to himself

                                $error = 'You cannot send a message to yourself.';

                        }

                }

                else

                {

                        //Otherwise, we say the recipient does not exists

                        $error = 'The recipient '.$orecip.' does not exists.';

                }

        }

        else

        {

                //Otherwise, we say a field is empty

                $error = 'A field is empty. Please fill of the fields.';

        }

}

elseif(isset($_GET['recip']))

{

        //We get the username for the recipient if available

        $orecip = $_GET['recip'];

}

if($form)

{

//Error

if(isset($error))

{

        echo '<div class="message">'.$error.'</div>';

}

//We display the form

?>

<div class="content">

        <h1>New Personal Message</h1>

    <form action="new_pm.php" method="post">

                Please fill the following form to send a Personal message.<br />

        <label for="title">Subject: </label><input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" id="title" name="title" /><br />

        <label for="recip">To<span class="small">(Username): </span></label><input type="text" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>" id="recip" name="recip" /><br />

        <label for="tmessage">Message: </label><textarea cols="40" rows="5" id="tmessage" name="tmessage"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea><br />

        <input type="submit" value="Send" />

    </form>

</div>

<?php

}

}

else

{

        echo '<div class="message">You must be logged to access this page.</div>';

}

?>

                <div class="foot"><a href="messages.php">Go to my Personal messages</a></div>

        </body>

</html>


