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

}
