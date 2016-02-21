<?php
/**
*
* @package Gradient User Name [Russian]
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
	'UCP_GRADIENT'				=> 'Градиент',
	'UCP_GRADIENT_USER'			=> 'Градиентный "ник"',
	'UCP_GRADIENT_USER_EXPLAIN'	=> 'Имя пользователя будет иметь плавный переход оттенка от одного цвета к другому.',
	'UCP_GRADIENT_USER_PLACE'	=> 'Монтировать цвет',
	'UCP_GRADIENT_USER_COLOURS'	=> 'Введите html код цвета',
	'UCP_GRADIENT_USER_PASTE'	=> 'Скопируйте код цвета в первое поле самостоятельно',
	'UCP_GRADIENT_USER_OK'		=> 'Всё отлично. Градиент установлен.',
));
