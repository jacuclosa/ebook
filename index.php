﻿<? 
session_start(); 
header( 'Content-Type:text/html; charset=utf-8');
if(!$_SESSION['uid']){ 
    echo "<script> alert('ขออภัยสิทธิประโยชน์สำหรับสมาชิกหรือผู้สนับสนุนเท่านั้น'); location.href='../index.php?page=login'; </script>";
	//header("Location: ../index.php?page=login");
}else{
	if($_SESSION['membertype'] == 3){
		echo "<script> alert('ขออภัยสิทธิประโยชน์สำหรับสมาชิกหรือผู้สนับสนุนเท่านั้น'); location.href='../index.php?page=login'; </script>";
		//header("Location: ../index.php?page=login");
	}else{
?>

<!doctype html>
<html lang="en">
<head>
<title>04/2017</title>
<meta name="viewport" content="width = 1050, user-scalable = no" />
<!--<script type="text/javascript" src="../../extras/jquery.min.1.7.js"></script>-->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.min.js"></script>
<script type="text/javascript" src="logistics/extras/modernizr.2.5.3.min.js"></script>
<script type="text/javascript" src="logistics/extras/jquery.mousewheel.min.js"></script>
 
<!-- turn.js files -->
 
<script type="text/javascript" src="logistics/lib/hash.js"></script>
<script type="text/javascript" src="js/magazine.js"></script>
<link type="text/css" rel="stylesheet" href="css/magazine.css"></link>
 
 
</head>
<body> 
<div class="magazine-viewport">
	<div class="container">
		<div class="magazine">
			<!-- Next button -->
			<div ignore="1" class="next-button"></div>
			<!-- Previous button -->
			<div ignore="1" class="previous-button"></div>
		</div>
	</div>
</div>
 
<!-- Thumbnails 
<div class="thumbnails">
	<div>
		<ul>
			<li class="i">
				<img src="pages/1-thumb.jpg" width="76" height="100" class="page-1">
				<span>1</span>
			</li>
			<li class="d">
				<img src="pages/2-thumb.jpg" width="76" height="100" class="page-2">
				<img src="pages/3-thumb.jpg" width="76" height="100" class="page-3">
				<span>2-3</span>
			</li>
			<li class="d">
				<img src="pages/4-thumb.jpg" width="76" height="100" class="page-4">
				<img src="pages/5-thumb.jpg" width="76" height="100" class="page-5">
				<span>4-5</span>
			</li>
			<li class="d">
				<img src="pages/6-thumb.jpg" width="76" height="100" class="page-6">
				<img src="pages/7-thumb.jpg" width="76" height="100" class="page-7">
				<span>6-7</span>
			</li>
			<li class="d">
				<img src="pages/8-thumb.jpg" width="76" height="100" class="page-8">
				<img src="pages/9-thumb.jpg" width="76" height="100" class="page-9">
				<span>8-9</span>
			</li>
			<li class="d">
				<img src="pages/10-thumb.jpg" width="76" height="100" class="page-10">
				<img src="pages/11-thumb.jpg" width="76" height="100" class="page-11">
				<span>10-11</span>
			</li>
			<li class="i">
				<img src="pages/12-thumb.jpg" width="76" height="100" class="page-12">
				<span>12</span>
			</li>
		<ul>
	<div>	
</div>
</div>
--> 

<script type="text/javascript"> 
 
function loadApp() {
 $('#all').fadeIn(1000);
	
 
 
 
	// Create the flipbook
 
	$('.magazine').turn({
			
			// Magazine width
 
			width: 922,
 
			// Magazine height
 
			height: 600,
 
			// Elevation will move the peeling corner this number of pixels by default
 
			elevation: 50,
			
			// Hardware acceleration
 
			acceleration: !isChrome(),
 
			// Enables gradients
 
			gradients: true,
			
			// Auto center this flipbook
 
			autoCenter: true,
 
			// The number of pages
 
			pages: 90,
 
 
			// Events
			when: {
 
			turning: function(event, page, view) {
				
				var book = $(this),
				currentPage = book.turn('page'),
				pages = book.turn('pages');
		
				// Update the current URI
				Hash.go('page/' + page).update();
 
 
				// Show and hide navigation buttons
 
				disableControls(page);
				
				$('.thumbnails .page-'+currentPage).
					parent().
					removeClass('current');
 
				$('.thumbnails .page-'+page).
					parent().
					addClass('current');
 
			},
 
			turned: function(event, page, view) {
 
				disableControls(page);
 
				$(this).turn('center');
 
				if (page==1) { 
					$(this).turn('peel', 'br');
				}
 
			},
 
			missing: function (event, pages) {
 
				// Add pages that aren't in the magazine
 
				for (var i = 0; i < pages.length; i++)
					addPage(pages[i], $(this));
 
			}
		}
 
	});
 
	// Zoom.js
 
	$('.magazine-viewport').zoom({
		flipbook: $('.magazine'),
		max: function() { 
			
			return largeMagazineWidth()/$('.magazine').width();
 
		}, 
		when: {
			tap: function(event) {
 
				if ($(this).zoom('value')==1) {
					$('.magazine').
						removeClass('animated').
						addClass('zoom-in');
					$(this).zoom('zoomIn', event);
				} else {
					$(this).zoom('zoomOut');
				}
			},
 
			resize: function(event, scale, page, pageElement) {
 
				if (scale==1)
					loadSmallPage(page, pageElement);
				else
					loadLargePage(page, pageElement);
 
			},
 
			zoomIn: function () {
				
				$('.thumbnails').hide();
				$('.made').hide();
				$('.magazine').addClass('zoom-in');
 
				if (!window.escTip && !$.isTouch) {
					escTip = true;
 
					$('<div />', {'class': 'esc'}).
						html('<div>Press ESC to exit</div>').
							appendTo($('body')).
							delay(2000).
							animate({opacity:0}, 500, function() {
								$(this).remove();
							});
				}
			},
 
			zoomOut: function () {
 
				$('.esc').hide();
				$('.thumbnails').fadeIn();
				$('.made').fadeIn();
 
				setTimeout(function(){
					$('.magazine').addClass('animated').removeClass('zoom-in');
					resizeViewport();
				}, 0);
 
			},
 
			swipeLeft: function() {
 
				$('.magazine').turn('next');
 
			},
 
			swipeRight: function() {
				
				$('.magazine').turn('previous');
 
			}
		}
	});
 
	// Using arrow keys to turn the page
 
	$(document).keydown(function(e){
 
		var previous = 37, next = 39, esc = 27;
 
		switch (e.keyCode) {
			case previous:
 
				// left arrow
				$('.magazine').turn('previous');
				e.preventDefault();
 
			break;
			case next:
 
				//right arrow
				$('.magazine').turn('next');
				e.preventDefault();
 
			break;
			case esc:
				
				$('.magazine-viewport').zoom('zoomOut');	
				e.preventDefault();
 
			break;
		}
	});
 
	// URIs - Format #/page/1 
 
	Hash.on('^page\/([0-9]*)$', {
		yep: function(path, parts) {
			var page = parts[1];
 
			if (page!==undefined) {
				if ($('.magazine').turn('is'))
					$('.magazine').turn('page', page);
			}
 
		},
		nop: function(path) {
 
			if ($('.magazine').turn('is'))
				$('.magazine').turn('page', 1);
		}
	});
 
 
	$(window).resize(function() {
		resizeViewport();
	}).bind('orientationchange', function() {
		resizeViewport();
	});
 
	// Events for thumbnails
 
	$('.thumbnails').click(function(event) {
		
		var page;
 
		if (event.target && (page=/page-([0-9]+)/.exec($(event.target).attr('class'))) ) {
		
			$('.magazine').turn('page', page[1]);
		}
	});
 
	$('.thumbnails li').
		bind($.mouseEvents.over, function() {
			
			$(this).addClass('thumb-hover');
 
		}).bind($.mouseEvents.out, function() {
			
			$(this).removeClass('thumb-hover');
 
		});
 
	if ($.isTouch) {
	
		$('.thumbnails').
			addClass('thumbanils-touch').
			bind($.mouseEvents.move, function(event) {
				event.preventDefault();
			});
 
	} else {
 
		$('.thumbnails ul').mouseover(function() {
 
			$('.thumbnails').addClass('thumbnails-hover');
 
		}).mousedown(function() {
 
			return false;
 
		}).mouseout(function() {
 
			$('.thumbnails').removeClass('thumbnails-hover');
 
		});
 
	}
 
 
	// Regions
 
	if ($.isTouch) {
		$('.magazine').bind('touchstart', regionClick);
	} else {
		$('.magazine').click(regionClick);
	}
 
	// Events for the next button
 
	$('.next-button').bind($.mouseEvents.over, function() {
		
		$(this).addClass('next-button-hover');
 
	}).bind($.mouseEvents.out, function() {
		
		$(this).removeClass('next-button-hover');
 
	}).bind($.mouseEvents.down, function() {
		
		$(this).addClass('next-button-down');
 
	}).bind($.mouseEvents.up, function() {
		
		$(this).removeClass('next-button-down');
 
	}).click(function() {
		
		$('.magazine').turn('next');
 
	});
 
	// Events for the next button
	
	$('.previous-button').bind($.mouseEvents.over, function() {
		
		$(this).addClass('previous-button-hover');
 
	}).bind($.mouseEvents.out, function() {
		
		$(this).removeClass('previous-button-hover');
 
	}).bind($.mouseEvents.down, function() {
		
		$(this).addClass('previous-button-down');
 
	}).bind($.mouseEvents.up, function() {
		
		$(this).removeClass('previous-button-down');
 
	}).click(function() {
		
		$('.magazine').turn('previous');
 
	});
 
 
	resizeViewport();
 
	$('.magazine').addClass('animated');
 
}
 
 
 $('#all').hide();
 
 
// Load the HTML4 version if there's not CSS transform
 
yepnope({
	test : Modernizr.csstransforms,
	yep: ['logistics/lib/turn.min.js'],
	nope: ['logistics/lib/turn.html4.min.js'],
	both: ['logistics/lib/zoom.min.js'],
	complete: loadApp
});
 
</script>
 
</body>
</html>
<? }} ?>