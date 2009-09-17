<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <?php foreach($meta_tags as $name => $content):?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php endforeach;?>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $page_title; ?></title>

        <style type="text/css" media="screen">
            #container
            {
                width: 98%;
                margin: 10px auto;
                background-color: #fff;
                color: #333;               
                line-height: 130%;
            }

            #top
            {
                padding: .5em;
                background-color: white;
                border-bottom: 1px solid gray;
            }

            #top h1
            {
                padding: 0;
                margin: 0;
            }

            #leftnav
            {
                float: left;
                width: 160px;
                margin: 0;
                padding: 1em;
            }

            #content
            {
                margin-left: 262px;
                border-left: 1px solid gray;
                padding: 1em;
                max-width: 36em;
            }

            #footer
            {
                clear: both;
                margin: 0;
                padding: .5em;
                color: #333;
                background-color: #ddd;
                border-top: 1px solid gray;
            }

            #leftnav p { margin: 0 0 1em 0; }
            #content h2 { margin: 0 0 .5em 0; }

        </style>
        <!--
        <script type="text/javascript" charset="utf-8" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript" charset="utf-8">
            // Load jQuery
           // google.load("jquery", "1");
           // google.load("jqueryui", "1");
           // jQuery.noConflict();
        </script>
        -->
<?php if($controller == "job_seeker/number_question"){ ?>
       <link rel="stylesheet" href="http://localhost/k2/assets/css/js.css" type="text/css" />
       <?php } ?>

<?php if($controller == "employer/number_question") {?>
       <link rel="stylesheet" href="http://localhost/k2/assets/css/emp.css" type="text/css" />
       
<?php } ?>
    </head>
    <body>
        <div id="container">
            <div id="top">
                <?php echo $page_header; ?>
            </div>
            <div id="leftnav">
                <?php echo $left_navigation; ?>
            </div>
            <div id="content">
                <?php echo $page_content; ?>
            </div>
            <div id="footer">
                <?php echo $page_footer; ?>
            </div>
            <div>
                <?php echo $page_respone_time; ?>
            </div>
        </div>
    </body>
</html>