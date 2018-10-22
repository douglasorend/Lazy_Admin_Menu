<?php
/**********************************************************************************
* Subs-LazyAdmin.php - Subs of the Lazy Admin Menu mod
*********************************************************************************
* This program is distributed in the hope that it is and will be useful, but
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY
* or FITNESS FOR A PARTICULAR PURPOSE, 
**********************************************************************************/
if (!defined('SMF')) 
	die('Hacking attempt...');
	
/**********************************************************************************
* Lazy Admin Menu hook
**********************************************************************************/
function LazyAdmin_Load_Theme()
{
	// This admin hook must be last hook executed!
	if (isset($_GET['action'], $_GET['area']) && $_GET['action'] == 'admin' && $_GET['area'] == 'lazyadmin_acp')
		add_integration_function('integrate_admin_areas', 'LazyAdmin_Admin_Hook', false);
	else
		add_integration_function('integrate_menu_buttons', 'LazyAdmin_Menu_Buttons', false);
}

function LazyAdmin_Admin_Hook(&$areas)
{
	echo var_export($areas);
	exit;
}

function LazyAdmin_Menu_Buttons(&$areas)
{
	global $sourcedir, $scripturl, $context, $user_info, $modSettings, $txt;
	
	// Retrieve the admin area menu, either from cache or the Admin.php script...
	$admin = &$areas['admin'];
	$saved = $admin['sub_buttons']['errorlog']['title'];
	if (($cached = cache_get_data('lazyadmin_' . $user_info['id'], 86400)) == null)
	{
		// Get the current admin menu.  Failure to do so means aborting the menu!
		$contents = @file_get_contents($scripturl . '?action=admin;area=lazyadmin_acp;' . $context['session_var'] . '=' . $context['session_id']);
		if (substr($contents, 0, 7) != 'array (')
		{
			if (!empty($modSettings['cache_enable']))
				cache_put_data('lazyadmin_' . $user_info['id'], 1, 86400);			
			return;
		}
		$convert_to_array = create_function('', 'return ' . $contents . ';');
		$admin_areas = $convert_to_array();
		if (!is_array($admin_areas))
		{
			if (!empty($modSettings['cache_enable']))
				cache_put_data('lazyadmin_' . $user_info['id'], 1, 86400);			
			return;
		}

		// Rebuild the admin menu:
		$cached = array();
		foreach ($admin_areas as $id1 => $area1)
		{
			// Build first level menu:
			$cached[$id1] = array(
				'title' => $area1['title'],
				'show' => $context['allow_admin'],
				'sub_buttons' => array(),
			);
			if (!empty($area1['permission']))
				$cached[$id1]['show'] = allowedTo($area1['permission']);
				
			// Build second level menus:
			$first = true;
			if (isset($area1['custom_url']) && !empty($area1['custom_url']))
			{
				$cached[$id1]['href'] = $area1['custom_url'];
				$first = false;
			}
			$last = false;
			foreach ($area1['areas'] as $id2 => $area2)
			{
				if ($id2 == 'search' || !empty($area2['hidden']) || (isset($area2['enabled']) && !$area2['enabled']))
					continue;
				if ($first)
				{
					$cached[$id1]['href'] = $scripturl . '?action=admin;area=' . $id2;
					$first = false;
				}
				$cached[$id1]['sub_buttons'][$id2] = array(
					'title' => $area2['label'],
					'href' => $scripturl . '?action=admin;area=' . $id2,
					'show' => false,
				);
				if (!empty($area2['permission']))
					$cached[$id1]['show'] = allowedTo($area2['permission']);
				$last = $id2;
			}
			$cached[$id1]['sub_buttons'][$id2]['is_last'] = true;
		}

		// Cache the admin menu array for future use:
		if (!empty($modSettings['cache_enable']))
			cache_put_data('lazyadmin_' . $user_info['id'], $cached, 86400);
		$admin['sub_buttons'] = $cached;
	}
	elseif (is_array($cached))
		$admin['sub_buttons'] = $cached;		

	// Patch up the admin menu so everything works right:
	foreach ($admin['sub_buttons'] as $id1 => $area1)
	{
		if (isset($admin['sub_buttons'][$id1]['href']))
			$admin['sub_buttons'][$id1]['href'] .= ';' . $context['session_var'] . '=' . $context['session_id'];
		foreach ($admin['sub_buttons'][$id1]['sub_buttons'] as $id2 => $area2)
		{
			if (isset($admin['sub_buttons'][$id1]['sub_buttons'][$id2]['href']))
				$admin['sub_buttons'][$id1]['sub_buttons'][$id2]['href'] .= ';' . $context['session_var'] . '=' . $context['session_id'];
		}
	}

	// Replace the "logs" text with the "error logs" text from the original menu:
	if (isset($admin['sub_buttons']['maintenance']['sub_buttons']['logs']))
		$admin['sub_buttons']['maintenance']['sub_buttons']['logs']['title'] = $saved;
		
	// If the error log count mod is installed, add it to the Admin top menu:
	if (function_exists("get_error_log_count_for_menu"))
		$admin['title'] .= get_error_log_count_for_menu();
}

?>