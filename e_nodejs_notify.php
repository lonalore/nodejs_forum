<?php

/**
 * @file
 * Describes Extended User Fields to display them on the global notification settings
 * form of nodejs_notify plugin.
 */


/**
 * Class nodejs_forum_nodejs_notify.
 */
class nodejs_forum_nodejs_notify
{

	/**
	 * NodeJS Notify configuration items.
	 *
	 * @return array
	 *    The list of configuration items.
	 */
	public function configurationItems()
	{
		$items = array();

		// "Be notified when others reply a topic" item.
		$items[] = array(
			// Use global language file.
			'label'       => LAN_PLUGIN_NODEJS_FORUM_NOTIFY_CONFIG_03,
			// Extended User Field name from plugin.xml to store configuration by user.
			// plugin_nodejs_forum_alert_new_post_any
			'field_alert' => 'alert_new_post_any',
			// Extended User Field name from plugin.xml to store configuration by user.
			// plugin_nodejs_forum_sound_new_post_any
			'field_sound' => 'sound_new_post_any',
		);

		// "Be notified when others reply your topic" item.
		$items[] = array(
			// Use global language file.
			'label'       => LAN_PLUGIN_NODEJS_FORUM_NOTIFY_CONFIG_04,
			// Extended User Field name from plugin.xml to store configuration by user.
			// plugin_nodejs_forum_alert_new_post_own
			'field_alert' => 'alert_new_post_own',
			// Extended User Field name from plugin.xml to store configuration by user.
			// plugin_nodejs_forum_sound_new_post_own
			'field_sound' => 'sound_new_post_own',
		);

		return array(
			'group_title'       => LAN_PLUGIN_NODEJS_FORUM_NOTIFY_CONFIG_01,
			'group_description' => LAN_PLUGIN_NODEJS_FORUM_NOTIFY_CONFIG_02,
			'group_items'       => $items,
		);
	}

}
