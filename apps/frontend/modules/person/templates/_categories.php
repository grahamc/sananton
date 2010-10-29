<?php
if (is_null($category)) {
    $selected = null;
} else {
    echo '<h2 class="category_title" style="display:none;">' . $category . '</h2>';
    $selected = $category->getId();
}
?>
<div class="category_select_container">
    <p class="category_select_label">Show me</p>
    <select name="category" id="category_select">
        <option value="all"<?php if ($selected == null) { echo ' selected="selected"'; } ?>>All Members</option>
<?php foreach (CategoryPeer::getAll() as $category) { ?>
        <option value="<?php echo $category->getSlug(); ?>"<?php if ($selected == $category->getId()) { echo ' selected="selected"'; }?>><?php echo $category; ?></option>
<?php } ?>
    </select>
</div>