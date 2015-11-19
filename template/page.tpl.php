<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8" />
    <title><?php echo $page['title']; ?></title>    
    <link rel="stylesheet" type="text/css" href="../lib/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="../lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../lib/font-awesome-4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <script type="text/javascript" src="../lib/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../lib/jquery-1.11.3.min/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../lib/jquery.validate/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../lib/jquery.form.min/jquery.form.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>


    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="content-wrapper lang-wrapper">
                <div class="lang">
                    <span><?php echo $page['CHOOSELANGUAGE'];?></span> <a id="ru" class="btn btn-default btn-xs active-trail" role="button" href="?language=ru">Русский</a><a id="en" class="btn btn-default btn-xs" role="button" href="?language=en">English</a>
                    </div>
                </div>

            <div class="content-wrapper">
                <h2 class="page-title"><?php echo $page['page_title']; ?></h2>
                <?php echo $page['content']; ?>
            </div>
        </div>
    </div>
</body>
</html>