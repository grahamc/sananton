<h1>How does this look?</h1>
<div>
<?php include_partial('square', array('person' => $person)); ?>
</div>
<div>
	<h1><?php echo link_to('Great! Thank you.', '@logout'); ?></h1>
	<p>or</p>
	<h1><?php echo link_to('Let\'s give that another shot.', '@person_edit'); ?></h1>
</div>