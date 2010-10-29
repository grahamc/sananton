<div id="members">
<?php foreach ($people as $person) {
    include_partial('person/square', array('person' => $person));
} ?>
</div>
<div class="clear"></div>

<?php if ($multiple_pages) { ?>
<!-- Pagination -->
<div id="pagination">
    <p class="more">
        <a href="/person/list?page=2">Show Me More</a>
    </p>
</div>
<div id="push"></div> 
<?php } ?>
