<?php require_once './includes/application_top.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>NetCollector</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/index.css" rel="stylesheet" type="text/css" />
        <script language="javascript" src="<?php echo __JS__;?>index.js"></script>
    </head>

    <body>
        <div id="head">
            <div id="top_column">
                <font style="position: relative;top: 10px;">+Setting</font>
            </div>
        </div>
        <div id="body">
            <div style="height: 150px;"></div>
            <div id="content">
                <center>
                    <font class="title">NetCollector</font>
                    <div style="height: 50px;">
                    </div>
                    <form action="<?php echo __CORE__; ?>collector_operater.php" method="post">
                        <input type="text" name="object_url" size="60" />
                        <input type="submit" name="Submit" value="Submit"  onclick="loading();"/>
                        <div style="height: 15px;"></div>
                        <input type="radio" name="collect_type" value="html" />
                        <font class="font">.html</font>&nbsp;&nbsp;
                        <input type="radio" name="collect_type" value="css" />
                        <font class="font">.css</font>&nbsp;&nbsp;
                        <input type="radio" name="collect_type" value="js" />
                        <font class="font">.js</font>&nbsp;&nbsp;
                        <input type="radio" name="collect_type" value="images" checked="checked" />
                        <font class="font">.images</font>
                    </form>
                </center>
            </div>
        </div>
        <div id="foot">
            <div style="height: 25px;"></div>
            <center>Copyright&nbsp;&nbsp;©2012-2013&nbsp;&nbsp;Code by Aaron_P</center>
        </div>
        <img id="load_image" style="display: none; position: absolute; top: 400px; left: 47%; width: 70px;" src="<?php echo __IMAGES__; ?>loading.gif" />
    </body>
</html>
