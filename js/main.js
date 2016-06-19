//page smooth scroll
(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define([], factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.smoothScroll = factory(root);
	}
})(typeof global !== 'undefined' ? global : this.window || this.global, function (root) {

	'use strict';

	//
	// Variables
	//

	var smoothScroll = {}; // Object for public APIs
	var supports = 'querySelector' in document && 'addEventListener' in root; // Feature test
	var settings, eventTimeout, fixedHeader, headerHeight, animationInterval;

	// Default settings
	var defaults = {
		selector: '[data-scroll]',
		selectorHeader: '[data-scroll-header]',
		speed: 500,
		easing: 'easeInOutCubic',
		offset: 0,
		updateURL: true,
		callback: function () {}
	};


	//
	// Methods
	//

	/**
	 * Merge two or more objects. Returns a new object.
	 * @private
	 * @param {Boolean}  deep     If true, do a deep (or recursive) merge [optional]
	 * @param {Object}   objects  The objects to merge together
	 * @returns {Object}          Merged values of defaults and options
	 */
	var extend = function () {

		// Variables
		var extended = {};
		var deep = false;
		var i = 0;
		var length = arguments.length;

		// Check if a deep merge
		if ( Object.prototype.toString.call( arguments[0] ) === '[object Boolean]' ) {
			deep = arguments[0];
			i++;
		}

		// Merge the object into the extended object
		var merge = function (obj) {
			for ( var prop in obj ) {
				if ( Object.prototype.hasOwnProperty.call( obj, prop ) ) {
					// If deep merge and property is an object, merge properties
					if ( deep && Object.prototype.toString.call(obj[prop]) === '[object Object]' ) {
						extended[prop] = extend( true, extended[prop], obj[prop] );
					} else {
						extended[prop] = obj[prop];
					}
				}
			}
		};

		// Loop through each object and conduct a merge
		for ( ; i < length; i++ ) {
			var obj = arguments[i];
			merge(obj);
		}

		return extended;

	};

	/**
	 * Get the height of an element.
	 * @private
	 * @param  {Node} elem The element to get the height of
	 * @return {Number}    The element's height in pixels
	 */
	var getHeight = function ( elem ) {
		return Math.max( elem.scrollHeight, elem.offsetHeight, elem.clientHeight );
	};

	/**
	 * Get the closest matching element up the DOM tree.
	 * @private
	 * @param  {Element} elem     Starting element
	 * @param  {String}  selector Selector to match against (class, ID, data attribute, or tag)
	 * @return {Boolean|Element}  Returns null if not match found
	 */
	var getClosest = function ( elem, selector ) {

		// Variables
		var firstChar = selector.charAt(0);
		var supports = 'classList' in document.documentElement;
		var attribute, value;

		// If selector is a data attribute, split attribute from value
		if ( firstChar === '[' ) {
			selector = selector.substr(1, selector.length - 2);
			attribute = selector.split( '=' );

			if ( attribute.length > 1 ) {
				value = true;
				attribute[1] = attribute[1].replace( /"/g, '' ).replace( /'/g, '' );
			}
		}

		// Get closest match
		for ( ; elem && elem !== document && elem.nodeType === 1; elem = elem.parentNode ) {

			// If selector is a class
			if ( firstChar === '.' ) {
				if ( supports ) {
					if ( elem.classList.contains( selector.substr(1) ) ) {
						return elem;
					}
				} else {
					if ( new RegExp('(^|\\s)' + selector.substr(1) + '(\\s|$)').test( elem.className ) ) {
						return elem;
					}
				}
			}

			// If selector is an ID
			if ( firstChar === '#' ) {
				if ( elem.id === selector.substr(1) ) {
					return elem;
				}
			}

			// If selector is a data attribute
			if ( firstChar === '[' ) {
				if ( elem.hasAttribute( attribute[0] ) ) {
					if ( value ) {
						if ( elem.getAttribute( attribute[0] ) === attribute[1] ) {
							return elem;
						}
					} else {
						return elem;
					}
				}
			}

			// If selector is a tag
			if ( elem.tagName.toLowerCase() === selector ) {
				return elem;
			}

		}

		return null;

	};

	/**
	 * Escape special characters for use with querySelector
	 * @public
	 * @param {String} id The anchor ID to escape
	 * @author Mathias Bynens
	 * @link https://github.com/mathiasbynens/CSS.escape
	 */
	smoothScroll.escapeCharacters = function ( id ) {

		// Remove leading hash
		if ( id.charAt(0) === '#' ) {
			id = id.substr(1);
		}

		var string = String(id);
		var length = string.length;
		var index = -1;
		var codeUnit;
		var result = '';
		var firstCodeUnit = string.charCodeAt(0);
		while (++index < length) {
			codeUnit = string.charCodeAt(index);
			// Note: there’s no need to special-case astral symbols, surrogate
			// pairs, or lone surrogates.

			// If the character is NULL (U+0000), then throw an
			// `InvalidCharacterError` exception and terminate these steps.
			if (codeUnit === 0x0000) {
				throw new InvalidCharacterError(
					'Invalid character: the input contains U+0000.'
				);
			}

			if (
				// If the character is in the range [\1-\1F] (U+0001 to U+001F) or is
				// U+007F, […]
				(codeUnit >= 0x0001 && codeUnit <= 0x001F) || codeUnit == 0x007F ||
				// If the character is the first character and is in the range [0-9]
				// (U+0030 to U+0039), […]
				(index === 0 && codeUnit >= 0x0030 && codeUnit <= 0x0039) ||
				// If the character is the second character and is in the range [0-9]
				// (U+0030 to U+0039) and the first character is a `-` (U+002D), […]
				(
					index === 1 &&
					codeUnit >= 0x0030 && codeUnit <= 0x0039 &&
					firstCodeUnit === 0x002D
				)
			) {
				// http://dev.w3.org/csswg/cssom/#escape-a-character-as-code-point
				result += '\\' + codeUnit.toString(16) + ' ';
				continue;
			}

			// If the character is not handled by one of the above rules and is
			// greater than or equal to U+0080, is `-` (U+002D) or `_` (U+005F), or
			// is in one of the ranges [0-9] (U+0030 to U+0039), [A-Z] (U+0041 to
			// U+005A), or [a-z] (U+0061 to U+007A), […]
			if (
				codeUnit >= 0x0080 ||
				codeUnit === 0x002D ||
				codeUnit === 0x005F ||
				codeUnit >= 0x0030 && codeUnit <= 0x0039 ||
				codeUnit >= 0x0041 && codeUnit <= 0x005A ||
				codeUnit >= 0x0061 && codeUnit <= 0x007A
			) {
				// the character itself
				result += string.charAt(index);
				continue;
			}

			// Otherwise, the escaped character.
			// http://dev.w3.org/csswg/cssom/#escape-a-character
			result += '\\' + string.charAt(index);

		}

		return '#' + result;

	};

	/**
	 * Calculate the easing pattern
	 * @private
	 * @link https://gist.github.com/gre/1650294
	 * @param {String} type Easing pattern
	 * @param {Number} time Time animation should take to complete
	 * @returns {Number}
	 */
	var easingPattern = function ( type, time ) {
		var pattern;
		if ( type === 'easeInQuad' ) pattern = time * time; // accelerating from zero velocity
		if ( type === 'easeOutQuad' ) pattern = time * (2 - time); // decelerating to zero velocity
		if ( type === 'easeInOutQuad' ) pattern = time < 0.5 ? 2 * time * time : -1 + (4 - 2 * time) * time; // acceleration until halfway, then deceleration
		if ( type === 'easeInCubic' ) pattern = time * time * time; // accelerating from zero velocity
		if ( type === 'easeOutCubic' ) pattern = (--time) * time * time + 1; // decelerating to zero velocity
		if ( type === 'easeInOutCubic' ) pattern = time < 0.5 ? 4 * time * time * time : (time - 1) * (2 * time - 2) * (2 * time - 2) + 1; // acceleration until halfway, then deceleration
		if ( type === 'easeInQuart' ) pattern = time * time * time * time; // accelerating from zero velocity
		if ( type === 'easeOutQuart' ) pattern = 1 - (--time) * time * time * time; // decelerating to zero velocity
		if ( type === 'easeInOutQuart' ) pattern = time < 0.5 ? 8 * time * time * time * time : 1 - 8 * (--time) * time * time * time; // acceleration until halfway, then deceleration
		if ( type === 'easeInQuint' ) pattern = time * time * time * time * time; // accelerating from zero velocity
		if ( type === 'easeOutQuint' ) pattern = 1 + (--time) * time * time * time * time; // decelerating to zero velocity
		if ( type === 'easeInOutQuint' ) pattern = time < 0.5 ? 16 * time * time * time * time * time : 1 + 16 * (--time) * time * time * time * time; // acceleration until halfway, then deceleration
		return pattern || time; // no easing, no acceleration
	};

	/**
	 * Calculate how far to scroll
	 * @private
	 * @param {Element} anchor The anchor element to scroll to
	 * @param {Number} headerHeight Height of a fixed header, if any
	 * @param {Number} offset Number of pixels by which to offset scroll
	 * @returns {Number}
	 */
	var getEndLocation = function ( anchor, headerHeight, offset ) {
		var location = 0;
		if (anchor.offsetParent) {
			do {
				location += anchor.offsetTop;
				anchor = anchor.offsetParent;
			} while (anchor);
		}
		location = Math.max(location - headerHeight - offset, 0);
		return Math.min(location, getDocumentHeight() - getViewportHeight());
	};
	
	/**
	 * Determine the viewport's height
	 * @private
	 * @returns {Number}
	 */
	var getViewportHeight = function() {
        	return Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    	};

	/**
	 * Determine the document's height
	 * @private
	 * @returns {Number}
	 */
	var getDocumentHeight = function () {
		return Math.max(
			root.document.body.scrollHeight, root.document.documentElement.scrollHeight,
			root.document.body.offsetHeight, root.document.documentElement.offsetHeight,
			root.document.body.clientHeight, root.document.documentElement.clientHeight
		);
	};

	/**
	 * Convert data-options attribute into an object of key/value pairs
	 * @private
	 * @param {String} options Link-specific options as a data attribute string
	 * @returns {Object}
	 */
	var getDataOptions = function ( options ) {
		return !options || !(typeof JSON === 'object' && typeof JSON.parse === 'function') ? {} : JSON.parse( options );
	};

	/**
	 * Update the URL
	 * @private
	 * @param {Element} anchor The element to scroll to
	 * @param {Boolean} url Whether or not to update the URL history
	 */
	var updateUrl = function ( anchor, url ) {
		if ( root.history.pushState && (url || url === 'true') && root.location.protocol !== 'file:' ) {
			root.history.pushState( null, null, [root.location.protocol, '//', root.location.host, root.location.pathname, root.location.search, anchor].join('') );
		}
	};

	var getHeaderHeight = function ( header ) {
		return header === null ? 0 : ( getHeight( header ) + header.offsetTop );
	};

	/**
	 * Start/stop the scrolling animation
	 * @public
	 * @param {Element} anchor The element to scroll to
	 * @param {Element} toggle The element that toggled the scroll event
	 * @param {Object} options
	 */
	smoothScroll.animateScroll = function ( anchor, toggle, options ) {

		// Options and overrides
		var overrides = getDataOptions( toggle ? toggle.getAttribute('data-options') : null );
		var animateSettings = extend( settings || defaults, options || {}, overrides ); // Merge user options with defaults

		// Selectors and variables
		var isNum = Object.prototype.toString.call( anchor ) === '[object Number]' ? true : false;
		var anchorElem = isNum ? null : ( anchor === '#' ? root.document.documentElement : root.document.querySelector(anchor) );
		if ( !isNum && !anchorElem ) return;
		var startLocation = root.pageYOffset; // Current location on the page
		if ( !fixedHeader ) { fixedHeader = root.document.querySelector( animateSettings.selectorHeader ); }  // Get the fixed header if not already set
		if ( !headerHeight ) { headerHeight = getHeaderHeight( fixedHeader ); } // Get the height of a fixed header if one exists and not already set
		var endLocation = isNum ? anchor : getEndLocation( anchorElem, headerHeight, parseInt(animateSettings.offset, 10) ); // Location to scroll to
		var distance = endLocation - startLocation; // distance to travel
		var documentHeight = getDocumentHeight();
		var timeLapsed = 0;
		var percentage, position;

		// Update URL
		if ( !isNum ) {
			updateUrl(anchor, animateSettings.updateURL);
		}

		/**
		 * Stop the scroll animation when it reaches its target (or the bottom/top of page)
		 * @private
		 * @param {Number} position Current position on the page
		 * @param {Number} endLocation Scroll to location
		 * @param {Number} animationInterval How much to scroll on this loop
		 */
		var stopAnimateScroll = function (position, endLocation, animationInterval) {
			var currentLocation = root.pageYOffset;
			if ( position == endLocation || currentLocation == endLocation || ( (root.innerHeight + currentLocation) >= documentHeight ) ) {
				clearInterval(animationInterval);
				if ( !isNum ) {
					anchorElem.focus();
				}
				animateSettings.callback( anchor, toggle ); // Run callbacks after animation complete
			}
		};

		/**
		 * Loop scrolling animation
		 * @private
		 */
		var loopAnimateScroll = function () {
			timeLapsed += 16;
			percentage = ( timeLapsed / parseInt(animateSettings.speed, 10) );
			percentage = ( percentage > 1 ) ? 1 : percentage;
			position = startLocation + ( distance * easingPattern(animateSettings.easing, percentage) );
			root.scrollTo( 0, Math.floor(position) );
			stopAnimateScroll(position, endLocation, animationInterval);
		};

		/**
		 * Set interval timer
		 * @private
		 */
		var startAnimateScroll = function () {
			clearInterval(animationInterval);
			animationInterval = setInterval(loopAnimateScroll, 16);
		};

		/**
		 * Reset position to fix weird iOS bug
		 * @link https://github.com/cferdinandi/smooth-scroll/issues/45
		 */
		if ( root.pageYOffset === 0 ) {
			root.scrollTo( 0, 0 );
		}

		// Start scrolling animation
		startAnimateScroll();

	};

	/**
	 * If smooth scroll element clicked, animate scroll
	 * @private
	 */
	var eventHandler = function (event) {

		// Don't run if right-click or command/control + click
		if ( event.button !== 0 || event.metaKey || event.ctrlKey ) return;

		// If a smooth scroll link, animate it
		var toggle = getClosest( event.target, settings.selector );
		if ( toggle && toggle.tagName.toLowerCase() === 'a' ) {
			event.preventDefault(); // Prevent default click event
			var hash = smoothScroll.escapeCharacters( toggle.hash ); // Escape hash characters
			smoothScroll.animateScroll( hash, toggle, settings); // Animate scroll
		}

	};

	/**
	 * On window scroll and resize, only run events at a rate of 15fps for better performance
	 * @private
	 * @param  {Function} eventTimeout Timeout function
	 * @param  {Object} settings
	 */
	var eventThrottler = function (event) {
		if ( !eventTimeout ) {
			eventTimeout = setTimeout(function() {
				eventTimeout = null; // Reset timeout
				headerHeight = getHeaderHeight( fixedHeader ); // Get the height of a fixed header if one exists
			}, 66);
		}
	};

	/**
	 * Destroy the current initialization.
	 * @public
	 */
	smoothScroll.destroy = function () {

		// If plugin isn't already initialized, stop
		if ( !settings ) return;

		// Remove event listeners
		root.document.removeEventListener( 'click', eventHandler, false );
		root.removeEventListener( 'resize', eventThrottler, false );

		// Reset varaibles
		settings = null;
		eventTimeout = null;
		fixedHeader = null;
		headerHeight = null;
		animationInterval = null;
	};

	/**
	 * Initialize Smooth Scroll
	 * @public
	 * @param {Object} options User settings
	 */
	smoothScroll.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Destroy any existing initializations
		smoothScroll.destroy();

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		fixedHeader = root.document.querySelector( settings.selectorHeader ); // Get the fixed header
		headerHeight = getHeaderHeight( fixedHeader );

		// When a toggle is clicked, run the click handler
		root.document.addEventListener('click', eventHandler, false );
		if ( fixedHeader ) { root.addEventListener( 'resize', eventThrottler, false ); }

	};


	//
	// Public APIs
	//

	return smoothScroll;

});

