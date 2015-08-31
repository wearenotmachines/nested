<?php
function renderNode($node) {
  if( $node->isLeaf() ) {
    return '<li data-item-id="'.$node->id.'" id="item_'.$node->id.'" data-label="'.$node->label.'"><div>' . $node->label . '</div></li>';
  } else {
    $html = '<li data-item-id="'.$node->id.'" id="item_'.$node->id.'" data-label="'.$node->label.'"><div>' . $node->label."</div>";

    $html .= '<ul data-parent-id="'.$node->id.'">';

    foreach($node->children as $child)
      $html .= renderNode($child);

    $html .= '</ul>';

    $html .= '</li>';
  }

  return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tree view</title>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/jquery.mjs.nestedSortable.js"></script>
</head>
<body>
<button id="button">Save</button>
	<ul class="sortable">
		@foreach ($tree AS $node)
		{!! renderNode($node) !!}
		@endforeach
	</ul>
</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
	$('ul.sortable').nestedSortable({
			listType : 'ul',
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            excludeRoot : true
        });
	$('#button').click(function(e) {
		e.preventDefault();
		var hierarchy = $('ul.sortable').nestedSortable('toArray', {startDepthCount : 0});
		// console.dir(hierarchy);
		$.ajax({
		 	url : "/items/rebuild",
		 	type : "post",
		 	data : {tree : JSON.stringify(hierarchy) },
		 	success : function(output) {
		 		console.log(output);
		 	}
		});
	});
});
</script>