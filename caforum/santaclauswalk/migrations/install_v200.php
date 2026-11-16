<?php
/**
 *
 * Santa Claus walk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026, Fred Rimbert, https://caforum.fr
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace caforum\santaclauswalk\migrations;

class install_v200 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['santawalk_speed']);
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	public function update_data()
	{
		return [
			['config.add', ['santawalk_enabled', 1]],
			['config.add', ['santawalk_test_mode', 0]],
			['config.add', ['santawalk_speed', 60]],
			['config.add', ['santawalk_scale', 100]],
			['config.add', ['santawalk_vpos_ref', 'bottom']],
			['config.add', ['santawalk_vpos_offset', 0]],
			['config.add', ['santawalk_pause', 2]],
			['config.add', ['santawalk_mobile_hide', 700]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_SANTAWALK_TITLE',
			]],
			['module.add', [
				'acp',
				'ACP_SANTAWALK_TITLE',
				[
					'module_basename' => '\caforum\santaclauswalk\acp\main_module',
					'modes'           => ['settings'],
				],
			]],
		];
	}
}
