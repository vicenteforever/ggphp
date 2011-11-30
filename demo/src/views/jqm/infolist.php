<div data-role="collapsible" data-collapsed="false" data-theme="b" data-content-theme="d">
	<h3>更多信息...</h3>
	<ul data-role="listview"  data-theme="c" data-dividertheme="d"> 
		<?php foreach(@$view['list'] as $k=>$v){ 
			if(substr($k, 0, 1)=='_') continue;?>
		<li><?php o($k)?>:<?php o($v)?></li>
		<?php }?>
	</ul> 
</div> 
