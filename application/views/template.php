<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Redux Auth Example</title>
        <?php echo link_tag('assets/css/reset.css')."\n"; ?>
        <?php echo link_tag('assets/css/screen.css')."\n"; ?>
        <!--[if IE]>
            <?php echo link_tag('assets/css/ie.css')."\n"; ?>
        <![endif]-->
        <?php echo link_tag('assets/css/style.css')."\n"; ?>
        <?php echo link_tag('assets/css/typography.css')."\n"; ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="head">
                
            </div>
            <ul id="navigation">
                <li><?php echo anchor('', 'Home'); ?></li>
                <li><?php echo anchor('welcome/activate', 'Activate'); ?></li>
                <li><?php echo anchor('welcome/register', 'Register'); ?></li>
                <li><?php echo anchor('welcome/login', 'Login'); ?></li>
                <li><?php echo anchor('welcome/logout', 'Logout'); ?></li>
                <li><?php echo anchor('welcome/status', 'Account Status'); ?></li>
                <li><?php echo anchor('welcome/change_password', 'Change Password'); ?></li>
                <li><?php echo anchor('welcome/forgotten_password', 'Forgotten Password'); ?></li>
                <li><?php echo anchor('welcome/profile', 'Profile'); ?></li>
            </ul>
            <div id="content">
                <?php echo $content."\n" ?>
            </div>
            <div id="foot">
                
            </div>
        </div>
    </body>
</html>