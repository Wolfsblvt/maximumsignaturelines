<?php
/**
 * 
 * Maximum Signature Lines
 * 
 * @copyright (c) 2014 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\maximumsignaturelines\migrations;

class v1_0_1_configs extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('wolfsblvt.maximumsignaturelines.limit',	'4')),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('wolfsblvt.maximumsignaturelines.limit')),
		);
	}
}
