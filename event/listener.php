<?php
/**
*
* @package Gradient User Name
* @copyright BB3.Mobi 2015 (c) Anvar (http://bb3.mobi)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace bb3mobi\gradient\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_cache_user_data'	=> 'viewtopic_username_gradient',
			'core.memberlist_team_modify_query'		=> 'team_username_gradient_sql',
			'core.memberlist_team_modify_template_vars'	=> 'team_username_gradient',
		);
	}

	/** Viewtopic Gradient User Name */
	public function viewtopic_username_gradient($event)
	{
		$row = $event['row'];
		if (!$row['user_colour'] || empty($row['user_colour2']) || ($row['user_colour'] == $row['user_colour2']))
		{
			return;
		}

		$username = $this->username_gradient($row['username'], $row['user_colour'], $row['user_colour2']);

		$user_cache_data = $event['user_cache_data'];
		$user_cache_data = array_merge($user_cache_data, array(
			'author_full' => get_username_string('full', $event['poster_id'], $username, $row['user_colour']),
		));
		$event['user_cache_data'] = $user_cache_data;
	}

	/** Team Gradient User Name SQL */
	public function team_username_gradient_sql($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', u.user_colour2';
		$event['sql_ary'] = $sql_ary;
	}

	/** Team Gradient User Name */
	public function team_username_gradient($event)
	{
		$row = $event['row'];
		if (!$row['user_colour'] || empty($row['user_colour2']) || ($row['user_colour'] == $row['user_colour2']))
		{
			return;
		}

		$username = $this->username_gradient($row['username'], $row['user_colour'], $row['user_colour2']);

		$template_vars = $event['template_vars'];
		$template_vars['USERNAME_FULL'] = get_username_string('full', $row['user_id'], $username, $row['user_colour']);
		$event['template_vars'] = $template_vars;
	}

	/** Gradient User Name */
	private function username_gradient($text, $hexfrom, $hexto)
	{
		$lenght = mb_strlen($text);
		$fromrgb = array_map('hexdec', str_split(ltrim(strtoupper($hexfrom), '#'), 2));
		$torgb = array_map('hexdec', str_split(ltrim(strtoupper($hexto), '#'), 2));

		$steprgb = array();
		for($i = 0; $i < 3; $i++)
		{
			$steprgb[$i] = floor(($fromrgb[$i] - $torgb[$i]) / ($lenght));
		}

		$username = '';
		for ($i = 0; $i <= $lenght; $i++)
		{
			if ($i < 1)
			{
				continue;
			}

			for($j = 0; $j < 3; $j++)
			{
				$hexrgb[$j] = $fromrgb[$j] - ($steprgb[$j] * $i);
				if ($hexrgb[$j] > 255)
				{
					$hexrgb[$j] = 255;
				}
				$hexrgb[$j] = dechex($hexrgb[$j]);
				$hexrgb[$j] = strtoupper($hexrgb[$j]);

				if (strlen($hexrgb[$j]) < 2)
				{
					$hexrgb[$j] = "0$hexrgb[$j]";
				}
			}
			$color = implode(null, $hexrgb);
			$username .= '<span style="color: #' . $color . ';">' . mb_substr($text, $i-1, 1) . '</span>';
		}
		return $username;
	}
}
