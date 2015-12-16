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
<div class="nodejs-forum-latest-forum-posts">
';

// Template for recent forum posts menu.
$NODEJS_FORUM_TEMPLATE['MENU']['RECENT']['ITEM'] = '
	<div class="post-item">
		<div class="post-avatar pull-left hidden-xs">
			<div class="thumbnail">
				{RECENT_AUTHOR_AVATAR}
			</div>
		</div>
		<div class="post-content">
			<div class="topic-name">
				{RECENT_TOPIC_NAME}
			</div>
			<div class="meta-info">
				<small class="mark"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> {RECENT_POST_DATE} <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {RECENT_AUTHOR_NAME}</small>
			</div>
			<div class="post-preview">
				<p>{RECENT_POST_PREVIEW}</p>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
';

// Template for recent forum posts menu.
$NODEJS_FORUM_TEMPLATE['MENU']['RECENT']['FOOTER'] = '
</div>
';
