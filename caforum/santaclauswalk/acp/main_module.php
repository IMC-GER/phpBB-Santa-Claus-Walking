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

use caforum\santaclauswalk\event\main_listener;

class main_module
{
	const EXT_NAME = 'caforum/santaclauswalk';

	const URL_DONATE  = 'https://forums.caforum.fr/donate';
	const URL_MEMBER  = 'https://forums.caforum.fr/accueil.php';
	const URL_SUPPORT = 'https://forums.caforum.fr/support-et-discussions-phpbb-f3';

	/** @var string */
	public $u_action;

	/** @var string */
	public $tpl_name;

	/** @var string */
	public $page_title;

	/**
	 * Integer settings: config key => [min, max]
	 */
	protected $int_settings = [
		'santawalk_speed'       => [5, 1000],
		'santawalk_scale'       => [25, 300],
		'santawalk_vpos_offset' => [-500, 500],
		'santawalk_pause'       => [0, 600],
		'santawalk_mobile_hide' => [0, 3000],
	];

	/** Month keys of the core "datetime" language array */
	protected $month_keys = [
		1 => 'January', 'February', 'March', 'April', 'May', 'June',
		'July', 'August', 'September', 'October', 'November', 'December',
	];

	public function main($id, $mode)
	{
		global $phpbb_container, $phpbb_root_path;

		/** @var \phpbb\config\config $config */
		$config   = $phpbb_container->get('config');
		/** @var \phpbb\request\request $request */
		$request  = $phpbb_container->get('request');
		/** @var \phpbb\template\template $template */
		$template = $phpbb_container->get('template');
		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');
		/** @var \phpbb\log\log $log */
		$log      = $phpbb_container->get('log');
		/** @var \phpbb\user $user */
		$user     = $phpbb_container->get('user');

		$this->tpl_name   = 'acp_santaclauswalk';
		$this->page_title = $language->lang('ACP_SANTAWALK_TITLE');

		$form_key = 'caforum_santaclauswalk';
		add_form_key($form_key);

		$errors = [];

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				$errors[] = $language->lang('FORM_INVALID');
			}

			$values = [
				'santawalk_enabled'        => $request->variable('santawalk_enabled', 0) ? 1 : 0,
				'santawalk_test_mode'      => $request->variable('santawalk_test_mode', 0) ? 1 : 0,
				'santawalk_vpos_ref'       => ($request->variable('santawalk_vpos_ref', 'bottom') === 'top') ? 'top' : 'bottom',
				'santawalk_period_enabled' => $request->variable('santawalk_period_enabled', 0) ? 1 : 0,
			];

			foreach ($this->int_settings as $key => $range)
			{
				$value = $request->variable($key, (int) $config[$key]);

				if ($value < $range[0] || $value > $range[1])
				{
					$errors[] = $language->lang('ACP_SANTAWALK_ERR_RANGE', $language->lang(strtoupper($key)), $range[0], $range[1]);
				}

				$values[$key] = $value;
			}

			foreach (['start', 'end'] as $bound)
			{
				$day   = $request->variable('santawalk_period_' . $bound . '_day', 1);
				$month = $request->variable('santawalk_period_' . $bound . '_month', 1);

				// Year 2000 is a leap year, so 29 February is accepted.
				if (!checkdate($month, $day, 2000))
				{
					$errors[] = $language->lang('ACP_SANTAWALK_ERR_DATE', $language->lang('SANTAWALK_PERIOD_' . strtoupper($bound)));
				}

				$values['santawalk_period_' . $bound] = sprintf('%02d-%02d', $month, $day);
			}

			if (empty($errors))
			{
				foreach ($values as $key => $value)
				{
					$config->set($key, $value);
				}

				$log->add('admin', $user->data['user_id'], $user->ip, 'LOG_SANTAWALK_SETTINGS');

				trigger_error($language->lang('ACP_SANTAWALK_SAVED') . adm_back_link($this->u_action));
			}

