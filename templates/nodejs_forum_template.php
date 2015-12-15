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
