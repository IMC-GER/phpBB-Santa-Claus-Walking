<?php
/**
 *
 * Santa Claus walk. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026, Fred Rimbert, https://caforum.fr
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace caforum\santaclauswalk\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** Native size of santawalk.gif */
	const SPRITE_WIDTH  = 72;
	const SPRITE_HEIGHT = 105;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\template\template $template)
	{
		$this->auth     = $auth;
		$this->config   = $config;
		$this->template = $template;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'  => 'load_language',
			'core.page_header' => 'assign_template_vars',
		];
	}

	public function load_language($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'caforum/santaclauswalk',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Is today inside the yearly display period? Uses the board timezone.
	 * The period may span the new year (e.g. 12-01 to 01-06).
	 *
	 * @param \phpbb\config\config $config
	 * @return bool
	 */
	public static function in_period($config)
	{
		if (empty($config['santawalk_period_enabled']))
		{
			return true;
		}

		try
		{
			$tz = new \DateTimeZone($config['board_timezone'] ?: 'UTC');
		}
		catch (\Exception $e)
		{
			$tz = new \DateTimeZone('UTC');
		}

		$today = (new \DateTime('now', $tz))->format('m-d');
		$start = (string) $config['santawalk_period_start'];
		$end   = (string) $config['santawalk_period_end'];

		if ($start <= $end)
		{
			return $today >= $start && $today <= $end;
		}

		// Wraps around 31 December
		return $today >= $start || $today <= $end;
	}

	public function assign_template_vars()
	{
		$enabled   = !empty($this->config['santawalk_enabled']);
		$test_mode = !empty($this->config['santawalk_test_mode']);
		$in_period = self::in_period($this->config);

		// Test mode: only administrators see Santa, whatever the on/off switch
		// and the display period say. Regular members see nothing.
		$show = $test_mode ? (bool) $this->auth->acl_get('a_') : ($enabled && $in_period);

		if (!$show)
		{
			return;
		}

		$scale = max(25, min(300, (int) $this->config['santawalk_scale'])) / 100;
		$v_ref = ($this->config['santawalk_vpos_ref'] === 'top') ? 'top' : 'bottom';

		$this->template->assign_vars([
			'S_SANTAWALK_SHOW'          => true,
			'S_SANTAWALK_TEST'          => $test_mode,
			'S_SANTAWALK_PUBLIC_OFF'    => $test_mode && !$enabled,
			'S_SANTAWALK_OUT_OF_PERIOD' => $test_mode && !$in_period,
			'SANTAWALK_SPEED'           => max(5, (int) $this->config['santawalk_speed']),
			'SANTAWALK_PAUSE'           => max(0, (int) $this->config['santawalk_pause']),
			'SANTAWALK_MOBILE_HIDE'     => max(0, (int) $this->config['santawalk_mobile_hide']),
			'SANTAWALK_VPOS_REF'        => $v_ref,
			'SANTAWALK_VPOS_OFFSET'     => (int) $this->config['santawalk_vpos_offset'],
			'SANTAWALK_WIDTH'           => (int) round(self::SPRITE_WIDTH * $scale),
			'SANTAWALK_HEIGHT'          => (int) round(self::SPRITE_HEIGHT * $scale),
		]);
	}
}
