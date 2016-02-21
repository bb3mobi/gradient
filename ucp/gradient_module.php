<?php
/**
*
* @package Gradient User Name
* @copyright BB3.Mobi 2015 (c) Anvar (http://bb3.mobi)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace bb3mobi\gradient\ucp;

class gradient_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $user, $request, $template, $db;

		$error = array();

		$submit		= ($request->is_set_post('submit')) ? true : false;
		$preview	= ($request->is_set_post('preview')) ? true : false;

		$prev_username = '';

		$colour		= $request->variable('colour', $user->data['user_colour']);
		$colour2	= $request->variable('colour2', $user->data['user_colour2']);
		if ($preview || $submit)
		{
			// Validate submitted colour value
			$colour_error = validate_data(array('colour' => $colour, 'colour2' => $colour2), array(
				'colour'	=> array('hex_colour', false),
				'colour2'	=> array('hex_colour', false))
			);

			if ($colour_error)
			{
				$error[] = $user->lang['WRONG_DATA_COLOUR'];
			}

			if (!sizeof($error) && $submit)
			{
				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_colour = "' . $colour . '", user_colour2 = "' . $colour2 . '"
					WHERE user_id = ' . $user->data['user_id'];
				$db->sql_query($sql);

				meta_refresh(3, $this->u_action);
				trigger_error($user->lang['UCP_GRADIENT_USER_OK'] . '<br /><br />' . sprintf($user->lang['RETURN_PAGE'], '<a href="' . $this->u_action . '">', '</a>'));
			}

			if (!sizeof($error) && $preview)
			{
				$prev_username = $this->username_gradient($user->data['username'], $colour, $colour2);
			}
		}

		$template->assign_vars(array(
			'L_TITLE'			=> $user->lang['UCP_GRADIENT_USER'],
			'L_TITLE_EXPLAIN'	=> $user->lang['UCP_GRADIENT_USER_EXPLAIN'],
			'PREVIEW_USERNAME'	=> $prev_username,
			'COLOUR'			=> $colour,
			'COLOUR2'			=> $colour2,
			'ERROR'				=> (sizeof($error)) ? implode('<br />', $error) : '',
			'S_FORM_ACTION'		=> $this->u_action,
		));

		$this->tpl_name = 'ucp_gradient';
		$this->page_title = 'UCP_GRADIENT';
	}

	/** Gradient User Name */
	function username_gradient($text, $hexfrom, $hexto)
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
