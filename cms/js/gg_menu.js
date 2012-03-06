/**
 * @author goodzsq@gmail.com
 */
(function( $ ){
  $.fn.gg_menu = function( options ) {

    var settings = {
      'width': 120,
      'height': 35,
      'color': '#fff',
      'bgcolor':'#333',
      'hovercolor':'#4698ca',
      'border1':'1px solid #4a4a4a',
      'border2':'1px solid #242424',
      'dir':'h'
    };

    return this.each(function() {
      if ( options ) { 
        $.extend( settings, options );
      }
	//code here
        $(this).css({'height':settings.height});
	$(this).find('*').css({'margin':0,'padding':0,'text-align':'center'});
	$(this).find('a').css({
		'color':settings.color,
		'width':settings.width,
		'text-decoration':'none',
		'line-height':settings.height + 'px',
		'height':settings.height,
		'display':'block',
		'background-color':settings.bgcolor,
		'border-top':settings.border1,
		'border-left':settings.border1,
		'border-bottom':settings.border2,
		'border-right':settings.border2
	});
	$(this).find('a').hover(
		function(){$(this).css({'background-color':settings.hovercolor})},
		function(){$(this).css({'background-color':settings.bgcolor})}
	);
	$(this).find('li').css({'width':settings.width,'height':settings.height+2});
	$(this).find('ul,li').css({'list-style':'none'});
	if(settings.dir=='h'){
		$(this).find('li').css({'float':'left', 'position':'relative'});
		$(this).find('li ul').css({'float':'left', 'position':'absolute', 'display':'none', 'top':settings.height+2});
	}
	else{
		$(this).find('li').css({'position':'relative'});
		$(this).find('li ul').css({'display':'none','position':'absolute', 'left':settings.width+2,'top':'0'});
	}
	
	$(this).find('li ul li').css({'position':'relative'});
	$(this).find('li ul li ul').css({'display':'none','position':'absolute', 'left':settings.width+2,'top':'0'});

	//draw left arrow
	$(this).find('li').each(function(){
		if($(this).children('ul').length>0){
			$(this).find('>a').css({'background':settings.bgcolor + ' url(data:image/gif;base64,R0lGODlhHgAgAIABAP///////yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QkRBQzhDODU2NzM4MTFFMTkzRDFEMzYxQzdBNzE0RDYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QkRBQzhDODY2NzM4MTFFMTkzRDFEMzYxQzdBNzE0RDYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCREFDOEM4MzY3MzgxMUUxOTNEMUQzNjFDN0E3MTRENiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCREFDOEM4NDY3MzgxMUUxOTNEMUQzNjFDN0E3MTRENiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PgH//v38+/r5+Pf29fTz8vHw7+7t7Ovq6ejn5uXk4+Lh4N/e3dzb2tnY19bV1NPS0dDPzs3My8rJyMfGxcTDwsHAv769vLu6ubi3trW0s7KxsK+urayrqqmop6alpKOioaCfnp2cm5qZmJeWlZSTkpGQj46NjIuKiYiHhoWEg4KBgH9+fXx7enl4d3Z1dHNycXBvbm1sa2ppaGdmZWRjYmFgX15dXFtaWVhXVlVUU1JRUE9OTUxLSklIR0ZFRENCQUA/Pj08Ozo5ODc2NTQzMjEwLy4tLCsqKSgnJiUkIyIhIB8eHRwbGhkYFxYVFBMSERAPDg0MCwoJCAcGBQQDAgEAACH5BAEAAAEALAAAAAAeACAAAAIujI+py+0Po5y02ouz3hyCjgAfGIhjZ55bqmZse70ci5qgfcOaTvb+DwwKh0RgAQA7) right no-repeat'});
		}
	});
	//draw down arrow
	if(settings.dir=='h'){
		$(this).find('>li').each(function(){
			if($(this).children('ul').length>0){
				$(this).find('>a').css({'background':settings.bgcolor + ' url(data:image/gif;base64,R0lGODlhIAAeAIABAP///////yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MDJCOEUyMDc2NzNDMTFFMUFBRTc4MUFERjFERkY0MTQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MDJCOEUyMDg2NzNDMTFFMUFBRTc4MUFERjFERkY0MTQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowMkI4RTIwNTY3M0MxMUUxQUFFNzgxQURGMURGRjQxNCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowMkI4RTIwNjY3M0MxMUUxQUFFNzgxQURGMURGRjQxNCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PgH//v38+/r5+Pf29fTz8vHw7+7t7Ovq6ejn5uXk4+Lh4N/e3dzb2tnY19bV1NPS0dDPzs3My8rJyMfGxcTDwsHAv769vLu6ubi3trW0s7KxsK+urayrqqmop6alpKOioaCfnp2cm5qZmJeWlZSTkpGQj46NjIuKiYiHhoWEg4KBgH9+fXx7enl4d3Z1dHNycXBvbm1sa2ppaGdmZWRjYmFgX15dXFtaWVhXVlVUU1JRUE9OTUxLSklIR0ZFRENCQUA/Pj08Ozo5ODc2NTQzMjEwLy4tLCsqKSgnJiUkIyIhIB8eHRwbGhkYFxYVFBMSERAPDg0MCwoJCAcGBQQDAgEAACH5BAEAAAEALAAAAAAgAB4AAAIojI+py+0Po5y02ouz3rz7TwHiSIpZWW6oyaEfCQZsTNf2jef6zvdbAQA7) right no-repeat'});
			}
		});
	}


	$(this).find('li').hover(
		function(){
			$(this).children('ul').stop(true,true).fadeIn('fast');
		},
		function(){
			$(this).children('ul').stop(true,true).fadeOut('fast');
		}
	);
	//end code
    });

  };
})( jQuery );