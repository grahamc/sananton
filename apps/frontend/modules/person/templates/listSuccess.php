<?php include_partial('person/categories', array('category' => isset($category)?$category:null)); ?>

<p class="edit_listing">
    <?php echo link_to('Get Listed  &rarr;', '@person_create'); ?>
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
        <a href="/person/list?page=2">Show Me More</a>
    </p>
<?php } ?>
</div>


