<?php

/**
 * @file
 * Class instantiation to prepare JavaScript configurations and include css/js
 * files to page header.
 */

if(!defined('e107_INIT'))
{
	exit;
}


/**
 * Class nodejs_forum_e_header.
 */
class nodejs_forum_e_header
{

	/**
	 * Store forum plugin preferences.
	 *
	 * @var array
	 */
	private $plugPrefs = array();


	/**
	 * Store default values of extended user fields are set by current user.
	 *
	 * @var array
	 */
	private $defaultValues = array();


	/**
	 * Constructor.
	 */
	function __construct()
	{
		// Include necessary CSS and JS files regardless of whether the current user is logged in, or not.
		$this->includePublicComponents();

		if(USERID > 0)
		{
			$db = e107::getDb();
			// Plugin preferences.
			$this->plugPrefs = e107::getPlugConfig('nodejs_forum')->getPref();
			// Extended User Fields values by current, logged in user.
			$this->defaultValues = $db->retrieve('user_extended', '*', 'user_extended_id = ' . USERID);

			// Include necessary CSS and JS files only for logged in user.
			$this->includePrivateComponents();
		}
	}


	/**
	 * Include necessary CSS and JS files.
	 */
	function includePublicComponents()
	{
		e107::css('nodejs_forum', 'css/nodejs_forum.css');
		e107::js('footer', '{e_PLUGIN}nodejs_forum/js/nodejs_forum.menu.js', 'jquery', 5);
	}


	/**
	 * Include necessary CSS and JS files.
	 */
	function includePrivateComponents()
	{
		$eufPrefix = 'user_plugin_nodejs_forum_';
		$defs = $this->defaultValues;

		// User defined settings.
		$alert_new_post_any = isset($defs[$eufPrefix . 'alert_new_post_any']) ? intval($defs[$eufPrefix . 'alert_new_post_any']) : 1;
		$sound_new_post_any = isset($defs[$eufPrefix . 'sound_new_post_any']) ? intval($defs[$eufPrefix . 'sound_new_post_any']) : 1;
		$alert_new_post_own = isset($defs[$eufPrefix . 'alert_new_post_own']) ? intval($defs[$eufPrefix . 'alert_new_post_own']) : 1;
		$sound_new_post_own = isset($defs[$eufPrefix . 'sound_new_post_own']) ? intval($defs[$eufPrefix . 'sound_new_post_own']) : 1;

		// If admin disabled it globally.
		if((int) $this->plugPrefs['disable_alerts'] === 1)
		{
			$alert_new_post_any = 0;
			$alert_new_post_own = 0;
		}

		// If admin disabled it globally.
		if((int) $this->plugPrefs['disable_sounds'] === 1)
		{
			$sound_new_post_any = 0;
			$sound_new_post_own = 0;
		}

		$js_options = array(
			'current_user'       => USERID,
			'alert_new_post_any' => (int) $alert_new_post_any,
			'sound_new_post_any' => (int) $sound_new_post_any,
			'alert_new_post_own' => (int) $alert_new_post_own,
			'sound_new_post_own' => (int) $sound_new_post_own,
		);

		e107::js('settings', array('nodejs_forum' => $js_options));
		e107::js('footer', '{e_PLUGIN}nodejs_forum/js/nodejs_forum.js', 'jquery', 5);
	}
}


// Class instantiation.
new nodejs_forum_e_header;
