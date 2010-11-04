<?php include_partial('person/categories', array('category' => isset($category)?$category:null)); ?>

<p class="edit_listing">
    <?php echo link_to('+ Add Yourself  &rarr;', '@person_create'); ?>
</p>

<div class="clear"></div>

<div id="members">
<?php foreach ($people as $person) {
    include_partial('person/square', array('person' => $person));
} ?>
</div>
<div class="clear"></div>


<div id="pagination">
<?php if ($multiple_pages) { ?>
    <p class="more">
		<?php if (isset($category)): ?>
			<?php echo link_to('Show Me More', '@people_by_category?slug=' . $category->getName() . '&page=2'); ?>
		<?php else: ?>
			<?php echo link_to('Show Me More', '@homepage?page=2'); ?>
		<?php endif; ?>
    </p>
<?php } ?>
</div>


