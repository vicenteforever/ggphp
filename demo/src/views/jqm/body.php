<div data-role="page" class="type-interior"> 
	<div data-role="header" data-theme="f" data-position="fixed"> 
		<a href="javascript:history.back()" data-icon="back" data-iconpos="notext">Back</a> 
		<h1><?php o(@$view['title'])?></h1> 
		<a href="<?php echo base_url();?>" data-icon="home" data-iconpos="notext">Home</a> 
	</div><!-- /header --> 
 
	<div data-role="content"> 
		
		<div class="content-primary"><?php o(@$view['primary'])?></div>
		
		<div class="content-secondary"><?php o(@$view['secondary'])?></div>
 
	</div><!-- /content --> 
	
	<div data-role="footer" class="footer-docs" data-theme="c"> 
		<p><div align=center>&copy; 2011 大连德龙科技有限公司</div></p>
	</div>	
	
</div><!-- /page --> 
