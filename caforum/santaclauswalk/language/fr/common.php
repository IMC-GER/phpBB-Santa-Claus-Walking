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
	'SANTAWALK_TEST_LABEL'    => 'Père Noël – mode test (visible uniquement par les administrateurs)',
	'SANTAWALK_TEST_PUBLIC_OFF' => 'Extension désactivée pour le public',
	'SANTAWALK_TEST_OUT_OF_PERIOD' => 'Hors période d’affichage',
]);
