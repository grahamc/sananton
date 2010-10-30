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
                        
            <?php if ($sf_user->hasFlash('error')): ?>
            <div id="error"><?php echo $sf_user->getFlash('error'); ?></div>
            <?php endif; ?>
            <?php if ($sf_user->hasFlash('success')): ?>
            <div id="success"><?php echo $sf_user->getFlash('success'); ?></div>
            <?php endif; ?>
            
            <?php echo $sf_content ?>
            <div id="push"></div> 
         </div>

        <div id="footer"> 
            <div id="footer-inner"> 
                <p class="footer-links"><?php echo link_to('Get Listed', '@person_new'); ?> | <?php echo link_to('Edit Your Listing', '@person_edit_request'); ?></p> 
                <p class="byline">
                    Stolen by <?php echo link_to('Graham Christensen', 'http://grahamc.com/', array('target' => '_blank')); ?>
                    from <?php echo link_to('Travis Roberts', 'http://travisonrails.com/', array('target' => '_blank')); ?>
                    who was inspired by <?php echo link_to('prtlnd.com', 'http://prtlnd.com', array('target' => '_blank')); ?>.
                    By the way, I'm on <?php echo link_to('Github', 'http://github.com/grahamc/sananton'); ?>.
					<?php echo link_to('Hosting by ZippyKid', 'http://zippykid.com'); ?>
                </p>
            </div>
        </div>
    </body>
</html>
