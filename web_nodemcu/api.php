<?php
/**
 * Created by PhpStorm.
 * User: 黑小马
 * Date: 2017/7/20
 * Time: 11:15
 */

class Api
{
    //统计次数
    public  $coundate="";
    //最后访问时间
    public $datetime="";
    //健康值
    public $health="84%";
    //最后一次月经开始时间
    public $start_yuejintime="";
    //最后一次月经结束时间
    public $end_yuejintime="";
    //用于头部显示
    public $headyuejintime="";
    //用于翻页
    public $showmonth="";
    //预计月经时间
    public $yuji_yuejintime="";
    //预计排卵时间
    public $yuji_pailuatime="";
    //用于统计网页点击量
   public function v_count()
    {
        include "pdo.php";

//获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM v_count where id=1;";
            $re=$pdo->prepare($sql);
            $re->execute();
            if($res=$re->fetch(PDO::FETCH_ASSOC)){
             

                $this->coundate=$res['count'];
              $this->datetime=$res['datetime'];
            }
            return $res['count'];
        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }


    }


    //用于更新网页点击量
    public function v_count_update()
    {
        include "pdo.php";
        $cu=$this->v_count();
        $cu++;
        $nowtime=date("Y-m-d",time());
//获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "UPDATE  v_count SET count=$cu,datetime=\"$nowtime\" WHERE id=1";
            $re=$pdo->prepare($sql);
            $re->execute();

        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }


    }


    //显示上次访问时间
    public function show_time()
    {
        echo $this->datetime;
    }
    //显示健康指数
    public function health()
    {
        echo $this->health;
    }
    public function getmonth()
    {
        return $this->showmonth;
    }

    public function yujiyuejintime()
    {
        $nowtime=date("Y-m-d",time());
      //  $date=floor((strtotime($nowtime)+strtotime($this->headyuejintime))/86400);
        $date=date('Y-m-d', strtotime($this->headyuejintime.' +23 day'));
       $this->yuji_pailuatime=date('Y-m-d', strtotime($this->headyuejintime.' +14 day'));;
        echo $date;

    }

    public function yujipailuantime()
    {
       echo $this->yuji_pailuatime;

    }


    //显示上月来月经时间
    public function yuejintime()
    {

        include "pdo.php";
        $nowtime=date("Y",time());
    //获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM v_info WHERE  start_yue LIKE '%$nowtime%' ORDER BY `month`;";
            $re=$pdo->prepare($sql);
            $re->execute();
            while($res=$re->fetch(PDO::FETCH_ASSOC)){
               $this->headyuejintime= $this->start_yuejintime= $res['start_yue'];
                $this->end_yuejintime= $res['end_yue'];
                $this->showmonth=$res['month'];

            }
            echo $this->headyuejintime;
        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }
    }

    //折线和柱状图
    public function zhexuantu()
    {
        include "pdo.php";
        $nowtime=date("Y",time());
        $zhe_x=array();
        $zhe_y=array();
        $tj=array();
        $rate=array();
        //获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM v_info WHERE  start_yue LIKE '%$nowtime%' ORDER BY `month`";
            $re=$pdo->prepare($sql);
            $re->execute();
            $i=0;
            while($res=$re->fetch(PDO::FETCH_ASSOC)){

                $zhe_x[$i]=substr($res['start_yue'],5,2);
                $zhe_y[$i]=substr($res['start_yue'],8,2);
                $tj[$i]=$res['Tj'];
                $rate[$i]=$res['rate'];
                $i++;
            }
            //月经时间显示


            echo "var sin = [],cos = [],d1 = [];";
            for($j=1;$j<13;$j++)
            {
                if($zhe_x[0]==$j) {

                    for ($k = 0; $k < count($zhe_x); $k++) {
                            echo
                            "
                         sin.push([$zhe_x[$k], $zhe_y[$k]]);
                         cos.push([$zhe_x[$k], $tj[$k]]);
                         d1.push([parseInt($zhe_x[$k]), $rate[$k]]);
                            ";
                        if($k==count($zhe_x)-1)
                        {
                            break;
                        }
                        $j++;
                    }
                }else
                {
                   echo "
                   sin.push([$j, 0]);
                   cos.push([$j, 0]);
                   d1.push([$j, 0]);
                   ";

                }
            }

        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }



    }

    //扇形图计算月的安全期,月经期,排卵期
    public function shanxintu()
    {
        $x=substr($this->end_yuejintime,8,2);
        $y=substr($this->start_yuejintime,8,2);
        echo "var datatime = Array(30-($x-$y)-14, $x-$y, 14);";
    }

    public function shanxintu_ye($ye)
    {


        include "pdo.php";
        $nowtime = date("Y", time());
        //获取数据库的值
        try {
            $pdo = new PDO($dsn, $dbuser, $dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM v_info WHERE  start_yue LIKE '%$nowtime%' AND `month`=$ye ORDER BY `month`;";

            $re = $pdo->prepare($sql);
            $re->execute();
            if ($res = $re->fetch(PDO::FETCH_ASSOC)) {
                $this->start_yuejintime = $res['start_yue'];
                $this->end_yuejintime = $res['end_yue'];
                $this->showmonth=$res['month'];

            }

            //进行显示
            $x=substr($this->end_yuejintime,8,2);
            $y=substr($this->start_yuejintime,8,2);
            echo "var datatime = Array(30-($x-$y)-14, $x-$y, 14);";
        } catch (Exception $e) {
            echo "加载失败:" . $e;

        }
    }


    //硬件api

    public function getwendu()
    {

        include "pdo.php";

//获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM status_room order by id desc ";
            $re=$pdo->prepare($sql);
            $re->execute();
            if($res=$re->fetch(PDO::FETCH_ASSOC)){

                echo $res['wendu'];
            }

        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }


    }

    public function getshidu()
    {

        include "pdo.php";

//获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM status_room  order by id desc ";
            $re=$pdo->prepare($sql);
            $re->execute();
            if($res=$re->fetch(PDO::FETCH_ASSOC)){

                echo $res['shidu'];
            }

        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }


    }

    public function getroom()
    {

        include "pdo.php";

//获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM status_room  order by id desc";
            $re=$pdo->prepare($sql);
            $re->execute();
            if($res=$re->fetch(PDO::FETCH_ASSOC)){

                echo $res['room'];
            }

        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }


    }

    public function getweather()
    {

        include "pdo.php";

//获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM status_room  order by id desc ";
            $re=$pdo->prepare($sql);
            $re->execute();
            if($res=$re->fetch(PDO::FETCH_ASSOC)){

                echo $res['weather'];
            }

        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }


    }

    //历史记录显示


    public function getMessage()
    {

        include "pdo.php";

        $count_msg=0;
        $msgid=0;
//获取数据库的值
        try{
            $pdo=new PDO($dsn,$dbuser,$dbpassword);
            //设置编码
            $pdo->exec(" set names utf8 ");
            $sql = "SELECT * FROM status_room order by id desc ";
            $re=$pdo->prepare($sql);
            $re->execute();
            while($res=$re->fetch(PDO::FETCH_ASSOC)){
                echo "   <tr class=\"gradeX\">
                         <td>".$res['wendu']."</td>
                         <td>".$res['shidu']."</td>
                         <td>".$res['weather']."</td>
                         <td >".$res['room']."</td>
                         </tr>"
                ;
                $count_msg++;
                $msgid=$res['id'];
            }

            if($count_msg>=200)
            {
                $pdo->exec("DELETE FROM status_room WHERE id <> $msgid");

            }

        }
        catch(Exception $e){
            echo "加载失败:".$e;
        }


    }

}


//特殊方法处理






