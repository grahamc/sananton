<div class="category_select_container">
    <p class="category_select_label">Show me</p>
    <select name="category" id="category_select">
        <option value="all">All Members</option>
<?php foreach (CategoryPeer::getAll() as $category) { ?>
        <option value="<?php echo $category->getSlug(); ?>"><?php echo $category; ?></option>
<?php } ?>
    </select>
</div>