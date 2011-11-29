<div data-role="collapsible" data-collapsed="false" data-theme="b" data-content-theme="d">
	<h3>更多...</h3>
	<ul data-role="listview"  data-theme="c" data-dividertheme="d">
		<li data-role="divier"><?php o(@$view['title'])?></li>
		<?php foreach(@$view['list'] as $row){?>
		<li><a href="
		<?php o(path().'?dir='.$row['path'])?>"><?php o($row['title'])?></a></li>
		<?php }?>
		<?php
			$current_page = param('page');
			if(empty($current_page)) $current_page = 1;
			for($i=1; $i<=@$view['pages'];$i++){
			if($i==$current_page){
				$theme = 'data-theme="a"';
			}
			else{
				$theme = '';
			}
		?>
		<li <?php o($theme)?>><a href="<?php o(path().'?dir='.param('dir').'&page='.$i)?>">第<?php echo $i?>页</a></li>
		<?php }?>
	</ul> 
</div>