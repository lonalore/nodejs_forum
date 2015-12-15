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

	if($postID === 0 || $postUserID === 0 || $postThreadID === 0)
	{
		return;
	}

	$db = e107::getDb();

	// Load thread.
	$thread = $db->retrieve('forum_thread', '*', 'thread_id = ' . $postThreadID);
	$threadUser = intval(vartrue($thread['thread_user'], 0));

	$authorPost = e107::user($postUserID);
	$authorThread = e107::user($threadUser);

	// Broadcast logged in users to inform about new forum post created.
	if($authorPost)
	{
		e107_require_once(e_PLUGIN . 'nodejs/nodejs.main.php');

		$template = e107::getTemplate('nodejs_forum');
		$sc = e107::getScBatch('nodejs_forum', true);
		$tp = e107::getParser();

		$sc_vars = array(
			'account' => $authorPost,
			'post'    => $info['data'],
			'thread'  => $thread,
		);

		$sc->setVars($sc_vars);
		$markup = $tp->parseTemplate($template['NOTIFICATION']['POST_ALL'], true, $sc);

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

	// Broadcast logged in (thread-author) user to inform about new forum post created in his/her topic.
	if($authorThread)
	{
		e107_require_once(e_PLUGIN . 'nodejs/nodejs.main.php');

		$template = e107::getTemplate('nodejs_forum');
		$sc = e107::getScBatch('nodejs_forum', true);
		$tp = e107::getParser();

		$sc_vars = array(
			'account' => $authorPost,
			'post'    => $info['data'],
			'thread'  => $thread,
		);

		$sc->setVars($sc_vars);
		$markup = $tp->parseTemplate($template['NOTIFICATION']['POST_OWN'], true, $sc);

		$message = (object) array(
			'channel'  => 'nodejs_user_' . $threadUser,
			'callback' => 'nodejsForum',
			'type'     => 'newForumPostOwn',
			'markup'   => $markup,
			'exclude'  => $postUserID,
		);
		nodejs_enqueue_message($message);
	}
}
