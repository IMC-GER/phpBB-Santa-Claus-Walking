<?php
/**
 *
 * Santa Claus walk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026, Fred Rimbert, https://caforum.fr
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'SANTAWALK_TEST_LABEL'    => 'Santa Claus – test mode (visible to administrators only)',
	'SANTAWALK_TEST_PUBLIC_OFF' => 'Extension switched off for the public',
	'SANTAWALK_TEST_OUT_OF_PERIOD' => 'Outside the display period',
]);
