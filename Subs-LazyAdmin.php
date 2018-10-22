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
function LazyAdmin_Menu_Buttons(&$areas)
{
	global $sourcedir, $scripturl, $context, $user_info, $modSettings, $txt;
	
	// Can we do ANYTHING in the admin area?  If not, skip this:
	if (!$context['allow_admin'])
		return;
	$admin = &$areas['admin'];
	$saved = $admin['sub_buttons']['errorlog']['title'];

	// Retrieve the admin area menu, either from cache or the Admin.php script...
	if (($admin['sub_buttons'] = cache_get_data('admin_menu19_' . $user_info['id'], 86400)) == null)
	{
		require_once($sourcedir . '/Admin.php');
		$old_txt = $txt;
		$already_loaded = loadLanguage('', '', false, false, true);
		if (function_exists("sp_languageSelect"))
			loadLanguage('SPortalAdmin', sp_languageSelect('SPortalAdmin'));
		$admin_areas = AdminMain(true);
		loadLanguage('', '', false, false, $already_loaded);
		$txt = $old_txt;
		unset($old_txt);

		// Rebuild the admin menu:
		unset($admin['sub_buttons']);
		foreach ($admin_areas as $id1 => $area1)
		{
			// Build first level menu:
			$admin['sub_buttons'][$id1] = array(
				'title' => $area1['title'],
				'show' => $context['allow_admin'],
				'sub_buttons' => array(),
			);
			if (!empty($area1['permission']))
				$admin['sub_buttons'][$id1]['show'] = allowedTo($area1['permission']);
				
			// Build second level menus:
			$first = true;
			if (isset($area1['custom_url']) && !empty($area1['custom_url']))
			{
				$admin['sub_buttons'][$id1]['href'] = $area1['custom_url'];
				$first = false;
			}
			$last = false;
			foreach ($area1['areas'] as $id2 => $area2)
			{
				if ($id2 == 'search' || !empty($area2['hidden']) || (isset($area2['enabled']) && !$area2['enabled']))
					continue;
				if ($first)
				{
					$admin['sub_buttons'][$id1]['href'] = $scripturl . '?action=admin;area=' . $id2;
					$first = false;
				}
				$admin['sub_buttons'][$id1]['sub_buttons'][$id2] = array(
					'title' => $area2['label'],
					'href' => $scripturl . '?action=admin;area=' . $id2,
					'show' => $context['allow_admin'],
				);
				if (!empty($area2['permission']))
					$admin['sub_buttons'][$id1]['show'] = allowedTo($area2['permission']);
				$last = $id2;
			}
			$admin['sub_buttons'][$id1]['sub_buttons'][$id2]['is_last'] = true;
		}

		// Cache the admin menu array for future use:
		if (!empty($modSettings['cache_enable']))
			cache_put_data('admin_menu19_' . $user_info['id'], $admin['sub_buttons'], 86400);
	}

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