<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
    <?php foreach($meta_tags as $name => $content):?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
    <?php endforeach;?>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $page_title; ?></title>
    </head>
    <body>        
        <?php echo $page_header; ?>
        <?php echo $page_body; ?>
        <?php echo $page_footer; ?>
    </body>
</html>