<?php
/**
 * 
 * Maximum Signature Lines [English]
 * 
 * @copyright (c) 2014 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'MAXIMUMSIGNATURELINES_EXT_NAME'		=> 'Maximum Signature Lines',

	'MSL_LINES_EXPLAIN'						=> array(
													1	=> 'There is a %d line limit.',
													2	=> 'There is a %d lines limit.',
												),
	'LINES_SIG_CONTAINS'					=> array(
													1	=> 'Your signature contains %1$d line.',
													2	=> 'Your signature contains %1$d lines.',
												),
	'TOO_MANY_LINES_LIMIT'					=> 'The maximum number of allowed lines is %1$d.',
));
