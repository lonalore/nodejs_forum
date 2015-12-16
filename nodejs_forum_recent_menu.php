<?php

/**
 * @file
 * Recent forum posts menu.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/nodejs_forum/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('nodejs_forum', false, true);


/**
 * Class nodejs_forum_recent_menu.
 */
class nodejs_forum_recent_menu
{

	/**
	 * Store plugin preferences.
	 *
	 * @var array
	 */
	private $plugPrefs = array();


	/**
	 * Constructor.
	 */
	function __construct()
	{
		if(e107::isInstalled('nodejs_forum'))
		{
			// Get plugin preferences.
			$this->plugPrefs = e107::getPlugConfig('nodejs_forum')->getPref();
			$this->renderMenu();
		}
	}


	/**
	 * Render menu.
	 */
	function renderMenu()
	{
		$tpl = e107::getTemplate('nodejs_forum');
		$sc = e107::getScBatch('nodejs_forum', true);
		$tp = e107::getParser();

		$items = $this->getLatestForumPosts();

		$text = $tp->parseTemplate($tpl['MENU']['RECENT']['HEADER'], true, $sc);
		foreach($items as $item)
		{
			$sc->setVars($item);
			$text .= $tp->parseTemplate($tpl['MENU']['RECENT']['ITEM'], true, $sc);
		}
		$text .= $tp->parseTemplate($tpl['MENU']['RECENT']['FOOTER'], true, $sc);

		if(empty($items))
		{
			$text = '<div class="text-center">' . LAN_PLUGIN_NODEJS_FORUM_FRONT_05 . '</div>';
		}

		e107::getRender()->tablerender(LAN_PLUGIN_NODEJS_FORUM_FRONT_04, $text);
		unset($text);
	}


	/**
	 * Get latest forum posts.
	 *
	 * @return array $posts
	 *  Array contains latest forum posts. The first item is the newest post. Empty array if no post.
	 */
	function getLatestForumPosts()
	{
		include_once(e_PLUGIN . 'forum/forum_class.php');

		$posts = array();

		$db = e107::getDb();

		$forum = new e107forum;
		$forumList = implode(',', $forum->getForumPermList('view'));
		$limit = 10;

		$results = $db->select('forum_post', '*', 'post_forum IN (' . $forumList . ') ORDER BY post_datestamp DESC LIMIT 0, ' . $limit);

		if($results)
		{
			while($row = $db->fetch())
			{
				$thread = new e_db_mysql();
				$user = new e_db_mysql();

				$posts[] = array(
					'post'   => $row,
					'thread' => $thread->retrieve('forum_thread', '*', 'thread_id = ' . intval($row['post_thread'])),
					'author' => $user->retrieve('user', '*', 'user_id = ' . intval($row['post_user'])),
				);

				unset($thread);
				unset($user);
			}
		}

		return $posts;
	}

}


new nodejs_forum_recent_menu();
