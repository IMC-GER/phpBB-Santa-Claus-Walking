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
	'ACP_SANTAWALK_TITLE'    => 'Santa Claus walk',
	'ACP_SANTAWALK_SETTINGS' => 'Settings',
	'ACP_SANTAWALK_EXPLAIN'  => 'Makes an animated Santa Claus walk across the board header: he goes from left to right, leaves completely on the right, then comes back in from the left, endlessly. Speed, position, size and display period are adjustable.',
	'ACP_SANTAWALK_SAVED'    => 'Santa Claus settings have been saved.',
	'ACP_SANTAWALK_ERR_RANGE' => '“%1$s” must be between %2$d and %3$d.',

	'SANTAWALK_SUPPORT_INTRO'  => 'If you like this extension, please support its development:',
	'SANTAWALK_DONATE'         => 'Donate',
	'SANTAWALK_BECOME_MEMBER'  => 'Become a CAForum-phpBB member',
	'SANTAWALK_SUPPORT'        => 'Help / Support',

	'ACP_SANTAWALK_PERIOD'     => 'Display period',
	'SANTAWALK_PERIOD_ENABLED' => 'Limit to a period of the year',
	'SANTAWALK_PERIOD_ENABLED_EXPLAIN' => 'If “Yes”, Santa only shows up between the dates below, every year, then disappears on his own. If “No”, he is shown all year round while the extension is switched on.',
	'SANTAWALK_PERIOD_START'   => 'Period start',
	'SANTAWALK_PERIOD_START_EXPLAIN' => 'First day he appears (included).',
	'SANTAWALK_PERIOD_END'     => 'Period end',
	'SANTAWALK_PERIOD_END_EXPLAIN' => 'Last day he appears (included). The period may span the new year, e.g. 1 December to 6 January.',
	'SANTAWALK_PERIOD_STATUS'  => 'Current status',
	'SANTAWALK_PERIOD_STATUS_EXPLAIN' => 'Based on the saved settings and the board timezone.',
	'SANTAWALK_TODAY'          => 'Today is %s',
	'SANTAWALK_PERIOD_NONE'    => 'no period, shown all year round',
	'SANTAWALK_PERIOD_IN'      => 'within the period, Santa is shown',
	'SANTAWALK_PERIOD_OUT'     => 'outside the period, Santa is hidden',
	'ACP_SANTAWALK_ERR_DATE'   => '“%s” is not a valid date.',

	'ACP_SANTAWALK_GENERAL'  => 'Activation',
	'SANTAWALK_ENABLED'          => 'Show Santa Claus on the board',
	'SANTAWALK_ENABLED_EXPLAIN'  => 'Switches the display on or off for all visitors.',
	'SANTAWALK_TEST_MODE'        => 'Test mode',
	'SANTAWALK_TEST_MODE_EXPLAIN' => 'While test mode is on, only administrators see Santa Claus, even if public display is off; other visitors see nothing. The walking area is outlined in red dashes and a banner shows the live position and speed. Remember to switch it off when you are done.',
	'SANTAWALK_TEST_WARNING'     => 'Test mode is on: members and guests do not see Santa Claus.',
	'SANTAWALK_VIEW_BOARD'       => 'View the board',

	'ACP_SANTAWALK_MOVE'     => 'Movement',
	'SANTAWALK_SPEED'            => 'Walking speed',
	'SANTAWALK_SPEED_EXPLAIN'    => 'In pixels per second. 60 is a gentle stroll, 150 a brisk walk.',
	'SANTAWALK_PAUSE'            => 'Off-screen pause',
	'SANTAWALK_PAUSE_EXPLAIN'    => 'Seconds Santa stays hidden after leaving on the right, before coming back in on the left. 0 = straight back.',

	'ACP_SANTAWALK_POSITION' => 'Position and size',
	'SANTAWALK_VPOS_REF'         => 'Align Santa Claus with',
	'SANTAWALK_VPOS_REF_EXPLAIN' => 'Header bottom: his feet follow the bottom of the header whatever its height (recommended). Header top: his head is pinned to the top.',
	'SANTAWALK_VPOS_BOTTOM'      => 'Header bottom',
	'SANTAWALK_VPOS_TOP'         => 'Header top',
	'SANTAWALK_VPOS_OFFSET'      => 'Vertical offset',
	'SANTAWALK_VPOS_OFFSET_EXPLAIN' => 'In pixels, from the edge chosen above. A positive value moves Santa towards the middle of the header, a negative value lets him overflow.',
	'SANTAWALK_SCALE'            => 'Size',
	'SANTAWALK_SCALE_EXPLAIN'    => 'Percentage of the original size (72 × 105 px). Adjust to your header height.',
	'SANTAWALK_MOBILE_HIDE'      => 'Hide below a screen width of',
	'SANTAWALK_MOBILE_HIDE_EXPLAIN' => 'In pixels. Santa is hidden on narrower screens (mobiles). 0 = always shown.',

	'SANTAWALK_PREVIEW'          => 'Preview',
	'SANTAWALK_PREVIEW_EXPLAIN'  => 'Simulation on a mock 150 px high header, updated as you edit the values. To see the real result, switch test mode on and open the board.',

	'LOG_SANTAWALK_SETTINGS' => '<strong>Altered Santa Claus walk settings</strong>',
]);
