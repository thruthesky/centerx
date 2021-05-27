<?php
/**
 * @size icon
 * @option UserTaxonomy 'user'
 */
$o = getWidgetOptions();
$user = $o['user'] ?? user();

include widget('avatar/avatar', ['photoUrl' => $user->photoUrl, 'size' => $o['size'] ?? null]);

