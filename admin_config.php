<?php

/**
 * @file
 * Class installations to handle configuration forms on Admin UI.
 */

require_once('../../class2.php');

if(!getperms('P'))
{
	header('location:' . e_BASE . 'index.php');
	exit;
}

// [PLUGINS]/nodejs_forum/languages/[LANGUAGE]/[LANGUAGE]_admin.php
e107::lan('nodejs_forum', true, true);


/**
 * Class nodejs_forum_admin.
 */
class nodejs_forum_admin extends e_admin_dispatcher
{

	protected $modes = array(
		'main' => array(
			'controller' => 'nodejs_forum_admin_ui',
			'path'       => null,
		),
	);

	protected $adminMenu = array(
		'main/prefs' => array(
			'caption' => LAN_PLUGIN_NODEJS_FORUM_ADMIN_01,
			'perm'    => 'P',
		),
	);

	protected $menuTitle = LAN_PLUGIN_NODEJS_FORUM_NAME;

}


/**
 * Class nodejs_forum_admin_ui.
 */
class nodejs_forum_admin_ui extends e_admin_ui
{

	protected $pluginTitle = LAN_PLUGIN_NODEJS_FORUM_NAME;
	protected $pluginName  = "nodejs_forum";
	protected $preftabs    = array(
		LAN_PLUGIN_NODEJS_FORUM_ADMIN_01,
	);
	protected $prefs       = array(
		'disable_alerts' => array(
			'title'      => LAN_PLUGIN_NODEJS_FORUM_ADMIN_02,
			'type'       => 'boolean',
			'writeParms' => 'label=yesno',
			'data'       => 'int',
			'tab'        => 0,
		),
		'disable_sounds' => array(
			'title'      => LAN_PLUGIN_NODEJS_FORUM_ADMIN_03,
			'type'       => 'boolean',
			'writeParms' => 'label=yesno',
			'data'       => 'int',
			'tab'        => 0,
		),
	);
}


new nodejs_forum_admin();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();
require_once(e_ADMIN . "footer.php");
exit;
