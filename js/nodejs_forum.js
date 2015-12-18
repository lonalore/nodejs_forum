var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{

	/**
	 * Register a NodeJS Callback to handle messages with type "newForumPostAny" and "newForumPostOwn".
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

			var currenUser = parseInt(e107.settings.nodejs_forum.current_user);
			var excluded = parseInt(message.exclude);

			if(currenUser == excluded)
			{
				return;
			}

			switch(message.type)
			{
				case 'newForumPostAny':
					if(parseInt(e107.settings.nodejs_forum.alert_new_post_any) === 1)
					{
						e107.Nodejs.callbacks.nodejsNotify.callback(msgData);
					}

					if(parseInt(e107.settings.nodejs_forum.sound_new_post_any) === 1)
					{
						e107.Nodejs.callbacks.nodejsNotifySoundAlert.callback();
					}
					break;

				case 'newForumPostOwn':
					if(parseInt(e107.settings.nodejs_forum.alert_new_post_own) === 1)
					{
						e107.Nodejs.callbacks.nodejsNotify.callback(msgData);
					}

					if(parseInt(e107.settings.nodejs_forum.sound_new_post_own) === 1)
					{
						e107.Nodejs.callbacks.nodejsNotifySoundAlert.callback();
					}
					break;
			}

		}
	};

}(jQuery));
