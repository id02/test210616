<?
include "db.php";

if (isset($_GET['approve']))
{
	$id=intval($_GET['approve']);
	$r = mysql_query('UPDATE `comments` SET `allowed`=1 WHERE `id`='.$id);
	header('Location: /adm.php');
	die();
}elseif (isset($_GET['delete']))
{
	$id=intval($_GET['delete']);
	$r = mysql_query('DELETE FROM `comments` WHERE `id`='.$id);
	header('Location: /adm.php');
	die();
}

?><!doctype html>
<html>
<head>
</head>
<body>
<center>
<?
include "menu.html";

$r = mysql_query('SELECT COUNT(*) FROM `comments` WHERE `allowed` = 0');
$row = mysql_fetch_row($r);
$count = $row[0];

$limit = 10;
$pages = ceil(($count+.5) / $limit);
$page = 1;
if (isset($_GET['page']))
	$page = intval($_GET['page']);

//формируем список
$r = mysql_query('SELECT * FROM `comments` WHERE `allowed` = 0 ORDER BY `id` DESC LIMIT '.($limit*($page-1)).', '.$limit);
$list = array();
while($row = mysql_fetch_assoc($r))
{
	$list[] = $row;
}

//выводим список
foreach($list as $item)
{
	echo '<div>name: '.$item['name'].'<br/>email: '.$item['email'].'<br/>message:<br/>'.$item['message'].'</div>';
	echo '<a href="/adm.php?approve='.$item['id'].'">Approve</a>&nbsp;&nbsp;';
	echo '<a href="/adm.php?delete='.$item['id'].'">Delete</a>';
	echo '<br/>';
}
?>
<div>
Pages:
<?
for($i=1;$i<=$pages;$i++)
{
	if ($i == $page)
		echo $i;
	else
		echo '<a href="?page='.$i.'">'.$i.'</a>';
	echo "&nbsp;&nbsp;";
}
?>
</div>
</center>
</body>
</html>