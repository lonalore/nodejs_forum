<?php

/**
 * @file
 * Shortcodes for "nodejs_forum" plugin.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/nodejs_forum/languages/[LANGUAGE]/[LANGUAGE]_front.php
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
		$href = e107::getUrl()->create('user/profile/view', $this->var['account']);
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
			'query'    => array(
				'p' => $this->var['topicPage'],
			),
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
		$href = e107::getUrl()->create('user/profile/view', $this->var['account']);
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
			'query'    => array(
				'p' => $this->var['topicPage'],
			),
			'fragment' => 'post-' . $post['post_id'],
		));

		return '<a href="' . $toPost . '">' . LAN_PLUGIN_NODEJS_FORUM_FRONT_01 . '</a>';
	}


	function sc_recent_author_avatar()
	{
		$tp = e107::getParser();
		$tp->thumbWidth = 50;
		$tp->thumbHeight = 50;

		return $tp->toAvatar($this->var['author']);
	}


	function sc_recent_author_name()
	{
		if(isset($this->var['post']['post_user_anon']) && $this->var['post']['post_user_anon'])
		{
			$poster = $this->var['post']['post_user_anon'];
		}
		else
		{
			if(isset($this->var['author']['user_name']))
			{
				$href = e107::getUrl()->create('user/profile/view', $this->var['author']);
				$poster = "<a href='" . $href . "'>" . $this->var['author']['user_name'] . "</a>";
			}
			else
			{
				$poster = '[deleted]';
			}
		}

		return $poster;
	}


	function sc_recent_topic_name()
	{
		$post = $this->var['post'];
		$thread = $this->var['thread'];

		$toPost = e107::url('forum', 'topic', $thread, array(
			'query'    => array(
				'p' => $this->var['topicPage'],
			),
			'fragment' => 'post-' . $post['post_id'],
		));

		return '<a href="' . $toPost . '">' . $this->var['thread']['thread_name'] . '</a>';
	}


	function sc_recent_post_date()
	{
		$format = vartrue($this->plugPrefs['asdasdsad'], 'relative');
		$date = e107::getDate();
		return $date->convert_date(vartrue($this->var['post']['post_datestamp'], 0), $format);
	}


	function sc_recent_post_preview()
	{
		$tp = e107::getParser();

		$entry = vartrue($this->var['post']['post_entry'], '');

		$post = $tp->toHTML($entry, true, 'emotes_off, no_make_clickable', '', false);
		$post = strip_tags($post);
		$post = $tp->text_truncate($post, 100, '...');

		return $post;
	}

}