// BigSlide menu

(function (factory) {
  'use strict';
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(jQuery);
  }
}(function($) {
  'use strict';

  // where inlineCSS is the string value of an element's style attribute
  // and toRemove is a string of space-separated CSS properties,
  // _cleanInlineCSS removes the CSS declaration for each property in toRemove from inlineCSS
  // and returns the resulting string
  function _cleanInlineCSS(inlineCSS, toRemove){
    var inlineCSSArray  = inlineCSS.split(';');
    var toRemoveArray   = toRemove.split(' ');

    var cleaned         = '';
    var keep;

    for (var i = 0, j = inlineCSSArray.length; i < j; i++) {
      keep = true;
      for (var a = 0, b = toRemoveArray.length; a < b; a++) {
        if (inlineCSSArray[i] === '' || inlineCSSArray[i].indexOf(toRemoveArray[a]) !== -1) {
          keep = false;
        }
      }
      if(keep) {cleaned += inlineCSSArray[i] + '; ';}
    }

    return cleaned;
  }


  $.fn.bigSlide = function(options) {
    // store the menuLink in a way that is globally accessible
    var menuLink = this;

    // plugin settings
    var settings = $.extend({
      'menu': ('#mob-nav'),
      'push': ('.push'),
      'shrink': ('.shrink'),
      'hiddenThin': ('.hiddenThin'),
      'side': 'right',
      'menuWidth': '15.625em',
      'semiOpenMenuWidth': '4em',
      'speed': '300',
      'state': 'closed',
      'activeBtn': 'active',
      'easyClose': true,
      'saveState': false,
      'semiOpenStatus': false,
      'semiOpenScreenWidth': 480,
      'beforeOpen': function () {},
      'afterOpen': function() {},
      'beforeClose': function() {},
      'afterClose': function() {}
    }, options);

    // CSS properties set by bigSlide.js on all implicated DOM elements
    var baseCSSDictionary = 'transition -o-transition -ms-transition -moz-transitions webkit-transition ' + settings.side;

    var model = {
      //CSS properties set by bigSlide.js on this.$menu
      menuCSSDictionary: baseCSSDictionary + ' position top bottom height width',
      //CSS properties set by bigSlide.js on this.$push
      pushCSSDictionary: baseCSSDictionary,
      // store the menu's state in the model
      'state': settings.state
    };

    // talk back and forth between the view and state
    var controller = {
      init: function(){
        view.init();
      },

      // remove bigSlide behavior from the menu
      _destroy: function(){
        view._destroy();

        delete menuLink.bigSlideAPI;

        // return a reference to the DOM selection bigSlide.js was called on
        // so that the destroy method is chainable
        return menuLink;
      },

      // update the menu's state
      changeState: function(){
        if (model.state === 'closed') {
          model.state = 'open'
        } else {
          model.state = 'closed'
        }
      },

      // set the menu's state
      setState: function(state){
        model.state = state;
      },

      // check the menu's state
      getState: function(){
        return model.state;
      }
    };

    // the view contains all of the visual interactions
    var view = {
      init: function(){
        // cache DOM values
        this.$menu = $(settings.menu);
        this.$push = $(settings.push);
        this.$shrink = $(settings.shrink);
        this.$hiddenThin = $(settings.hiddenThin);
        this.width = settings.menuWidth;
        this.semiOpenMenuWidth = settings.semiOpenMenuWidth;

        // CSS for how the menu will be positioned off screen
        var positionOffScreen = {
          'position': 'fixed',
          'top': '0',
          'bottom': '0',
          'height': '100%'
        };

        // css for the sliding animation
        var animateSlide = {
          '-webkit-transition': settings.side + ' ' + settings.speed + 'ms ease',
          '-moz-transition': settings.side + ' ' + settings.speed + 'ms ease',
          '-ms-transition': settings.side + ' ' + settings.speed + 'ms ease',
          '-o-transition': settings.side + ' ' + settings.speed + 'ms ease',
          'transition': settings.side + ' ' + settings.speed + 'ms ease'
        };

        // css for the shrink animation
        var animateShrink = {
          '-webkit-transition': 'all ' + settings.speed + 'ms ease',
          '-moz-transition': 'all ' + settings.speed + 'ms ease',
          '-ms-transition': 'all ' + settings.speed + 'ms ease',
          '-o-transition': 'all ' + settings.speed + 'ms ease',
          'transition': 'all ' + settings.speed + 'ms ease'
        };

        // we want to add the css sliding animation when the page is loaded (on the first menu link click)
        var animationApplied = false;

        // manually add the settings values
        positionOffScreen[settings.side] = '-' + settings.menuWidth;
        positionOffScreen.width = settings.menuWidth;

        // get the initial state based on the last saved state or on the state option
        var initialState = 'closed';
        if (settings.saveState) {
          initialState = localStorage.getItem('bigSlide-savedState');
          if (!initialState) initialState = settings.state;
        } else {
          initialState = settings.state;
        }

        // set the initial state on the controller
        controller.setState(initialState);

        // add the css values to position things offscreen or inscreen depending on the initial state value
        this.$menu.css(positionOffScreen);

        var initialScreenWidth = $(window).width();
        if (initialState === 'closed') {
          if (settings.semiOpenStatus && initialScreenWidth > settings.semiOpenScreenWidth) {
            this.$hiddenThin.hide();
            this.$menu.css(settings.side, '0');
            this.$menu.css('width', this.semiOpenMenuWidth);
            this.$push.css(settings.side, this.semiOpenMenuWidth);
            this.$shrink.css({
              'width': 'calc(100% - ' + this.semiOpenMenuWidth + ')'
            });
            this.$menu.addClass('semiOpen');
          } else {
            this.$push.css(settings.side, '0');
          }
        } else if (initialState === 'open') {
          this.$menu.css(settings.side, '0');
          this.$push.css(settings.side, this.width);
          this.$shrink.css({
            'width': 'calc(100% - ' + this.width + ')'
          });
          menuLink.addClass(settings.activeBtn);
        }

        var that = this;

        // register a click listener for desktop & touchstart for mobile
        menuLink.on('click.bigSlide touchstart.bigSlide', function(e) {
          // add the animation css if not present
          if (!animationApplied) {
            that.$menu.css(animateSlide);
            that.$push.css(animateSlide);
            that.$shrink.css(animateShrink);
            animationApplied = true;
          }

          e.preventDefault();
          if (controller.getState() === 'open') {
            view.toggleClose();
          } else {
            view.toggleOpen();
          }
        });

        // register a window resize listener for tracking the semi open status states
        // This could be more efficently or even there are people that could consider it unnecessary. We can think about it
        if (settings.semiOpenStatus) {
            $(window).resize(function() {
                var screenWidth = $(window).width();
                if (screenWidth > settings.semiOpenScreenWidth) {
                    if (controller.getState() === 'closed') {
                        that.$hiddenThin.hide();
                        that.$menu.css({ width: that.semiOpenMenuWidth});
                        that.$menu.css(settings.side, '0');
                        that.$push.css(settings.side, that.semiOpenMenuWidth);
                        that.$shrink.css({
                          'width': 'calc(100% - ' + that.semiOpenMenuWidth + ')'
                        });
                        that.$menu.addClass('semiOpen');
                    }
                } else {
                    that.$menu.removeClass('semiOpen');
                    if (controller.getState() === 'closed') {
                        that.$menu.css(settings.side, '-' + that.width).css({width: that.width});
                        that.$push.css(settings.side, '0');
                        that.$shrink.css('width', '100%');
                        that.$hiddenThin.show();
                    }
                }
            });
        }

        // this makes my eyes bleed, but adding it back in as it's a highly requested feature
        if (settings.easyClose) {
          $(document).on('click.bigSlide', function(e) {
           if (!$(e.target).parents().andSelf().is(menuLink) && !$(e.target).closest(settings.menu).length && controller.getState() === 'open')  {
             view.toggleClose();
           }
              
          });
        }
      },

      _destroy: function(){
        //remove inline styles generated by bigSlide.js while preserving any other inline styles
        this.$menu.each(function(){
          var $this = $(this);
          $this.attr( 'style', _cleanInlineCSS($this.attr('style'), model.menuCSSDictionary).trim() );
        });

        this.$push.each(function(){
          var $this = $(this);
          $this.attr( 'style', _cleanInlineCSS($this.attr('style'), model.pushCSSDictionary).trim() );
        });

        this.$shrink.each(function(){
          var $this = $(this);
          $this.attr( 'style', _cleanInlineCSS($this.attr('style'), model.pushCSSDictionary).trim() );
        });

        //remove active class and unbind bigSlide event handlers
        menuLink
          .removeClass(settings.activeBtn)
          .off('click.bigSlide touchstart.bigSlide');

        //release DOM references to avoid memory leaks
        this.$menu = null;
        this.$push = null;
        this.$shrink = null;

        //remove the local storage state
        localStorage.removeItem('bigSlide-savedState');
      },

      // toggle the menu open
      toggleOpen: function() {
        settings.beforeOpen();
        controller.changeState();
        view.applyOpenStyles();
        menuLink.addClass(settings.activeBtn);
        settings.afterOpen();

        // save the state
        if (settings.saveState) {
          localStorage.setItem('bigSlide-savedState', 'open');
        }
      },

      // toggle the menu closed
      toggleClose: function() {
        settings.beforeClose();
        controller.changeState();
        view.applyClosedStyles();
        menuLink.removeClass(settings.activeBtn);
        settings.afterClose();

        // save the state
        if (settings.saveState) {
          localStorage.setItem('bigSlide-savedState', 'closed');
        }
      },

      applyOpenStyles: function() {
        var screenWidth = $(window).width();
        if (settings.semiOpenStatus && screenWidth > settings.semiOpenScreenWidth) {
          this.$hiddenThin.show();
          this.$menu.animate({ width: this.width}, {duration: Math.abs(settings.speed - 100), easing: 'linear'});
          this.$push.css(settings.side, this.width);
          this.$shrink.css({
            'width': 'calc(100% - ' + this.width + ')'
          });
          this.$menu.removeClass('semiOpen');
        } else {
          this.$menu.css(settings.side, '0');
          this.$push.css(settings.side, this.width);
          this.$shrink.css({
            'width': 'calc(100% - ' + this.width + ')'
          });
        }
      },

      applyClosedStyles: function() {
        var screenWidth = $(window).width();
        if (settings.semiOpenStatus && screenWidth > settings.semiOpenScreenWidth) {
          this.$hiddenThin.hide();
          this.$menu.animate({ width: this.semiOpenMenuWidth}, {duration: Math.abs(settings.speed - 100), easing: 'linear'});
          this.$push.css(settings.side, this.semiOpenMenuWidth);
          this.$shrink.css({
            'width': 'calc(100% - ' + this.semiOpenMenuWidth + ')'
          });
          this.$menu.addClass('semiOpen');
        } else {
          this.$menu.css(settings.side, '-' + this.width);
          this.$push.css(settings.side, '0');
          this.$shrink.css('width', '100%');
        }
      }

    }

    controller.init();

    this.bigSlideAPI = {
      settings: settings,
      model: model,
      controller: controller,
      view: view,
      destroy: controller._destroy
    };

    return this;
  };

}));
