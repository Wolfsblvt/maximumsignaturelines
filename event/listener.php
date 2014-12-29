<?php
/**
 * 
 * Maximum Signature Lines
 * 
 * @copyright (c) 2014 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\maximumsignaturelines\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\config\config */
	protected $config;

	/**
	 * Constructor of event listener
	 *
	 * @param \phpbb\path_helper					$path_helper	phpBB path helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 * @param \phpbb\config\config					$config			Config object
	 */
	public function __construct(\phpbb\path_helper $path_helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\config\config $config)
	{
		global $phpbb_container;

		$this->path_helper = $path_helper;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;

		$this->ext_root_path = 'ext/wolfsblvt/maximumsignaturelines';

		// Add language vars
		$this->user->add_lang_ext('wolfsblvt/maximumsignaturelines', 'maximumsignaturelines');
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'					=> 'assign_template_vars',

			'core.acp_board_config_edit_add'	=> 'acp_add_limit_signature_option',
			'core.message_parser_check_message'	=> 'check_message_limit_signature_lines',
		);
	}

	/**
	 * Adds the acp option to limit signatures to the acp signature settings
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function acp_add_limit_signature_option($event)
	{
		if($event['mode'] != 'signature')
			return;

		$display_vars = $event['display_vars'];

		$modified_vars = array();
		foreach ($display_vars['vars'] as $config => $arr)
		{
			$modified_vars[$config] = $arr;

			// Add our new config option after the max sig chars
			if ($config == 'max_sig_chars')
			{
				$modified_vars['wolfsblvt.maximumsignaturelines.limit'] = array('lang' => 'MSL_LIMIT', 'validate' => 'int:0:9999', 'type' => 'number:0:9999', 'explain' => true);
			}
		}
		$display_vars['vars'] = $modified_vars;

		$event['display_vars'] = $display_vars;
	}

	/**
	 * Checks the length of the signature and throws error if not correct
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function check_message_limit_signature_lines($event)
	{
		if ($event['mode'] == 'sig')
		{
			$message_lines = count(explode("\n", $event['message']));

			// Check for line count
			if ((int) $this->config['wolfsblvt.maximumsignaturelines.limit'] > 0 && $message_lines > (int) $this->config['wolfsblvt.maximumsignaturelines.limit'])
			{
				$warn_msg = $event['warn_msg'];
				$warn_msg[] =  $this->user->lang('LINES_SIG_CONTAINS', $message_lines) . '<br />' . $this->user->lang('TOO_MANY_LINES_LIMIT', (int) $this->config['wolfsblvt.maximumsignaturelines.limit']);
				$event['warn_msg'] = $warn_msg;
				$event['return'] = true;
			}
		}
	}

	/**
	 * Assigns template vars
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function assign_template_vars()
	{
		$this->template->assign_vars(array(
			'T_EXT_LIMITSIGNATURELINES_PATH'			=> $this->path_helper->get_web_root_path() . $this->ext_root_path,
			'T_EXT_LIMITSIGNATURELINES_THEME_PATH'		=> $this->path_helper->get_web_root_path() . $this->ext_root_path . '/styles/' . $this->user->style['style_path'] . '/theme',
		));

		// If we are modifying the signature, we need to replace the language var with additional info
		if ($this->config['wolfsblvt.maximumsignaturelines.limit'] > 0)
		{
			$this->template->append_var('L_SIGNATURE_EXPLAIN', ' ' . $this->user->lang('MSL_LINES_EXPLAIN', (int) $this->config['wolfsblvt.maximumsignaturelines.limit']));
		}
	}
}
