<?php echo $form->renderHiddenFields(); ?>
<?php foreach ($form as $field_name => $field) { if ($field->isHidden()) { continue; }?>
      <p>
        <?php echo $field->renderLabel(); ?>
        <?php echo $field->render(); ?>
        <span class="hint"><?php echo $form->getWidgetSchema()->getHelp($field_name); ?></span>
    </p>
<?php } ?>