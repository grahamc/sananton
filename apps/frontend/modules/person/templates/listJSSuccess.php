<?php slot('append'); ?>
<div id="page_<?php echo $page; ?>" class="new_page">
<?php foreach ($people as $person) {
    include_partial('person/square', array('person' => $person));
} ?>
</div>
<?php end_slot(); ?>
<?php slot('paginator'); ?>
<p class="more">
		<?php if (isset($category)): ?>
			<?php echo link_to('Show Me More', '@people_by_category?slug=' . $category->getSlug() . '&page=' . ($page + 1)); ?>
		<?php else: ?>
			<?php echo link_to('Show Me More', '@homepage?page=' . ($page + 1)); ?>
		<?php endif; ?>
</p>
<?php end_slot(); ?>


$('#members').append(<?php echo json_encode(get_slot('append')); ?>);
<?php if ($multiple_pages) { ?>
$('#pagination').html(<?php echo json_encode(get_slot('paginator')); ?>);
<?php } else { ?>
$('#pagination').html("");    
<?php } ?>

$(document).ready(function() {
  // show and hide member info panels
  $('.member_entry').hover(
    function() {
      var target_div = $(this).find('.member_info');
      var move = 185 - target_div.height();
      $(this).find('.member_info').animate({top:move}, {queue:false, duration:250, easing: 'easeInSine'});
    },
    function() {
      $(this).find('.member_info').animate({top:'160px'}, {queue:false, duration:250, easing: 'easeOutSine'});
    }
  );
  
  // scroll the page down to the new entries
  $("#page_<?php echo $page; ?>").scrollThis();
});