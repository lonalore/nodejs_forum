<?php

/**
 * @file
 * Templates for "nodejs_forum" plugin.
 */

// Template for popup message with type "Be notified when others reply a topic".
$NODEJS_FORUM_TEMPLATE['NOTIFICATION']['POST_ALL'] = '
<div class="nodejs-forum-notification">
  <div class="picture">
    {POST_ALL_AVATAR}
  </div>
  <div class="body">
    <span class="title">
      {POST_ALL_TITLE}
    </span>
    <div class="message">
        {POST_ALL_MESSAGE}
    </div>
    <div class="links">
      {POST_ALL_LINKS}
    </div>
  </div>
</div>
';

// Template for popup message with type "Be notified when others reply your topic".
$NODEJS_FORUM_TEMPLATE['NOTIFICATION']['POST_OWN'] = '
<div class="nodejs-forum-notification">
  <div class="picture">
    {POST_OWN_AVATAR}
  </div>
  <div class="body">
    <span class="title">
      {POST_OWN_TITLE}
    </span>
    <div class="message">
        {POST_OWN_MESSAGE}
    </div>
    <div class="links">
      {POST_OWN_LINKS}
    </div>
  </div>
</div>
';

// Template for recent forum posts menu.
$NODEJS_FORUM_TEMPLATE['MENU']['RECENT']['HEADER'] = '
<div class="container-fluid">
';

// Template for recent forum posts menu.
$NODEJS_FORUM_TEMPLATE['MENU']['RECENT']['ITEM'] = '
	<div class="row">
		<div class="col-sm-2">
			{AUTHOR_AVATAR}
		</div>
		<div class="col-sm-10">
			{TOPIC_NAME}
			<span class="glyphicon glyphicon-time" aria-hidden="true"></span> {POST_DATE} <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {AUTHOR_NAME}
			{POST_PREVIEW}
		</div>
	</div>
';

// Template for recent forum posts menu.
$NODEJS_FORUM_TEMPLATE['MENU']['RECENT']['FOOTER'] = '
</div>
';
