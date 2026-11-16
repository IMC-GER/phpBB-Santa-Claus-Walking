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

class v210_period extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['santawalk_period_enabled']);
	}

	public static function depends_on()
	{
		return ['\caforum\santaclauswalk\migrations\install_v200'];
	}

	public function update_data()
	{
		return [
			// Display period, repeated every year, stored as MM-DD
			['config.add', ['santawalk_period_enabled', 0]],
			['config.add', ['santawalk_period_start', '12-01']],
			['config.add', ['santawalk_period_end', '01-06']],
		];
	}
}
