<ul data-role="listview"> 
	<?php foreach(@$view['list'] as $row){?>
	<li><a href="<?php o(path().'?file='.$row['_path'])?>">
		<img src="<?php o(@$row['thumb'])?>" />
		<h3><?php o(@$row['_title']). ' ' . o(@$row['评价'])?></h3>
		<p><?php o(@$row['_summary'])?></p>
		<p><?php o(@$row['简介'])?>美好的一切，都是生命的眷顾。</p>
		<?php }?>
	</a></li>
</ul> 
