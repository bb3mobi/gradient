<?php
/**
*
* @package Gradient User Name [English]
* @copyright BB3.Mobi 2015 (c) Anvar (http://bb3.mobi)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'UCP_GRADIENT'				=> 'Gradient',
	'UCP_GRADIENT_USER'			=> 'User name gradient',
	'UCP_GRADIENT_USER_EXPLAIN'	=> 'Username will have a smooth transition from one color hue to another.',
	'UCP_GRADIENT_USER_PLACE'	=> 'Montage gradient',
	'UCP_GRADIENT_USER_COLOURS'	=> 'Paste html color code',
	'UCP_GRADIENT_USER_PASTE'	=> 'Copy the color code in the first field on their own',
	'UCP_GRADIENT_USER_OK'		=> 'Everything is fine. The gradient is set.',
));
