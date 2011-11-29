<div data-role="page" class="type-interior"> 
 
	<div data-role="header" data-theme="f"> 
		<h1>Introduction <?php o(@$view['title'])?></h1> 
		
		
		<a href="<?php echo base_url();?>" data-icon="home" data-iconpos="notext" data-direction="reverse" class="ui-btn-right jqm-home">Home</a> 
	</div><!-- /header --> 
 
	<div data-role="content"> 
		
		<div class="content-primary"> 
		
		<h2>jQuery Mobile Overview</h2> 
 
		<p>hhahaha<?php o(@$view['content'])?></p> 
 
		<p>The critical difference with our approach is the <a href="platforms.html">wide variety of mobile platforms we’re targeting</a> with jQuery Mobile. We’ve been working hard at bringing jQuery support to all mobile browsers that are sufficiently-capable and have at least a nominal amount of market share. In this way, we’re treating mobile web browsers exactly how we treat desktop web browsers.</p> 
		
		<p>To make this broad support possible, all pages in jQuery Mobile are built on a foundation of <strong>clean, semantic HTML</strong> to ensure compatibility with pretty much any web-enabled device. In devices that interpret CSS and JavaScript, jQuery Mobile applies <strong>progressive enhancement techniques</strong> to unobtrusively transform the semantic page into a rich, interactive experience that leverages the power of jQuery and CSS. <strong>Accessibility features</strong> such as WAI-ARIA are tightly integrated throughout the framework to provide support for screen readers and other assistive technologies.</p> 
			
 
		</div><!--/content-primary -->		
		
		<div class="content-secondary"> 
			
			<div data-role="collapsible" data-collapsed="true" data-theme="b" data-content-theme="d"> 
				
					<h3>More in this section</h3> 
					
					<ul data-role="listview"  data-theme="c" data-dividertheme="d"> 
						<li data-role="list-divider">Overview</li> 
						<li data-theme="a"><a href="../../docs/about/intro.html">Intro to jQuery Mobile</a></li> 
						<li><a href="../../docs/about/features.html">Features</a></li> 
						<li><a href="../../docs/about/accessibility.html">Accessibility</a></li> 
						<li><a href="../../docs/about/platforms.html">Supported platforms</a></li> 
 
				
					</ul> 
			</div> 
		</div>		
 
	</div><!-- /content --> 
	
	<div data-role="footer" class="footer-docs" data-theme="c"> 
			<p>&copy; 2011 The jQuery Project</p> 
	</div>	
	
	
</div><!-- /page --> 
 