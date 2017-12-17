<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<title>老婆大大安装页面</title>
<form name="form1" align="center" method="post" action=index.php>

<h2 align="center" >数据库类型</h2>
<input type="text" name="dbtype" value="mysql"></input>
<h2 align="center" >数据库地址</h2>
<input type="text" name="host" value="127.0.0.1"></input>
<h2 align="center">数据库名字</h2>
<input type="text" name="dbname" ></input>
<h2 align="center">数据库用户名</h2>
<input type="text" name="dbuser" ></input>
<h2 align="center">数据库登录密码</h2>
<input type="text" name="dbpassword" ></input>
<h6 align="center"></h>
<input type="submit" name="submit1" value="安装"></input>

</form>
</html>

<?php

error_reporting ( E_ALL & ~ E_NOTICE );
//获取表单参数
if($_POST["submit1"]=="安装")
	{
		
		//获取表单参数
		$dbhost=$_POST["host"];
		$dbuser=$_POST["dbuser"];
		$dbpassword=$_POST["dbpassword"];
		$dbtype=$_POST["dbtype"];
		$dbname=$_POST["dbname"];
	//进行数据库连接，如果能连接，者把信息出到一个config文件里
	  $dsn="$dbtype:host=$dbhost;dbname=$dbname";
	
	try{
	 $pdo=new PDO($dsn,$dbuser,$dbpassword);
	//连接成功后，我们把安装数据输入到config.php方便以后连接数据使用！
	$str="<?php \$array=array('dbtype'=>'$dbtype','dbhost'=>'$dbhost','dbname'=>'$dbname','dbuser'=>'$dbuser','dbpassword'=>'$dbpassword');?>";
	$fopen=fopen('config.php',wb)or die('文件不在');
	fwrite($fopen,$str);
	fclose($fopen);
	//配置文件SQL里的语句创建！

		//读取文件内容
	$_sql = file_get_contents('sql.sql');

	$_arr = explode(';', $_sql);

	//执行sql语句
	foreach ($_arr as $_value) {

		$line=$pdo->exec($_value.';');

	}

	echo "安装成功！";
	}
	catch(Exception $e)
		{
		echo "数据库连接失败！".$e;
		}
	
		
	}
else{
echo "非法操作！";

}



?>