			// Redisplay what the admin typed so nothing is lost on error
			$current = $values;
		}
		else
		{
			$current = [];
			$keys = array_merge(
				['santawalk_enabled', 'santawalk_test_mode', 'santawalk_vpos_ref', 'santawalk_period_enabled', 'santawalk_period_start', 'santawalk_period_end'],
				array_keys($this->int_settings)
			);
			foreach ($keys as $key)
			{
				$current[$key] = $config[$key];
			}
		}

		$template_vars = [
			'S_ERROR'          => !empty($errors),
			'ERROR_MSG'        => implode('<br>', $errors),
			'U_ACTION'         => $this->u_action,
			'U_BOARD'          => append_sid($phpbb_root_path . 'index.php'),
			'SANTAWALK_IMG'    => $phpbb_root_path . 'ext/caforum/santaclauswalk/styles/all/theme/images/santawalk.gif',

			'SANTAWALK_EXT_VERSION' => $this->get_version($phpbb_root_path),
			'U_SANTAWALK_DONATE'    => self::URL_DONATE,
			'U_SANTAWALK_MEMBER'    => self::URL_MEMBER,
			'U_SANTAWALK_SUPPORT'   => self::URL_SUPPORT,

			'S_SANTAWALK_ENABLED'        => (bool) $current['santawalk_enabled'],
			'S_SANTAWALK_TEST_MODE'      => (bool) $current['santawalk_test_mode'],
			'S_SANTAWALK_PERIOD_ENABLED' => (bool) $current['santawalk_period_enabled'],
			'S_SANTAWALK_IN_PERIOD'      => main_listener::in_period($config),
			'SANTAWALK_VPOS_REF'         => $current['santawalk_vpos_ref'],
			'SANTAWALK_TODAY'            => $this->today($config),
		];

		foreach ($this->int_settings as $key => $range)
		{
			$template_vars[strtoupper($key)] = (int) $current[$key];
			$template_vars[strtoupper($key) . '_MIN'] = $range[0];
			$template_vars[strtoupper($key) . '_MAX'] = $range[1];
		}

		$template->assign_vars($template_vars);

		// Day / month drop-downs for the period
		$months = $language->lang_raw('datetime');
		foreach (['start', 'end'] as $bound)
		{
			list($sel_month, $sel_day) = array_map('intval', explode('-', $current['santawalk_period_' . $bound] . '-'));
			$block = 'santawalk_' . $bound;

			for ($d = 1; $d <= 31; $d++)
			{
				$template->assign_block_vars($block . '_days', [
					'VALUE'      => $d,
					'S_SELECTED' => $d === $sel_day,
				]);
			}

			foreach ($this->month_keys as $m => $month_key)
			{
				$template->assign_block_vars($block . '_months', [
					'VALUE'      => $m,
					'NAME'       => (is_array($months) && isset($months[$month_key])) ? $months[$month_key] : $m,
					'S_SELECTED' => $m === $sel_month,
				]);
			}
		}
	}

	/**
	 * Extension version, read from composer.json.
	 *
	 * @param string $phpbb_root_path
	 * @return string
	 */
	protected function get_version($phpbb_root_path)
	{
		$file = $phpbb_root_path . 'ext/' . self::EXT_NAME . '/composer.json';
		$json = is_readable($file) ? json_decode(file_get_contents($file), true) : null;

		return isset($json['version']) ? $json['version'] : '';
	}

	/**
	 * Today's date in the board timezone, as dd/mm.
	 *
	 * @param \phpbb\config\config $config
	 * @return string
	 */
	protected function today($config)
	{
		try
		{
			$tz = new \DateTimeZone($config['board_timezone'] ?: 'UTC');
		}
		catch (\Exception $e)
		{
			$tz = new \DateTimeZone('UTC');
		}

		return (new \DateTime('now', $tz))->format('d/m');
	}
}
