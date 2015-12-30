<?php

/**
 * @file
 * This file is loaded every time the core of e107 is included. ie. Wherever
 * you see require_once("class2.php") in a script. It allows a developer to
 * modify or define constants, parameters etc. which should be loaded prior to
 * the header or anything that is sent to the browser as output. It may also be
 * included in Ajax calls.
 */

e107::lan('nodejs_forum', false, true);

// Register events.
$event = e107::getEvent();
$event->register('user_forum_post_created', 'nodejs_forum_event_user_forum_post_created_callback');
$event->register('login', 'nodejs_forum_event_login_callback');

/**
 * Event callback after triggering "user_forum_post_created".
 *
 * @param array $info
 *  Details about forum post.
 */
function nodejs_forum_event_user_forum_post_created_callback($info)
{
	$postID = intval(vartrue($info['data']['post_id'], 0));
	$postUserID = intval(vartrue($info['data']['post_user'], 0));
	$postThreadID = intval(vartrue($info['data']['post_thread'], 0));

	if($postID === 0 || $postThreadID === 0)
	{
		return;
	}

	// Get forum plugin preferences.
	$plugForumPrefs = e107::getPlugConfig('forum')->getPref();

	$db = e107::getDb();

	// Load thread.
	$thread = $db->retrieve('forum_thread', '*', 'thread_id = ' . $postThreadID);
	$threadUser = intval(vartrue($thread['thread_user'], 0));

	// Load forum to check (read) permission.
	$forum = $db->retrieve('forum', '*', 'forum_id = ' . intval(vartrue($thread['thread_forum_id'], 0)));

	// Author of the forum post.
	$authorPost = e107::user($postUserID);
	// Author of the forum topic.
	$authorThread = e107::user($threadUser);

	e107_require_once(e_PLUGIN . 'nodejs/nodejs.main.php');

	$template = e107::getTemplate('nodejs_forum');
	$sc = e107::getScBatch('nodejs_forum', true);
	$tp = e107::getParser();

	// Get topic page number.
	$postNum = $db->count('forum_post', '(*)', "WHERE post_id <= " . $postID . " AND post_thread = " . $postThreadID . " ORDER BY post_id ASC");
	$postPage = ceil($postNum / vartrue($plugForumPrefs['postspage'], 10));

	// Push rendered row item into Latest Forum Posts menu.
	$sc_vars = array(
		'author'    => $authorPost,
		'post'      => $info['data'],
		'thread'    => $thread,
		'topicPage' => $postPage,
	);

	$sc->setVars($sc_vars);
	$markup = $tp->parseTemplate($template['MENU']['RECENT']['ITEM'], true, $sc);

	$message = (object) array(
		'broadcast' => true,
		'channel'   => 'nodejs_notify',
		'callback'  => 'nodejsForumMenu',
		'type'      => 'latestForumPosts',
		'markup'    => $markup,
	);
	nodejs_enqueue_message($message);


	// Broadcast logged in users to inform about new forum post created.
	if($authorPost)
	{
		$sc->setVars($sc_vars);
		$markup = $tp->parseTemplate($template['NOTIFICATION']['POST_ALL'], true, $sc);

		// It's a public forum, so broadcast every online user.
		if(intval(vartrue($forum['forum_class'], 0)) === 0)
		{
			$message = (object) array(
				'broadcast' => true,
				'channel'   => 'nodejs_notify',
				'callback'  => 'nodejsForum',
				'type'      => 'newForumPostAny',
				'markup'    => $markup,
				'exclude'   => $postUserID,
			);
			nodejs_enqueue_message($message);
		}
		// No-no... it's a non-public forum, so we need to filter online users before broadcasting.
		else
		{
			$forumClass = vartrue($forum['forum_class'], 0);

			$db->select('nodejs_presence');
			while($row = $db->fetch())
			{
				if(isset($row['uid']) && check_class($forumClass, null, $row['uid']))
				{
					$message = (object) array(
						'channel'  => 'nodejs_user_' . $row['uid'],
						'callback' => 'nodejsForum',
						'type'     => 'newForumPostAny',
						'markup'   => $markup,
						'exclude'  => $postUserID,
					);
					nodejs_enqueue_message($message);
				}
			}
		}
	}


	// Broadcast logged in (thread-author) user to inform about new forum post created in his/her topic.
	if(isset($authorThread['user_id']))
	{
		$sc->setVars($sc_vars);
		$markup = $tp->parseTemplate($template['NOTIFICATION']['POST_OWN'], true, $sc);

		$message = (object) array(
			'channel'  => 'nodejs_user_' . $authorThread['user_id'],
			'callback' => 'nodejsForum',
			'type'     => 'newForumPostOwn',
			'markup'   => $markup,
			'exclude'  => $postUserID,
		);
		nodejs_enqueue_message($message);
	}
}

/**
 * Callback function to check EUF defaults.
 */
function nodejs_forum_event_login_callback($data)
{
	$db = e107::getDb();
	$uid = (int) $data['user_id'];

	// Start session.
	$session_started = session_id() === '' ? false : true;
	if($session_started)
	{
		session_start();
	}

	if($uid > 0 && !isset($_SESSION['nodejs_forum_eufs_updated']))
	{
		$_SESSION['nodejs_forum_eufs_updated'] = 1;

		$visits = $db->retrieve('user', 'user_visits', 'user_id = ' . $uid);
		// First time visit.
		if((int) $visits === 0)
		{
			$eufs = array(
				'user_plugin_nodejs_forum_alert_new_post_any' => 1,
				'user_plugin_nodejs_forum_sound_new_post_any' => 1,
				'user_plugin_nodejs_forum_alert_new_post_own' => 1,
				'user_plugin_nodejs_forum_sound_new_post_own' => 1,
				'WHERE'                                       => 'user_extended_id = ' . $uid,
			);

			$db->update('user_extended', $eufs);
		}
	}
}
