<?php
/**
*
* @package Gradient User Name
* @copyright BB3.Mobi 2015 (c) Anvar (http://bb3.mobi)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace bb3mobi\gradient\ucp;

class gradient_info
{
	function module()
	{
		return array(
			'filename'	=> '\bb3mobi\gradient\ucp\gradient_module',
			'title'		=> 'UCP_PROFILE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'editor'	=> array(
					'title' => 'UCP_GRADIENT',
					'auth' => 'ext_bb3mobi/gradient && acl_u_change_gradient',
					'cat' => array('UCP_PROFILE')
				),
			),
		);
	}
}
