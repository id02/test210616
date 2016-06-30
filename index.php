<?
include "db.php";
?><!doctype html>
<html>
<head>
	<style type="text/css">
    #align {
     margin-left: 45%;
	 align: left;
    }
	</style>
</head>
<body>
<div id="align">
<?
include "menu.html";

$r = mysql_query('SELECT COUNT(*) FROM `comments` WHERE `allowed` = 1');
$row = mysql_fetch_row($r);
$count = $row[0];

$limit = 5;
$pages = ceil(($count+.5) / $limit);
$page = 1;
if (isset($_GET['page']))
	$page = intval($_GET['page']);
if ($page<1)$page=1;
if ($page>$pages)$page=$pages;

//формируем список
$r = mysql_query('SELECT * FROM `comments` WHERE `allowed` = 1 ORDER BY `id` DESC LIMIT '.($limit*($page-1)).', '.$limit);
$list = array();
while($row = mysql_fetch_assoc($r))
{
	$list[] = $row['message'].'<br/>'.$row['name'];
}

//форма
?>
<form action="send.php" method="POST">
Name:<br><input name="name" maxlength="255"/></p>
e-mail:<br><input name="email"/></p>
Message:<br><textarea name="message" maxlength="512"></textarea></br>
<input type="submit" value="Send"/></p>
</form>
<?

//выводим список
foreach($list as $item)
{
	echo '<div>'.$item.'</div><br/>';
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
</div>
</body>
</html>