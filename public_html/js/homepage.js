var BoojScrollHomePage = function() {
	this.win = $(window);
	this.win_width = this.win.width();
	this.win_height = this.win.height();
	this.body = $('body');
	this.html = $('html');
	this.ipadFix = $('#ipadNavHack');
	this.header = $('#scrolling-header');
	this.home_block = $('#home-section');
	this.offsets = [];
	this.threshold = 481;
	this.heightThreshold = 725;
	this.doScroll = true;
	this.init();
};
BoojScrollHomePage.prototype = {
	init: function() {	
		var self = this;

		this.home_block.css({
			'height': this.win_height - 30
		});

		if (this.win_width < this.threshold || this.win_height < this.heightThreshold) {
			this.nav_to_top();
		}

		this.get_blocks();
		this.getNavClicks();

		this.win.on('scroll', function () {
			if (self.doScroll && self.win_width > self.threshold) {
				if (self.win.scrollTop() > self.win_height - 150) {
					self.nav_to_top();
				} else {	
					self.nav_to_bottom();				
				}
			} else {
				self.nav_to_top();
			}
			self.set_active(self.win.scrollTop());
		});

		this.win.resize(function () {
			self.win_height = self.win.height();
			self.win_width = self.win.width();
			self.home_block.css({
				'height': self.win_height - 30
			});
			self.get_blocks();
			if (self.win_width < self.threshold || self.win_height < self.heightThreshold) {
				self.doScroll = false;
				self.nav_to_top();
			} else {
				self.doScroll = true;
			}
		});	
	},

	nav_to_top: function () {
		this.header.css({
			'position': 'fixed',
			'bottom': 'auto',
			'top': '0'
		});
	},

	nav_to_bottom: function () {
		if (this.win_height < this.heightThreshold) {
			this.nav_to_top();
		} else {
			this.header.css({
				'position': 'absolute',
				'bottom': '0',
				'top': 'auto'
			});
		}
	},

	get_blocks: function () {
		var self = this;
		$('.scrolling-pages-section').each(function () {
			var el = $(this);
			self.offsets.push({
				'top': el.offset().top,
				'rel': el.attr('id')
			});
		});
		this.offsets.reverse();
	},

	set_active: function (s) {
		s = s + 250;
		this.header.find('.active').removeClass('active');
		for (var j in this.offsets) {
			if (this.offsets.hasOwnProperty(j)) {
				if (s >= this.offsets[j].top) {
					this.header.find('a[data-target="#' + this.offsets[j].rel + '"]').parent().addClass('active');
					break;
				}
			}
		}
	},

	getNavClicks: function () {
		var self = this;
		this.header.find('a.click-to-section').on('click', function (e) {
			e.preventDefault();
			var rel = $( $(e.currentTarget).data('target') );
			if (rel.length) {
				if (self.ipadFix.length) {
					self.ipadFix.css('height', '200px');
				}
				$('html, body').animate({scrollTop: (rel.offset().top - 94)}, 500, function () {
					if (self.ipadFix.length) {
						self.ipadFix.css('height', '0px');
					}
				});
			}
		});
	}
};

