<?php if (!is_object($person) || !$person->getRawValue() instanceof Person) { return; } ?>
<div class="member_entry">
    <a href="<?php echo $person->getWebsite(); ?>" target="_blank">
        <img alt="<?php echo $person; ?>" src="/uploads/people/<?php echo $person->getImage(); ?>" />
    
        <div class="member_info">
            <span class="name"><?php echo $person; ?></span>
<?php foreach ($person->getCategories() as $category) { ?>
            <em><?php echo $category; ?></em>
<?php } ?>
        </div>
    </a>
</div>
