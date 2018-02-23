var Parallaxy = function(){
		this.win 				= $(window);
		this.body 				= $('body');
		this.winHeight 			= window.innerHeight;
		this.winWidth 			= window.innerWidth;
		this.parallax 			= $('.parallax-layer');
		this.isMobile 			= /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? true : false;
		this.init();
}; 
Parallaxy.prototype =  { 
	init: function() {

		var platform = navigator.platform.toLowerCase();
		var userAgent = navigator.userAgent.toLowerCase();

		if ( this.isMobile ) 
		{
			this.dispelParallax();
		}
		
		// else if (platform.indexOf('win32') != -1 || platform.indexOf('linux') != -1)
		// {
		// 	this.castParallax(this.parallax);					
		// 	if ($.browser.webkit)
		// 	{
		// 		this.castSmoothScroll();
		// 	}
		// }
		
		else
		{
			this.castParallax(this.parallax);
		}

	},

	castParallax: function(el) {

		var opThresh = 350;
		var opFactor = 750;
		var height = el.outerHeight();

		window.addEventListener("scroll", function(event){

			var top = this.pageYOffset;

			var layers = el;
			var layer, speed, yPos;
			for (var i = 0; i < layers.length; i++) {
				layer = layers[i];
				speed = layer.getAttribute('data-speed');
				var yPos = -(top * speed / 100);
				layer.setAttribute('style', 'transform: translate3d(0px, ' + yPos + 'px, 0px); min-height: ' + height + 'px;');
			}
		});


	},

	dispelParallax: function() {
		$(".nonparallax").css('display','block');
		$(".parallax-layer").css('display','none');
	},

	castSmoothScroll: function() {
		$.srSmoothscroll({
			step: 80,
			speed: 300,
			ease: 'linear'
		});
	}
};