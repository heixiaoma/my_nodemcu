

<!DOCTYPE html>
<html lang="en">

<head>
    <title>杨妈妈个人频道</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/unicorn.main.css" />
    <link rel="stylesheet" href="css/unicorn.grey.css" class="skin-color" />

</head>

<body>



                <div class="widget-box">
                    <div class="widget-title">

                        <h5>历史记录</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped table-hover data-table">
                            <thead>
                            <tr>
                                <th>温度</th>
                                <th>湿度</th>
                                <th>天气</th>
                                <th>房间有人时间</th>
                            </tr>
                            </thead>
                            <tbody>


                                <?php

                                include "api.php";

                                $api=new Api();
                                $api->getMessage();

                                ?>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div id="footer" class="span12">
                黑小马网络技术 &copy;  <a href="index.php">by.黑小马</a>
            </div>
        </div>
    </div>
</div>


</body>

</html>

<?php

?>