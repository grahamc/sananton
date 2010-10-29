<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_title(); ?>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    
    <body root="<?php echo sfConfig::get('app_root_url'); ?>">
        <div id="container">
            <h1 class="main_h1"><?php echo link_to(sfConfig::get('app_website_name'), '@homepage'); ?></h1>
            <h1 class="sub_h1">tech community</h1>
            <div class="clear"></div>
            
            <?php echo $sf_content ?>
         </div>

        <div id="footer"> 
            <div id="footer-inner"> 
                <p class="footer-links"><a href="/members/new">Join the Club</a></p> 
                <p class="byline"> 
                    Created by <a href="http://travisonrails.com" onclick="window.open(this.href);return false;">Travis Roberts</a> &nbsp;|&nbsp;
                    Inspired by <a href="http://chriskalani.com/" onclick="window.open(this.href);return false;">Chris Kalani</a> &nbsp;|&nbsp;
                    Ported to symfony by <a href="http://grahamc.com/" onclick="window.open(this.href);return false;">Graham Christensen</a>
                    and <a href="http://prtlnd.com" onclick="window.open(this.href);return false;">prtlnd.com</a> 
                </p> 
            </div>
        </div>
    </body>
</html>