var BoojQuestions = function () {
	this.wrap = $('#booj-questions-container');
	this.win = $(window);
	this.template = $('#questions-template');
	this.questions = booj_questions || [];
	this.currQ = 0;
	this.ipadFix = $('#ipadNavHack');
	var self = this;
	if (this.template.length && this.questions.length) {
		setTimeout(function() {
			self.init();
		}, 500);
	}
};
BoojQuestions.prototype = {
	init: function () {
		var self = this;
		this.template = this.template.html();
		this.wrap.on('click', 'a', function(e) {
			e.preventDefault();
			var el = $(this);
			if (el.hasClass('yes')) {
				self.scrollToSection(el.data('target'));
			} else {
				self.nextQuestion();
			}
		});
		// console.log(this.template, this.questions);
		this.render(this.currQ);
	},
	nextQuestion: function () {
		this.currQ += 1;
		if (this.currQ > this.questions.length || !this.questions[this.currQ]) {
			this.currQ = 0;
		}
		this.render(this.currQ);
	},
	render: function (i) {
		var self = this;
		var q = this.questions[i];
		var output = Mustache.render(this.template, q);
		var el = this.wrap.children();
		var temp = $('<div></div>').html(output);
		var newBlock = temp.find('.booj-question');
		if (el.length) {

			el.animate({left: (this.win.width() * 2), opacity: 0}, 500, function() {
				newBlock.css({
					left: (self.win.width() * 2) * -1,
					opacity: 0
				});
				self.wrap.html(newBlock);
				newBlock.animate({left: 0, opacity: 1}, 500);
			});
		} else {
			newBlock.css({
				left: (self.win.width() * 2) * -1,
				opacity: 0
			});
			self.wrap.html(newBlock);
			newBlock.animate({left: 0, opacity: 1}, 500);
		}		
	}, 
	scrollToSection: function (t) {
		var self = this;
		var rel = $( t );
		if (rel.length) {
			if (this.ipadFix.length) {
				this.ipadFix.css('height', '200px');
			}
			$('html, body').animate({scrollTop: (rel.offset().top - 94)}, 500, function () {
				if (self.ipadFix.length) {
					self.ipadFix.css('height', '0px');
				}
			});
		}
	}
};

var BoojTeams = function () {
	this.container = $('#teams-section');
	this.currBio = null;
	this.template = $('#booj-team-template');
	if (this.template.length) {
		this.init();
	}
};
BoojTeams.prototype = {
	init: function () {
		var self = this;
		this.template = this.template.html();
		this.container.on('click', 'a[data-action="open-bio"]', function (e) {
			e.preventDefault();
			var el = $(this);
			var objData = el.data();
			if (objData.target !== self.currBio) {
				self.currBio = objData.target;
				self.closeBios();
				self.renderBio({
					video: objData.youtube,
					name: el.text(),
					bio: el.parents('.teams-block').find('.team-bio').html(),
					row: el.parents('.row-fluid')
				});
			}
		});
		this.container.on('click', 'a.close-bio', function (e) {
			self.currBio = null;
			e.preventDefault();
			self.closeBios();
		});
	},

	closeBios: function () {
		this.container.find('.team-bio-info').slideUp('fast', function() {
			$(this).remove();
		});
	},

	renderBio: function (args) {
		var j, output, temp, obj;
		output = Mustache.render(this.template, args);
		temp = $('<div></div>').html(output);
		obj = temp.find('.team-bio-info').hide();
		args.row.after(obj);
		obj.slideDown('fast');
	}
};

$(function () {
	var homScrollObj = new BoojScrollHomePage();
	var jcarouselElem = $('#jcarousel1');
	var jcarouselElem2 = $('#jcarousel2');
	var questions = new BoojQuestions();
	var teams = new BoojTeams();
	
	jcarouselElem.jcarousel({
		animation: 'slow',
		wrap: 'circular'
	});
	jcarouselElem.parent().find(jcarouselElem.data('next')).on('click', function (e) {
		e.preventDefault();
		jcarouselElem.jcarousel('scroll', '-=1');
	});
	jcarouselElem.parent().find(jcarouselElem.data('prev')).on('click', function (e) {
		e.preventDefault();
		jcarouselElem.jcarousel('scroll', '+=1');
	});	

	jcarouselElem2.jcarousel({
		animation: 'slow',
		wrap: 'circular'
	});
	jcarouselElem2.parent().find(jcarouselElem.data('next')).on('click', function (e) {
		e.preventDefault();
		jcarouselElem2.jcarousel('scroll', '-=5');
	});
	jcarouselElem2.parent().find(jcarouselElem.data('prev')).on('click', function (e) {
		e.preventDefault();
		jcarouselElem2.jcarousel('scroll', '+=5');
	});

	$('#myCarousel').carousel({
		interval: 4000
	});
});