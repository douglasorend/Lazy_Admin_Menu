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
function LazyAdmin_Verify_User()
{
	// Skip this if we are not requesting the layout of the profile CPL:
	if (isset($_GET['action']) && $_GET['action'] == 'admin' && isset($_GET['area']) && $_GET['area'] == 'lazyadmin_acp')
		return isset($_GET['u']) ? (int) $_GET['u'] : 0;
}

function LazyAdmin_Load_Theme()
{
	// This admin hook must be last hook executed!
	add_integration_function('integrate_admin_areas', 'LazyAdmin_Admin_Hook', false);
	add_integration_function('integrate_menu_buttons', 'LazyAdmin_Menu_Buttons', false);
}

function LazyAdmin_Admin_Hook(&$areas)
{
	global $scripturl, $user_info, $context;

	// Gotta prevent an infinite loop here:
	if (empty($user_info['id']) || !isset($_GET['area']) || $_GET['area'] != 'lazyadmin_acp' || empty($_GET['u']))
		return;

	// Keep from triggering the Forum Hard Hit mod:
	if (!empty($context['HHP_time']))
		unset($_SESSION['HHP_Visits'][$context['HHP_time']]);
			
	// Rebuild the admin menu:
	$cached = array();
	foreach ($areas as $id1 => $area1)
	{
		// Build first level menu:
		$cached[$id1] = array(
			'title' => $area1['title'],
			'show' => (!empty($area1['permission']) ? allowedTo($area1['permission']) : true),
			'href' => $scripturl . '?action=admin',
			'sub_buttons' => array(),
		);
		$first = $last = false;
		if (!empty($area1['custom_url']))
			$first = $cached[$id1]['href'] = $area1['custom_url'];

		// Build second level menus:
		foreach ($area1['areas'] as $id2 => $area2)
		{
			if (empty($area2['label']))
				continue;

			$link = isset($area2['custom_url']) ? $area2['custom_url'] : $scripturl . '?action=admin;area=' . $id2;
			$show = (!isset($area2['enabled']) || $area2['enabled']) && empty($area2['hidden']) && (!empty($area2['permission']) ? allowedTo($area2['permission']) : true);
			if (isset($area2['enabled']))
				$show |= $area2['enabled'];
			$cached[$id1]['sub_buttons'][$last = $id2] = array(
				'title' => $area2['label'],
				'href' => $link,
				'show' => $show,
			);
			if (!$first)
				$first = $cached[$id1]['href'] = $scripturl . '?action=admin;area=' . $id2;
		}
		$cached[$id1]['sub_buttons'][$id2]['is_last'] = true;
	}

	// Cache the admin menu array for future use:
	$func = function_exists('safe_serialize') ? 'safe_serialize' : 'serialize';
	echo $func($cached);
	exit;
}

function LazyAdmin_Menu_Buttons(&$areas)
{
	global $scripturl, $user_info, $context;

	// Gotta prevent an infinite loop here:
	if (isset($_GET['action']) && $_GET['action'] == 'admin' && isset($_GET['area']) && $_GET['area'] == 'lazyadmin_acp')
		return;

	// Are you a guest?  Then why bother with it....
	if (empty($user_info['id']) || empty($areas['admin']['show']))
		return;

	// Retrieve the admin area menu, either from cache or the Admin.php script...
	$saved = $areas['admin']['sub_buttons']['errorlog']['title'];
	if (($cached = cache_get_data('lazyadmin_' . $user_info['id'], 86400)) == null)
	{
		$contents = @file_get_contents($scripturl . '?action=admin;area=lazyadmin_acp;u=' . $user_info['id']);
		$func = function_exists('safe_unserialize') ? 'safe_unserialize' : 'unserialize';
		$cached = @$func($contents);
		cache_put_data('lazyadmin_' . $user_info['id'], $cached, 86400);
	}

	// Patch up the admin menu so everything works right:
	if (is_array($cached))
	{
		foreach ($cached as $id1 => $area1)
		{
			if (isset($cached[$id1]['href']))
				$cached[$id1]['href'] .= ';' . $context['session_var'] . '=' . $context['session_id'];
			foreach ($cached[$id1]['sub_buttons'] as $id2 => $area2)
			{
				if (isset($cached[$id1]['sub_buttons'][$id2]['href']))
					$cached[$id1]['sub_buttons'][$id2]['href'] .= ';' . $context['session_var'] . '=' . $context['session_id'];
			}
		}

		// Replace the admin menu with the cached Admin menu:
		$areas['admin']['sub_buttons'] = $cached;
	}

	// Replace the "logs" text with the "error logs" text from the original menu:
	if (isset($areas['admin']['sub_buttons']['maintenance']['sub_buttons']['logs']))
		$areas['admin']['sub_buttons']['maintenance']['sub_buttons']['logs']['title'] = $saved;

	// If the error log count mod is installed, add it to the Admin top menu:
	if (function_exists("get_error_log_count_for_menu"))
		$areas['admin']['title'] .= get_error_log_count_for_menu();
}

function LazyAdmin_CoreFeatures(&$core_features)
{
	global $cachedir;
	if (isset($_POST['save']))
		array_map('unlink', glob($cachedir . '/data_*-SMF-lazyadmin_*'));
}

?>