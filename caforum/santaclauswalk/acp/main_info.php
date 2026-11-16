<?php
/**
 *
 * Santa Claus walk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026, Fred Rimbert, https://caforum.fr
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace caforum\santaclauswalk\acp;

class main_info
{
	public function module()
	{
		return [
			'filename' => '\caforum\santaclauswalk\acp\main_module',
			'title'    => 'ACP_SANTAWALK_TITLE',
			'modes'    => [
				'settings' => [
					'title' => 'ACP_SANTAWALK_SETTINGS',
					'auth'  => 'ext_caforum/santaclauswalk && acl_a_board',
					'cat'   => ['ACP_SANTAWALK_TITLE'],
				],
			],
		];
	}
}
