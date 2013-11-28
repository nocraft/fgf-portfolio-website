$(function()
{
	var hash;

	function EventHash()
	{
		
		$('.item').removeClass('unfold');
		hash = window.location.hash;
		$(hash).parent().addClass('hidden');
		var project = $(hash).parent().parent();
		project.addClass('active unfold');
		project.find('.info').addClass('unfold active').stop().animate({opacity: 1}, 300);
		if(hash != ''){
			$('#container').find(".bloc:not('.unfold')").addClass('inactive');
		}
		
		
		var num = hash.replace('#project','');

		/////////////////////////////////////////////
		// PORTFOLIO VIEW hash Ref les differente img
		//\______________________________________________________________	
		if(hash != ''){
			$('#container2 a:not([href$="'+hash+'"]) .thumbv').animate({opacity: 1}, 300).css({cursor: "pointer"});
			$('#container2 a[href$="'+hash+'"] .thumbv').animate({opacity: 0.5}, 300).css({cursor: "default"});

			if (!$('#container2 a[href$="'+hash+'"] img').length == 0) {
				var lienh = $('#container2 a[href$="'+hash+'"] img').attr('src').replace('_205x137.jpg','');
				$('#viewer .fullv img').animate({opacity: 0.1}, 300, function() {
 					$('#viewer .fullv img').attr('src',lienh+'_1016x500.jpg').animate({opacity: 1}, 300);
				});
				$('#viewer .fullv a').attr('href',lienh+'.jpg');
			};
		}else{

			if (!$('#viewer .fullv a').attr('href') == 0) {
				$('#viewer .fullv img').animate({opacity: 0.1}, 0, function() {
					var lienh = $('#viewer .fullv a').attr('href').replace('.jpg','');
					$('#viewer .fullv img').attr('src',lienh+'_1016x500.jpg').animate({opacity: 1}, 300);
	 				$('#viewer .fullv img').animate({opacity: 1}, 300);
				});
			};
			$('#container2 a[href$="#projectv0"] .thumbv').stop().animate({opacity: 0.5}, 300).css({cursor: "default"});
		}
				
		/////////////////////////////////////////////
		// PORTFOLIO Infoselect titre cat date
		//\______________________________________________________________	
		var divtitre = $('#contmeta'+num+' .titre');
		var divdesc = $('#contmeta'+num+' .desc');
		var divcat = $('#contmeta'+num+' .cat');
		var divcom = $('#contmeta'+num+' .comment');	
		var divdate = $('#contmeta'+num+' .date');	
		
		var divtitreachange = $('#titreselect');
		var divdescachange = $('#descselect');
		var divcatachange = $('#catselect');
		var divcomachange = $('#comselect');
		var divdateachange = $('#dateselect');

 		var proj = $('project').hasClass(hash.replace('#',''));

		
		
		if(hash == ''){
			$('.all').addClass('activem');
			divcatachange.hide();
			divcomachange.hide();
			divdateachange.hide();
			divtitreachange.html('Portfolio');
			divdescachange.html('le Portfolio blabla bla bla bl ab laldfsfsd sdjf sdfjk sdlfj ksdlkfj sd fjsdklfj sdlkfj sdlkfj sdlk fjsldk fjsdlkj fsdlfj sdlkfj ');
		}else{
			$('.menucat a[href$="'+hash+'"]').addClass('activem');
			$('.all').removeClass('activem');
			if(proj == true){
				divcatachange.show();
				divtitreachange.html('Portfolio');
				divdescachange.show()
				divcomachange.hide();
				divdateachange.hide();
				divcatachange.html(hash.replace('#',''));
				var lehash = hash.replace('#','');
				var divcatdesc = $('.menucat .'+lehash).text();
				divdescachange.html(divcatdesc);
			}else{
				divtitreachange.html(divtitre.text());
				divcatachange.show();
				divcatachange.html(divcat.text());
				divcomachange.show();			
				divdescachange.html(divdesc.text());
				divdescachange.show()
				var val = divcom.text();
				var addS = (val > 1) ? "s" : "";
				divcomachange.html(divcom.text()+" Commentaire"+addS);
				divdateachange.show();
				divdateachange.html(divdate.text());
			}
		}
		/////////////////////////////////////////////
		// PORTFOLIO Slideshow
		//\______________________________________________________________	
		var currentPosition = 0;
		var slides = $('#slideshow'+num+' .slide');
		var slideWidth = 615;
		var numberOfSlides = slides.length;
		var slideShowInterval;
		var speed = 5000;

		
		slideShowInterval = setInterval(changePosition, speed);
		slides.wrapAll('<div id="slidesHolder'+num+'"></div>');
		slides.css({ 'float' : 'left' });
		
		var slidesHolder = "#slidesHolder"+num;
		$(slidesHolder).css('width', slideWidth * numberOfSlides);
		function changePosition() {
			if(currentPosition == numberOfSlides - 1) {
				currentPosition = 0;
			} else {
				currentPosition++;
			}
			moveSlide();
		}
		
		
		function moveSlide() {
				$(slidesHolder)
				  .animate({'marginLeft' : slideWidth*(-currentPosition)});
		}
		$('#container').masonry();
	}

	$('#container').masonry(
	{
		itemSelector: '.bloc',
		columnWidth: 205
	});

	if (hash != 'undefined')
	{
		EventHash();
	}

	window.onhashchange = function()
	{
		EventHash();
	};

	
	/////////////////////////////////////////////
	// PORTFOLIO  click all , affiche tous Comme au depart
	//\______________________________________________________________
	$('.all').click(function(){
		$('#container').find('.bloc').removeClass('active').stop().animate({opacity: 1}, 300);
		$('#container').find('.bloc').removeClass('hidden').stop().animate({opacity: 1}, 300); 
		
		
		$('#container').find('.info.unfold').removeClass('unfold active').stop().animate({opacity: 1}, 300); 	
		$('#container').find('.bloc.unfold').removeClass('unfold').stop().animate({opacity: 1}, 300); 
		$('#container').find('a.thumb.hidden').removeClass('hidden').stop().animate({opacity: 1}, 300); 
		$('a:not("all")').removeClass('activem');

		$('#container').masonry(); 
	});
	
	/////////////////////////////////////////////
	// PORTFOLIO click sur les liens de categorie
	//\______________________________________________________________
	$('h1 a').click(function(){
		var cls = $(this).attr('href').replace('#','');
		$('#container').find('.bloc').removeClass('active inactive hidden').stop().animate({opacity: 1}, 300);

		$('#container').find(".bloc:not('."+cls+"')").addClass('hidden').animate({opacity: 0}, 300);;
		$('#container').find('.bloc .'+cls).show(500);
		$('#container').find(".bloc:not('."+cls+"')").hide(500);
		$('#container').find('.bloc').removeClass('unfold').stop().animate({opacity: 1}, 300);
		$('#container').find('.bloc.unfold').removeClass('unfold').stop().animate({opacity: 1}, 300); 
		$('#container').find('.info.unfold').removeClass('active unfold').stop().animate({opacity: 0}, 300); 
		$('#container').find('a.thumb.hidden').removeClass('hidden').stop().animate({opacity: 1}, 300); 
		
		$("a:not('."+cls+"')").removeClass('activem');


		var divcomachange = $('#comselect');
		var divdateachange = $('#dateselect');
		divcomachange.hide();
		divdateachange.hide();

		$('#container').masonry(); 
	});

	/////////////////////////////////////////////
	// PORTFOLIO click petit project 
	//\______________________________________________________________	
	$('#container').find('a.thumb').click(function(){
		var elem = $(this); 		
		var unfold = $('#container').find('.unfold').removeClass('unfold active').stop().animate({opacity: 0.25}, 300);;
		elem.children('thumb').removeClass('hidden');
		$('#container').find(".thumb.hidden").removeClass('hidden');
		$('#container').masonry(); 
	});

	/////////////////////////////////////////////
	// PORTFOLIO hover petit project , rend tous les autres elements inactive
	//\______________________________________________________________
	$('project a')
	  .mouseenter(function() {
		var article = $(this);
		article.parent().removeClass('inactive').addClass('active').stop().animate({opacity: 1}, 300);;
		//article.parent().stop().animate({opacity: 1}, 300);
		var unfold = $('#container').find("project").hasClass('unfold active');
		console.log(unfold);
		if (unfold ) {
				$('#container').find(".bloc:not('.active')").addClass('inactive').stop().animate({opacity: 0.25}, 300);
		}
		$('#container').masonry();
	  })
	  .mouseleave(function() {
		var article = $(this);  

		var unfold = $('#container').find("project").hasClass('unfold');
		if (!unfold ) {
				$('#container').find(".bloc:not('.active.unfold')").removeClass('inactive').stop().animate({opacity: 1}, 300);
		}else{
				$('#container').find(".bloc.active:not('.unfold')").removeClass('inactive').stop().animate({opacity: 0.25}, 300);
		}
		
		article.parent().removeClass('active');
		$('#container').masonry(); 
		
	}); 
	
	/////////////////////////////////////////////
	// PORTFOLIO hover grand project , affiche les spans ( detail, description )
	//\______________________________________________________________
	$('project .info')
	  .mouseenter(function() {
		var article = $(this);
		article.parent().addClass('active');
		$('#container').find(".bloc:not('.active')").addClass('inactive');
		$(this).children('.contmeta').stop().slideDown(200);
		$('#container').masonry(); 
	  })
	  .mouseleave(function() {
		var article = $(this);  
		$(this).children('.contmeta').removeClass('active');
		$(this).children('.contmeta').stop().slideUp(200);
		$('#container').masonry(); 
	}); 
	
	/////////////////////////////////////////////
	// Parallax dans le subhead
	//\______________________________________________________________	
	var page = $('html');
	var elem = $('#Parallax');
	page.mousemove(
		function(e){
			/* position de la souri */
			var offset = elem.offset();
			//console.log(offset);
			var xPos = e.pageX - offset.left;
			var yPos = e.pageY - offset.top;

			/* pourcdentage de la position */
			var mouseXPercent = Math.round(xPos / elem.width() * 20);
			var mouseYPercent = Math.round(yPos / elem.height() * 10);
			//console.log('x ='+mouseXPercent);
			//console.log('y ='+mouseYPercent);
			var winWidth = $(window).width();
    		var contWidth = elem.width();
			var decalage = ((winWidth - contWidth) / 2);
            $(".bullheader").css({top : (e.pageY - 65), left : ((e.pageX - decalage)+10)});
       		


			/* position sur le layout */
			elem.children('img').each(
				function(){
					var diffX = elem.width() - $(this).width();
					var diffY = elem.height() - $(this).height();
					//console.log('x ='+diffX);
					//console.log('y ='+diffY);

					var myX = diffX * (mouseXPercent / 20); //) / 100) / 2;
					var myY = diffY * (mouseYPercent / 100);
					//console.log('x ='+myX);
					//console.log('y ='+myY);

					var cssObj = {
						'left': myX + 'px',
						'top': myY + 'px'
					}
					$(this).animate({left: myX, top: myY},{duration: 3500, queue: false, easing: 'linear'});

				}
			);
		e.preventDefault();
		});
		
		
	elem.on({
		mouseenter: function () {
				$(".bullheader").fadeIn();

		},
		mousedown: function () {
				$(this).stop().animate({ "height": "300px" },{duration: 1000, queue: false, easing: 'swing'});
				$(".bullheader").fadeOut();

		},

		mouseleave: function () {
				$(".bullheader").fadeOut();
				$(this).stop().animate({ "height": "200px" },{duration: 700, queue: false, easing: 'swing'});
		}
	}, elem);
	
	/////////////////////////////////////////////
	// change le theme
	//\______________________________________________________________	
	// if($.cookie("css")) {
	// 	$("link").attr("href",$.cookie("css"));
	// }
		
	// $("#nav li a").click(function() { 
	// 	var themename = $(this).attr('rel');
	// 	$("link").attr("href",themename);
	// 	$.cookie("css",$(this).attr('rel'), {expires: 30, path: '/'});
	// 	$('body').hide().fadeIn(1000);
	// 	return false;
	// });
	
	/////////////////////////////////////////////
	// Archive voir plus
	//\______________________________________________________________		
	$('a.seemore').click(function (e) {
        e.preventDefault();
        $(this).slideUp().next('.hidden').slideDown();
    })

});