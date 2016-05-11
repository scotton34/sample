<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <title>
            <?php
            if (!empty($is_blog)) :
                echo $CI->fuel->blog->page_title($page_title, ' : ', 'right');
            else:
                echo fuel_var('page_title', '');
            endif;
            ?>
        </title>

        <meta name="keywords" content="<?php echo fuel_var('meta_keywords') ?>">
        <meta name="description" content="<?php echo fuel_var('meta_description') ?>">

        <link href='https://fonts.googleapis.com/css?family=Irish+Grover' rel='stylesheet' type='text/css'>
        <?php
        echo css('main') . css($css);

        if (!empty($is_blog)):
            echo $CI->fuel->blog->header();
        endif;
        ?>
        <?= jquery() ?>
    </head>
    <body>
        <div class="page">
            <div class="wrapper">
                <header class="page_header">
                    <h1><?php echo fuel_var('heading') ?></h1>
                </header>
                