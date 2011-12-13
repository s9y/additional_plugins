(function($) {

/*
 * Ensures an element's text is cut off at a certain maximum number of lines.
 *
 * The element must have a nonzero width when empty. (Most commonly a block
 * element, such as a <p>, will fit this criterion.) The contained, HTML-free
 * text will be truncated to fit the width along with an "end", e.g., '…'.
 * Truncation will only occur along whitespace.
 *
 * Assumptions:
 * - The element is empty or contains only a single text node.
 *
 * Guarantees:
 * - The displayed text will never surpass the requested number of lines.
 * - If truncation occurs and the end string fits within the width of the
 *   element, the end string will be displayed.
 * - As many words in the element's text will be displayed as possible.
 *
 * Options:
 *   end: (default '…') String to append to the end when truncating. May also
 *                      be a DOM node.
 *   always_end: String or DOM node which must always be appended, whether or
 *               not we truncate. (This may actually cause truncation which
 *               would otherwise not occur.)
 *	 lines: (default 1) Number of lines of text to display.
 *
 * --
 * Bodacity JavaScript Utilities
 * http://adamhooper.com/bodacity
 * Public Domain (no licensing restrictions)
 */
function Excerpt(elem, options) {
	this.$elem = $(elem);
	this.options = $.extend({
		end: '…',
		always_end: undefined,
		lines: 1
	}, options);

	this.original_text = this.$elem.text();

	if (typeof(this.options.end) != 'string') {
		// Assume it's a DOM element or jQuery object
		this.$end_node = $(this.options.end);
		this.end_string = this.$end_node.text();
	} else {
		this.end_string = this.options.end;
		this.$end_node = $(document.createTextNode(this.end_string));
	}

	if (this.options.always_end) {
		if (typeof(this.options.always_end) != 'string') {
			this.$always_end_node = $(this.options.always_end);
			this.always_end_string = this.$always_end_node.text();
		} else {
			this.always_end_string = this.options.always_end;
			this.$always_end_node = $(document.createTextNode(this.always_end_string));
		}
	}

	this._attach();
	this.refresh();
}

$.extend(Excerpt.prototype, {
	_attach: function() {
	},

	/*
	 * Resets the element based on its original text, such that it only the
	 * desired number of lines are shown and there is no overflow.
	 */
	refresh: function() {
		if (!this.$elem[0].firstChild) return; // It's already empty

		var wh = this._calculate_desired_width_height();
		var w = wh[0];
		var h = wh[1];

		var s = this.original_text.replace(/\s+/, ' ');

		var spaces = []; // Array of indices to space characters
		spaces.push(0);
		for (var i = 1; i < s.length; i++) {
			if (s.charAt(i) == ' ') {
				spaces.push(i);
			}
		}
		spaces.push(s.length);

		var lbound = 0;
		var rbound = spaces.length - 1;

		var cur = 0;
		var cutoff = 100;
		while (lbound < rbound && cutoff) {
			cur = Math.floor(lbound + (rbound - lbound) / 2);
			if (cur == lbound) cur += 1;

			var sub = this._substring(s, spaces[cur]);
			if (this._is_string_small_enough(sub, w, h)) {
				lbound = cur;
			} else {
				rbound = cur - 1;
			}
			cutoff -= 1;
		}

		this.$elem[0].firstChild.nodeValue = this._substring(s, spaces[lbound], true);
		if (s.length != spaces[lbound]) {
			this.$elem.append(this.$end_node.clone());
		}
		if (this.$always_end_node) {
			this.$elem.append(this.$always_end_node.clone());
		}
	},

	_substring: function(s, length, exclude_end_string) {
		if (length == s.length) return s;
		var substr = s.substr(0, length);
		if (exclude_end_string) {
			return substr;
		} else {
			return substr + this.end_string + (this.always_end_string || '');
		}
	},

	_is_string_small_enough: function(s, w, h) {
		var node = this.$elem[0];

		node.firstChild.nodeValue = s;
		return node.offsetHeight <= h && node.offsetWidth <= w;
	},

	/*
	 * Returns the desired [width, height] in px.
	 *
	 * Modifies this.$elem contents as a side-effect.
	 */
	_calculate_desired_width_height: function() {
		var node = this.$elem[0];

		var s = '&nbsp;';
		for (var i = 0; i < this.options.lines - 1; i++) {
			s += "<br />&nbsp;";
		}

		node.innerHTML = s;

		var w = node.offsetWidth;
		var h = node.offsetHeight;

		node.innerHTML = '&nbsp;'; // anything non-empty

		return [w, h];
	}
});

$.fn.excerpt = function(options) {
	return $(this).each(function() {
		new Excerpt(this, options);
	});
};

})(jQuery);
