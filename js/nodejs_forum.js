var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{

	/**
	 * Register a NodeJS Callback to handle messages with type
	 * "newForumPostAny" and "newForumPostOwn".
	 *
	 * @type {{callback: Function}}
	 */
	e107.Nodejs.callbacks.nodejsForum = {
		callback: function (message)
		{
			var msgData = {
				playsound: false,
				data: {
					subject: '',
					body: message.markup
				}
			};

			switch(message.type)
			{
				case 'newForumPostAny':
					break;

				case 'newForumPostOwn':
					break;
			}

		}
	};

}(jQuery));
