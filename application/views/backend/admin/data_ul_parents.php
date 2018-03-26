<ul id="sortable_search_result" class="connectedSortable">
	<?php
		foreach($list_parents as $row):
	?>
		<li class="ui-state-default" id="<?=$ro->parent_id;?>"><?=$row->name;?></li>
	<?php
		endforeach;
	?>
</ul>