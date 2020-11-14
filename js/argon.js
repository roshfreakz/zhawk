'use strict';

var Layout = (function () {

	function pinSidenav() {
		$('.sidenav-toggler').addClass('active');
		$('.sidenav-toggler').attr('data-action', 'sidenav-unpin');
		$('body').removeClass('g-sidenav-hidden').addClass('g-sidenav-show g-sidenav-pinned');
	}

	function unpinSidenav() {
		$('.sidenav-toggler').removeClass('active');
		$('.sidenav-toggler').data('action', 'sidenav-pin');
		$('body').removeClass('g-sidenav-pinned').addClass('g-sidenav-hidden');
	}

	if ($(window).width() > 1200) {
		$(window).resize(function () {
			if ($('body').hasClass('g-sidenav-show') && !$('body').hasClass('g-sidenav-pinned')) {
				$('body').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
			}
		})
	}

	if ($(window).width() < 1200) {
		$('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
		$('body').removeClass('g-sidenav-show');
		$(window).resize(function () {
			if ($('body').hasClass('g-sidenav-show') && !$('body').hasClass('g-sidenav-pinned')) {
				$('body').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
			}
		})
	}

	$("body").on("click", "[data-action]", function (e) {
		e.preventDefault();
		var $this = $(this);
		var action = $this.attr('data-action');
		var target = $this.data('target');
		switch (action) {
			case 'sidenav-pin':
				pinSidenav();
				break;
			case 'sidenav-unpin':
				unpinSidenav();
				break;
		}
	});

	$('.sidenav').on('mouseenter', function () {
		if (!$('body').hasClass('g-sidenav-pinned')) {
			$('body').removeClass('g-sidenav-hide').removeClass('g-sidenav-hidden').addClass('g-sidenav-show');
		}
	});

	$('.sidenav').on('mouseleave', function () {
		if (!$('body').hasClass('g-sidenav-pinned')) {
			$('body').removeClass('g-sidenav-show').addClass('g-sidenav-hide');

			setTimeout(function () {
				$('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
			}, 300);
		}
	});

	$(window).on('load resize', function () {
		if ($('body').height() < 800) {
			$('body').css('min-height', '100vh');
			$('#footer-main').addClass('footer-auto-bottom')
		}
	})

})();

var Navbar = (function () {

	var $nav = $('.navbar-nav, .navbar-nav .nav');
	var $collapse = $('.navbar .collapse');
	var $dropdown = $('.navbar .dropdown');

	function accordion($this) {
		$this.closest($nav).find($collapse).not($this).collapse('hide');
	}

	function closeDropdown($this) {
		var $dropdownMenu = $this.find('.dropdown-menu');

		$dropdownMenu.addClass('close');

		setTimeout(function () {
			$dropdownMenu.removeClass('close');
		}, 200);
	}

	$collapse.on({
		'show.bs.collapse': function () {
			accordion($(this));
		}
	})

	$dropdown.on({
		'hide.bs.dropdown': function () {
			closeDropdown($(this));
		}
	})

})();

var NavbarCollapse = (function () {
	var $nav = $('.navbar-nav'),
		$collapse = $('.navbar .navbar-custom-collapse');

	function hideNavbarCollapse($this) {
		$this.addClass('collapsing-out');
	}

	function hiddenNavbarCollapse($this) {
		$this.removeClass('collapsing-out');
	}

	if ($collapse.length) {
		$collapse.on({
			'hide.bs.collapse': function () {
				hideNavbarCollapse($collapse);
			}
		})

		$collapse.on({
			'hidden.bs.collapse': function () {
				hiddenNavbarCollapse($collapse);
			}
		})
	}

	var navbar_menu_visible = 0;

	$(".sidenav-toggler").click(function () {
		if (navbar_menu_visible == 1) {
			$('body').removeClass('nav-open');
			navbar_menu_visible = 0;
			$('.bodyClick').remove();

		} else {

			var div = '<div class="bodyClick"></div>';
			$(div).appendTo('body').click(function () {
				$('body').removeClass('nav-open');
				navbar_menu_visible = 0;
				$('.bodyClick').remove();

			});

			$('body').addClass('nav-open');
			navbar_menu_visible = 1;

			$('.bodyClick').on('mouseenter', function () {
				$('.sidenav-toggler').removeClass('active');
				$('.sidenav-toggler').data('action', 'sidenav-pin');
				$('body').removeClass('g-sidenav-pinned').addClass('g-sidenav-hidden');
				$('body').find('.backdrop').remove();
			})

		}

	});

})();

var CopyIcon = (function () {

	var $element = '.btn-icon-clipboard',
		$btn = $($element);

	function init($this) {
		$this.tooltip().on('mouseleave', function () {
			$this.tooltip('hide');
		});

		var clipboard = new ClipboardJS($element);

		clipboard.on('success', function (e) {
			$(e.trigger)
				.attr('title', 'Copied!')
				.tooltip('_fixTitle')
				.tooltip('show')
				.attr('title', 'Copy to clipboard')
				.tooltip('_fixTitle')

			e.clearSelection()
		});
	}

	if ($btn.length) {
		init($btn);
	}

})();

var Popover = (function () {

	var $popover = $('[data-toggle="popover"]'),
		$popoverClass = '';

	function init($this) {
		if ($this.data('color')) {
			$popoverClass = 'popover-' + $this.data('color');
		}

		var options = {
			trigger: 'focus',
			template: '<div class="popover ' + $popoverClass + '" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
		};

		$this.popover(options);
	}

	if ($popover.length) {
		$popover.each(function () {
			init($(this));
		});
	}

})();

var Tooltip = (function () {

	var $tooltip = $('[data-toggle="tooltip"]');

	function init() {
		$tooltip.tooltip();
	}

	if ($tooltip.length) {
		init();
	}

})();

var Datepicker = (function () {

	var $datepicker = $('.datepicker');
	function init($this) {
		var options = {
			disableTouchKeyboard: true,
			autoclose: false
		};

		$this.datepicker(options);
	}

	if ($datepicker.length) {
		$datepicker.each(function () {
			init($(this));
		});
	}

})();

var FormControl = (function () {

	var $input = $('.form-control');

	function init($this) {
		$this.on('focus blur', function (e) {
			$(this).parents('.form-group').toggleClass('focused', (e.type === 'focus'));
		}).trigger('blur');
	}

	if ($input.length) {
		init($input);
	}

})();

var noUiSlider = (function () {

	if ($(".input-slider-container")[0]) {
		$('.input-slider-container').each(function () {

			var slider = $(this).find('.input-slider');
			var sliderId = slider.attr('id');
			var minValue = slider.data('range-value-min');
			var maxValue = slider.data('range-value-max');

			var sliderValue = $(this).find('.range-slider-value');
			var sliderValueId = sliderValue.attr('id');
			var startValue = sliderValue.data('range-value-low');

			var c = document.getElementById(sliderId),
				d = document.getElementById(sliderValueId);

			noUiSlider.create(c, {
				start: [parseInt(startValue)],
				connect: [true, false],
				//step: 1000,
				range: {
					'min': [parseInt(minValue)],
					'max': [parseInt(maxValue)]
				}
			});

			c.noUiSlider.on('update', function (a, b) {
				d.textContent = a[b];
			});
		})
	}

	if ($("#input-slider-range")[0]) {
		var c = document.getElementById("input-slider-range"),
			d = document.getElementById("input-slider-range-value-low"),
			e = document.getElementById("input-slider-range-value-high"),
			f = [d, e];

		noUiSlider.create(c, {
			start: [parseInt(d.getAttribute('data-range-value-low')), parseInt(e.getAttribute('data-range-value-high'))],
			connect: !0,
			range: {
				min: parseInt(c.getAttribute('data-range-value-min')),
				max: parseInt(c.getAttribute('data-range-value-max'))
			}
		}), c.noUiSlider.on("update", function (a, b) {
			f[b].textContent = a[b]
		})
	}

})();


function ShowLoadingFn() {
	$('#loader').show();
	$('button').prop('disabled', true);
  }
  
  function HideLoadingFn() {
	setTimeout(function () {
	  $('#loader').hide();
	  $('button').prop('disabled', false);
	}, 1000);
  }
  
  function showNotify(msg, type) {
	$.notify({
	  message: msg
	}, {
	  type: type,
	  allow_dismiss: true,
	  template: '<div data-notify="container" class="notify alert alert-{0}" role="alert">' +
		'<span data-notify="title">{1}</span>' +
		'<span data-notify="message">{2}</span>' +
		'</div>'
	});
  }