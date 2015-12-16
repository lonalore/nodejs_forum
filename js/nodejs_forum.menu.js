var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($) {

	/**
	 * Register Node.js callback function to handle pushed messages.
	 *
	 * @type {{callback: Function}}
	 */
	e107.Nodejs.callbacks.nodejsForumMenu = {
		callback: function (message) {
			switch (message.type) {
				case 'latestForumPosts':
					var html = message.data;
					$(html).prependTo('.nodejs-forum-latest-forum-posts').hide().fadeIn('slow');
					break;
			}
		}
	};

})(jQuery);
