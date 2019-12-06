<?php

//We start sessions

session_start();



/******************************************************

------------------Required Configuration---------------

Please edit the following variables so the members area

can work correctly.

******************************************************/



//We log to the DataBase

mysql_connect('localhost', 'endlessclavicle', 'babycham12');

mysql_select_db('phplogin');



//Webmaster Email

$mail_webmaster = 'clav@tsuaojap.com';



//Top site root URL

$url_root = 'http://www.tsuaojap.com';



/******************************************************

-----------------Optional Configuration----------------

******************************************************/



//Home page file name

$url_home = 'index.php';



//Design Name

$design = 'default';

?>


