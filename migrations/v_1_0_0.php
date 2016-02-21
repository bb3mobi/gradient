<?php
/**
*
* @package Gradient User Name
* @copyright BB3.Mobi 2015 (c) Anvar (http://bb3.mobi)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace bb3mobi\gradient\migrations;

class v_1_0_0 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}
	/**
	* Add the getdonate table schema to the database:
	*
	* @return array Array of table schema
	* @access public
	*/
	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_colour2'	=> array('VCHAR:6', ''),
				),
			),
		);
	}
	/**
	* Drop the getdonate table schema from the database
	*
	* @return array Array of table schema
	* @access public
	*/
	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_colour2',
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			// Add permission
			array('permission.add', array('u_change_gradient', true)),

			// Set permissions
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_change_gradient')),

			// Add UCP modules
			array('module.add', array('ucp', 'UCP_PROFILE', array(
				'module_basename'	=> '\bb3mobi\gradient\ucp\gradient_module',
				'module_langname'	=> 'UCP_GRADIENT',
				'module_mode'		=> 'editor',
				'module_auth'		=> 'ext_bb3mobi/gradient && acl_u_change_gradient',
			))),
		);
	}

	public function revert_data()
	{
		return array(
			// Remove modules
			array('module.remove', array('ucp', 'UCP_PROFILE', 'UCP_GRADIENT')),
		);
	}
}
