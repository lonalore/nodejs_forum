<?php

/**
 * @file
 * Shortcodes for "nodejs_forum" plugin.
 */

if(!defined('e107_INIT'))
{
	exit;
}

e107::lan('nodejs_forum', false, true);


/**
 * Class nodejs_forum_shortcodes.
 */
class nodejs_forum_shortcodes extends e_shortcode
{

	private $plugPrefs = array();


	function __construct()
	{
		parent::__construct();
		$this->plugPrefs = e107::getPlugConfig('nodejs_forum')->getPref();
	}


	function sc_post_all_avatar()
	{
		$tp = e107::getParser();
		$tp->thumbWidth = 50;
		$tp->thumbHeight = 50;

		return $tp->toAvatar($this->var['account']);
	}


	function sc_post_all_title()
	{
		$href = e107::url('user/profile/view', $this->var['account']);
		return '<a href="' . $href . '">' . $this->var['account']['user_name'] . '</a>';
	}


	function sc_post_all_message()
	{
		$author = $this->var['account'];
		$thread = $this->var['thread'];

		$search = array('[x]', '[y]');
		$replace = array($author['user_name'], $thread['thread_name']);

		return str_replace($search, $replace, LAN_PLUGIN_NODEJS_FORUM_FRONT_02);
	}


	function sc_post_all_links()
	{
		$post = $this->var['post'];
		$thread = $this->var['thread'];

		$toPost = e107::url('forum', 'topic', $thread, array(
			'fragment' => 'post-' . $post['post_id'],
		));

		return '<a href="' . $toPost . '">' . LAN_PLUGIN_NODEJS_FORUM_FRONT_01 . '</a>';
	}


	function sc_post_own_avatar()
	{
		$tp = e107::getParser();
		$tp->thumbWidth = 50;
		$tp->thumbHeight = 50;

		return $tp->toAvatar($this->var['account']);
	}


	function sc_post_own_title()
	{
		$href = e107::url('user/profile/view', $this->var['account']);
		return '<a href="' . $href . '">' . $this->var['account']['user_name'] . '</a>';
	}


	function sc_post_own_message()
	{
		$author = $this->var['account'];
		$thread = $this->var['thread'];

		$search = array('[x]', '[y]');
		$replace = array($author['user_name'], $thread['thread_name']);

		return str_replace($search, $replace, LAN_PLUGIN_NODEJS_FORUM_FRONT_03);
	}


	function sc_post_own_links()
	{
		$post = $this->var['post'];
		$thread = $this->var['thread'];

		$toPost = e107::url('forum', 'topic', $thread, array(
			'fragment' => 'post-' . $post['post_id'],
		));

		return '<a href="' . $toPost . '">' . LAN_PLUGIN_NODEJS_FORUM_FRONT_01 . '</a>';
	}

}
