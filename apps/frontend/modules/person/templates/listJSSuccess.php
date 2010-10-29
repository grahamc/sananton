<?php slot('append'); ?>
<div id="page_<?php echo $page; ?>" class="new_page">
<?php foreach ($people as $person) {
    include_partial('person/square', array('person' => $person));
} ?>
</div>
<?php end_slot(); ?>


$('#members').append(<?php echo json_encode(get_slot('append')); ?>);
<?php if ($multiple_pages) { ?>
$('#pagination').html("  <p class=\"more\">\n    <a href=\"/person/list?page=<?php echo ($page + 1); ?>\">Show Me More<\/a>\n  <\/p>\n");
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