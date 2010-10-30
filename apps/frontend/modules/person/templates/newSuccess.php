<?php
if ($form->getObject()->isNew()) {
    $route = '@person_create';
} else {
    $route = '@person_save?id=' . $form->getObject()->getId();
}
?>
<h1 class="add_listing">Add Yourself</h1>

<p>*All fields are required.</p>
<form action="<?php echo url_for($route); ?>" class="new_member" enctype="multipart/form-data" id="new_member" method="post">
<?php if (!$form->getObject()->isNew()) { ?>
    <input type="hidden" name="sf_method" value="put" />
<?php } ?>
<?php echo $form->renderHiddenFields(); ?>
<?php foreach ($form as $field_name => $field) { if ($field->isHidden()) { continue; }?>
      <p>
        <?php echo $field->renderLabel(); ?>
        <?php echo $field->render(array('size' => 30)); ?>
        <span class="hint"><?php echo $form->getWidgetSchema()->getHelp($field_name); ?></span>
        <?php echo $field->renderError(); ?>
    </p>
<?php } ?>
<p class="submit">
    <input id="member_submit" name="commit" type="submit" value="Submit" />
  </p>
</form>