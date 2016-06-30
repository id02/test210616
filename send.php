<?
include "db.php";

$name=trim($_POST['name']);
$email=trim($_POST['email']);
$message=trim($_POST['message']);

if (!strlen($name)||!strlen($message)
	||!strlen($email)||!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	header('Location: /?error');
	die();
}

mysql_query('INSERT INTO `comments` (`id`, `name`, `email`, `message`, `allowed`) VALUES ("", "'.$name.'", "'.$email.'", "'.$message.'", 0)');

header('Location: /');