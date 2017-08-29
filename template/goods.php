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
        th{
            text-align: center;
        }
        td{
            text-align: center;
        }
        button.btn.btn-default.search{
            text-align: center; 
            width: 29rem; 
            height: 3rem;
            background-color: DodgerBlue; 
            padding: 0.5rem; 
            margin: 0.3rem; 
            color: white;
            font-size: 1.35rem;
        }
    </style>

</head>

<body>

<div class = "menu_layout" name = "menu">
<div align="center" style="margin: 5rem 3rem 1rem 3rem;">
<a href = "user.php">
<p class = menu><img src = "../user_infor/profile_pic/小哥哥.jpeg" class = "profile"/>
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

<div class = "content" style = "background-color:white;">

<div align = "center" style="margin-top: 1rem" >

<form action = "goods.php" method = "post">
<div class="input-group" style = "padding: 0.5rem; font-size: 1.2rem;">
<input type="search" class="form-control" value="借用起止日期" readonly="readonly" style = "background-color: whiteSmoke; border-style: outset; text-align: center; width:29rem;height: 3rem;font-size: 1.3rem"/>
<input type="date" class="form-control" placeholder="借出日期" style = "text-align: center; width: 30rem; height: 3rem;"/>
<input type="date" class="form-control" placeholder="归还日期" style = "text-align: center; width: 30rem; height: 3rem;"/>
</div>

<div class="input-group" style = "padding: 0.5rem; margin-bottom: 0.4rem">
<?php 
echo "<select class='form-control' name = 'condition' style = 'background-color: whiteSmoke;border-style: outset; padding-left: 11rem; width:29rem;height: 3rem;font-size: 1.3rem;'>";

if (!isset($_POST['condition']) || $_POST['condition'] == 'gname')
    echo"<option value = 'gname' style = 'background-color: white;'>物品名称</option>";
else 
    echo"<option value = 'gname' selected = 'selected' style = 'background-color: white;'>物品名称</option>";
if (isset($_POST['condition']) && $_POST['condition'] == 'variety')
    echo"<option value = 'variety' selected = 'selected' style = 'background-color: white;'>物品种类</option>";
else 
    echo"<option value = 'variety' style = 'background-color: white;'>物品种类</option>";
if (isset($_POST['condition']) && $_POST['condition'] == 'belong')
    echo "<option value = 'belong' selected = 'selected' style = 'background-color: white;'>归属部门</option>";
else
    echo"<option value = 'belong' style = 'background-color: white;'>归属部门</option>";
echo"</select>";

if(isset($_POST['sValue']))
    echo "<input type='text' class='form-control' name = 'sValue' value = '".$_POST['sValue']."'' placeholder='查询条件' style = 'text-align: center; width: 60rem; height: 3rem;'>";
else 
    echo "<input type='text' class='form-control' name = 'sValue' value = '' placeholder='查询条件' style = 'text-align: center; width: 60rem; height: 3rem;'>";
?>
</div>

<button type="submit" class="btn btn-default search" name = "search_goods" >查询物资</button>
<button type="submit" class="btn btn-default search" name = "edit_goods">编辑物资</button>
<button type="submit" class="btn btn-default search" name = "user_borrow">我的借用</button>
</div>
</form>

<?php
    define("ACCESS_CODE_TIMEOUT", 300);
    define("ACESS_TOKEN_TIMEOUT", 3600);

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'sauplatform');
    try {
        $dbh = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_SERVER, DB_DATABASE), DB_USERNAME, DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    change_page();

function change_page(){
    global $page, $dbh;

    if(isset($_POST['user_borrow'])){
        /*$sql = $dbh->prepare("select * from borrow  where uid = ?");//从数据库中查询数据
        $sql->execute($_COOKIE['user']);*/
        $sql = $dbh->prepare("select * from borrow natural join goods where uid = ? and ".$_POST['condition']." like '%".$_POST['sValue']."%' order by apply_date;");
        $sql->execute(array($_COOKIE['user']));
        $row = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo "<div align = 'center'><table style = 'width: 100%; line-height: 4rem; padding: 1rem; margin:2rem 0rem'>
        <tr style = 'background-color: #A0D0FF;' >
        <th>物资</th>
        <th>位置</th>
        <th>借用数量</th>
        <th>借用日期</th>
        <th>归还日期</th>
        <th>状态更改</th>
        <th>编辑申请</th>
        </tr>";
        $count = 0;
        foreach ($row as $key)
        {
        if($count%2 ==0)echo "<tr bgcolor = #F8FCFF>";
        else echo "<tr bgcolor = #E0F0FF>";
        echo "<td>" . $key['gname'] . "</td>";
        echo "<td>" . $key['position'] . "</td>";
        echo "<td>" . $key['borrow_num'] . "</td>";
        if(is_null($key['borrow_date']))
            echo "<td color = grey>" . $key['Pborrow'] . "</td>";
        else
            echo "<td>" . $key['borrow_date'] . "</td>";
        if(is_null($key['return_date']))
            echo "<td color = grey>" . $key['Preturn'] . "</td>";
        else
            echo "<td>" . $key['return_date'] . "</td>";
        if(is_null($key['borrow_date']))echo "<td><a href = 'whatever'><img class = icon src = 'icon/borrow.png'>待借出</a>
        </td>";
        else if (is_null($key['return_date']))echo"<td><a href = 'whatever'><img class = icon src = 'icon/return.png'>待归还</a>
        </td>";
        else echo"<td><a href = 'whatever' color = grey><img class = icon src = 'icon/return.png'>已归还</a>
        </td>";
        echo"<td><a href = 'whatever'><img class = icon src = 'icon/edit.png'>编辑</a>
        </td>";
        echo "</tr>";
        $count += 1;
        }
        echo "</table></div>";
    }
    else {
        if(isset($_POST['condition']) && isset($_POST['sValue']))
            $sql = $dbh->prepare("SELECT * FROM goods where ".$_POST['condition']." like '%".$_POST['sValue']."%'");
        else 
            $sql = $dbh->prepare("SELECT * FROM goods");
        $sql->execute();
        $row = $sql->fetchAll(PDO::FETCH_ASSOC);

        echo "<div align = 'center'><table style = 'width: 100%; line-height: 4rem; padding: 1rem; margin:2rem 0rem'>
        <tr style = 'background-color: #A0D0FF;' >
        <th>物资</th>
        <th>种类</th>
        <th>位置</th>
        <th>归属</th>
        <th>总量</th>
        <th>余量</th>
        <th>借用申请</th>
        </tr>";
        $count = 0;
        foreach ($row as $key)
        {
        if($count%2 ==0)echo "<tr bgcolor = #F8FCFF>";
        else echo "<tr bgcolor = #E0F0FF>";
        echo "<td>" . $key['gname'] . "</td>";
        echo "<td>" . $key['variety'] . "</td>";
        echo "<td>" . $key['position'] . "</td>";
        echo "<td>" . $key['belong'] . "</td>";
        echo "<td>" . $key['total'] . "</td>";
        echo "<td>" . $key['stock'] . "</td>";
        echo "<td><a href = 'whatever'><img class = icon src = 'icon/apply.png'>申请</a>
        </td>";
        echo "</tr>";
        $count += 1;
        }
        echo "</table></div>";
    }
}

?>
</div>
</body>

</html>
