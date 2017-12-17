<?php

if($_GET['insert']=='app')
{
    include "pdo.php";


    $month=$_GET['month'];
    $start_yue=$_GET['start_yue'];
    $end_yue=$_GET['end_yue'];
    $rate=$_GET['rate'];
    $Tj=$_GET['Tj'];

//获取数据库的值
    try{
        $pdo=new PDO($dsn,$dbuser,$dbpassword);
        //设置编码
        $pdo->exec(" set names utf8 ");

        $pdo->exec("INSERT INTO  `v_info` (  `month` ,  `start_yue` ,  `end_yue` ,  `rate` ,  `Tj` ) VALUES (  '$month',  '$start_yue',  '$end_yue',  '$rate',  '$Tj')");
    }
    catch(Exception $e){
        echo "加载失败:".$e;
    }



}



if($_GET['insert']=='wifi')
{
    include "pdo.php";

    $wendu=$_GET["wendu"];
    $shidu=$_GET["shidu"];
    $weather="未知";
/*
    if forecast[1].type=="小雨" then
				st_type="xy"
			elseif forecast[1].type=="阴" then
				st_type="y"
			elseif forecast[1].type=="晴" then
				st_type="q"
			elseif forecast[1].type=="阵雨" then
				st_type="zy"
			elseif forecast[1].type=="多云" then
				st_type="dy"
			elseif forecast[1].type=="中雨" then
				st_type="zy"
			else
				st_type="xxxx"


*/

    switch($_GET["weather"])
    {
        case "xy":
            $weather="小雨";
            break;
        case "y":
            $weather="阴";
            break;
        case "zy":
            $weather="阵雨";
            break;
        case "dy":
            $weather="多云";
            break;
        case "zoy":
            $weather="中雨";
            break;
        case "q":
            $weather="晴";
            break;


    }
    $room= date("Y-m-d H:i:s",time());



//获取数据库的值
    try{
        $pdo=new PDO($dsn,$dbuser,$dbpassword);
        //设置编码
        $pdo->exec(" set names utf8 ");

        $pdo->exec("INSERT INTO `status_room` (`id`, `wendu`, `shidu`, `room`, `weather`) VALUES (NULL, '$wendu', '$shidu', '$room', '$weather');");
    }
    catch(Exception $e){
        echo "加载失败:".$e;
    }



}


?>