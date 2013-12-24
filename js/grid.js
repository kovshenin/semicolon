var kovkov = kovkov || {};

(function($){

	var columns = 0,
		selectors = [ $('#primary article.hentry'), $('.related-content article') ],
		$window = $(window);

	kovkov.drawGrid = function(redraw) {
		$.each(selectors, function(i, $entries) {
			var count = 0;
			$entries.each(function(i,el){
				var $el = $(el);

				console.log($el);

				// Reset featured and clear states when rendrawing.
				if (redraw) {
					if ($el.hasClass('kovkov-featured-removed'))
						$el.removeClass('kovkov-featured-removed').addClass('kovkov-featured');

					if ($el.hasClass('kovkov-clear-left'))
						$el.removeClass('kovkov-clear-left');

					if ($el.hasClass('kovkov-last'))
						$el.removeClass('kovkov-last');
				}

				// Unfeature a post if it's about to be rendered in the last column position
				// because it won't fit and wrap instead.
				if ($el.hasClass('kovkov-featured') && count % columns === columns - 1) {
					$el.removeClass('kovkov-featured').addClass('kovkov-featured-removed');
				}

				count += 1;

				if (count % columns === 1)
					$el.addClass('kovkov-clear-left');

				// One ghost element because featured posts take up two columns
				if ($el.hasClass('kovkov-featured'))
					count += 1;

				if (count % columns === 0)
					$el.addClass('kovkov-last');
			});
		});
	};

	$window.on('resize', function(){
		var columns_old = columns,
			width = $('#primary').width();

		console.log(width);

		if (width < 600)
			columns = columns !== 2 ? 2 : columns;

		else if (width < 780)
			columns = columns !== 3 ? 3 : columns;

		else if (width >= 780)
			columns = columns !== 4 ? 4 : columns;

		if (columns_old !== columns)
			kovkov.drawGrid(true);
	});

	$window.trigger('resize');

}(jQuery));