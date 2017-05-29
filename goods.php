<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>goods</title>
    <link rel="stylesheet" type="text/css" href="menusheet.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
    <style type="text/css">
        a:hover{text-decoration: none;}
        .table{
             background-color: white;
             font-family: 微软雅黑；
             font-size: 10px;
             padding: 0px;
             margin: 1px 0px;
        }
    </style>
</head>

<body>
<div class = "menu_layout">
<div align="center" style="margin: 50px 30px 10px 30px;">
<a href = "user.php">
<p class = menu><img src = "user/小哥哥.jpeg" class = "avatar"/>
小哥哥</p>
</a>
</div>
<br/>
<a href="notice.php"><p class = menu><img class = icon src = "icon/notice.png"/>通知</p></a>
<a href="work.php"><p class = menu><img class = icon src = "icon/work.png"/>事务</p></a>
<a href="goods.php"><p class = "menu chosen"><img class = icon src = "icon/goods.png"/>物资</p></a>
<a href="bible.php" ><p class = menu><img class = icon src = "icon/bible.png"/>宝典</p></a>
<a href="wonder.php"><p class = menu><img class = icon src = "icon/wonder.png"/>知乎</p></a>
<a href="lstfd.php"><p class = menu><img class = icon src = "icon/lstfd.png"/>寻物</p></a>
</div>

<div class = "content">
<div align="center">
<form action = "search_in_bible">
<div style="width: 400px; margin: 30px;">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="搜索">
        <span class="input-group-btn">
        <button class="btn btn-default" type="button"><img src="icon/search.png" height=20px></button>
        </span>
    </div><!-- /input-group -->
</div>
</form>
</div>

<div class = table>
<?php
define("ACCESS_CODE_TIMEOUT", 300);
define("ACESS_TOKEN_TIMEOUT", 3600);

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'sauplatform');
try {
    $dbh = new PDO(sprintf('mysql:host=%s;dbname=%s;', DB_SERVER, DB_DATABASE), DB_USERNAME, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
}

$sql = $dbh->prepare("SELECT * FROM goods");
$sql->execute();
$row = $sql->fetchAll(PDO::FETCH_ASSOC);

foreach ($row as $key) {
    echo $key['gname'];
}
/*
$con = mysql_connect("localhost","sau","strdxgjc");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
else echo "connected";
// some code
*/
?>

</div>

</div>
</body>

</html>
