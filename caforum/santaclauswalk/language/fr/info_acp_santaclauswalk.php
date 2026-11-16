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
	'ACP_SANTAWALK_TITLE'    => 'Père Noël qui marche',
	'ACP_SANTAWALK_SETTINGS' => 'Réglages',
	'ACP_SANTAWALK_EXPLAIN'  => 'Fait traverser l’en-tête du forum par un père Noël animé : il marche de gauche à droite, sort complètement par la droite puis revient par la gauche, en boucle. Vitesse, position, taille et période d’affichage sont réglables.',
	'ACP_SANTAWALK_SAVED'    => 'Les réglages du père Noël ont été enregistrés.',
	'ACP_SANTAWALK_ERR_RANGE' => '« %1$s » doit être compris entre %2$d et %3$d.',

	'SANTAWALK_SUPPORT_INTRO'  => 'Si vous aimez cette extension, merci de soutenir son développement :',
	'SANTAWALK_DONATE'         => 'Faire un don',
	'SANTAWALK_BECOME_MEMBER'  => 'Devenir membre de CAForum-phpBB',
	'SANTAWALK_SUPPORT'        => 'Aide / Support',

	'ACP_SANTAWALK_PERIOD'     => 'Période d’affichage',
	'SANTAWALK_PERIOD_ENABLED' => 'Limiter à une période de l’année',
	'SANTAWALK_PERIOD_ENABLED_EXPLAIN' => 'Si « Oui », le père Noël n’apparaît qu’entre les dates ci-dessous, chaque année, puis disparaît tout seul. Si « Non », il est affiché toute l’année tant que l’extension est activée.',
	'SANTAWALK_PERIOD_START'   => 'Début de la période',
	'SANTAWALK_PERIOD_START_EXPLAIN' => 'Premier jour d’apparition (inclus).',
	'SANTAWALK_PERIOD_END'     => 'Fin de la période',
	'SANTAWALK_PERIOD_END_EXPLAIN' => 'Dernier jour d’apparition (inclus). La période peut chevaucher le nouvel an, par exemple du 1er décembre au 6 janvier.',
	'SANTAWALK_PERIOD_STATUS'  => 'État actuel',
	'SANTAWALK_PERIOD_STATUS_EXPLAIN' => 'Selon les réglages enregistrés et le fuseau horaire du forum.',
	'SANTAWALK_TODAY'          => 'Nous sommes le %s',
	'SANTAWALK_PERIOD_NONE'    => 'pas de période, affiché toute l’année',
	'SANTAWALK_PERIOD_IN'      => 'dans la période, le père Noël est affiché',
	'SANTAWALK_PERIOD_OUT'     => 'hors période, le père Noël est masqué',
	'ACP_SANTAWALK_ERR_DATE'   => '« %s » n’est pas une date valide.',

	'ACP_SANTAWALK_GENERAL'  => 'Activation',
	'SANTAWALK_ENABLED'          => 'Afficher le père Noël sur le forum',
	'SANTAWALK_ENABLED_EXPLAIN'  => 'Active ou désactive l’affichage pour tous les visiteurs.',
	'SANTAWALK_TEST_MODE'        => 'Mode test',
	'SANTAWALK_TEST_MODE_EXPLAIN' => 'Quand le mode test est actif, seuls les administrateurs voient le père Noël, même si l’affichage public est désactivé ; les autres visiteurs ne voient rien. La zone de déplacement est encadrée en pointillés rouges et un bandeau indique la position et la vitesse en direct. Pensez à le désactiver une fois les réglages terminés.',
	'SANTAWALK_TEST_WARNING'     => 'Le mode test est actif : les membres et invités ne voient pas le père Noël.',
	'SANTAWALK_VIEW_BOARD'       => 'Voir le forum',

	'ACP_SANTAWALK_MOVE'     => 'Déplacement',
	'SANTAWALK_SPEED'            => 'Vitesse de déplacement',
	'SANTAWALK_SPEED_EXPLAIN'    => 'En pixels par seconde. 60 donne une marche tranquille, 150 une marche pressée.',
	'SANTAWALK_PAUSE'            => 'Pause hors écran',
	'SANTAWALK_PAUSE_EXPLAIN'    => 'Nombre de secondes pendant lesquelles le père Noël reste invisible après être sorti à droite, avant de réapparaître à gauche. 0 = retour immédiat.',

	'ACP_SANTAWALK_POSITION' => 'Position et taille',
	'SANTAWALK_VPOS_REF'         => 'Aligner le père Noël sur',
	'SANTAWALK_VPOS_REF_EXPLAIN' => 'Bas de l’en-tête : les pieds suivent le bas de l’en-tête, quelle que soit sa hauteur (conseillé). Haut de l’en-tête : la tête est calée en haut.',
	'SANTAWALK_VPOS_BOTTOM'      => 'Bas de l’en-tête',
	'SANTAWALK_VPOS_TOP'         => 'Haut de l’en-tête',
	'SANTAWALK_VPOS_OFFSET'      => 'Décalage vertical',
	'SANTAWALK_VPOS_OFFSET_EXPLAIN' => 'En pixels, depuis le bord choisi ci-dessus. Une valeur positive rapproche le père Noël du centre de l’en-tête, une valeur négative le fait déborder.',
	'SANTAWALK_SCALE'            => 'Taille',
	'SANTAWALK_SCALE_EXPLAIN'    => 'En pourcentage de la taille d’origine (72 × 105 px). À ajuster selon la hauteur de votre en-tête.',
	'SANTAWALK_MOBILE_HIDE'      => 'Masquer sous une largeur d’écran de',
	'SANTAWALK_MOBILE_HIDE_EXPLAIN' => 'En pixels. Le père Noël est masqué sur les écrans plus étroits (mobiles). 0 = toujours affiché.',

	'SANTAWALK_PREVIEW'          => 'Aperçu',
	'SANTAWALK_PREVIEW_EXPLAIN'  => 'Simulation sur un en-tête fictif de 150 px de haut, mise à jour pendant que vous modifiez les valeurs. Pour voir le rendu réel, activez le mode test et ouvrez le forum.',

	'LOG_SANTAWALK_SETTINGS' => '<strong>Réglages du père Noël qui marche modifiés</strong>',
]);
