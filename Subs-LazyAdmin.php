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
	global $sourcedir, $scripturl, $context;
	
	// Can we do ANYTHING in the admin area?  If not, skip this:
	if (!$context['allow_admin'])
		return;
	
	// Retrieve the admin area menu:
	require_once($sourcedir . '/Admin.php');
	$admin_areas = AdminMain(true);

	// Rebuild the admin menu:
	$admin = &$areas['admin'];
	unset($admin['sub_buttons']);
	foreach ($admin_areas as $alpha1 => $beta1)
	{
		// Build first level menu:
		$admin['sub_buttons'][$alpha1] = array(
			'title' => $beta1['title'],
			'show' => $context['allow_admin'],
			'sub_buttons' => array(),
		);
		if (!empty($beta1['permission']))
			$admin['sub_buttons'][$alpha1]['show'] = allowedTo($beta1['permission']);
			
		// Build second level menus:
		$first = true;
		$last = false;
		foreach ($beta1['areas'] as $alpha2 => $beta2)
		{
			if ($alpha2 == 'search' || !empty($beta2['hidden']))
				continue;
			if ($first)
			{
				$admin['sub_buttons'][$alpha1]['href'] = $scripturl . '?action=admin;area=' . $alpha2;
				$first = false;
			}
			$admin['sub_buttons'][$alpha1]['sub_buttons'][$alpha2] = array(
				'title' => $beta2['label'],
				'href' => $scripturl . '?action=admin;area=' . $alpha2,
				'show' => $context['allow_admin']
			);
			if (!empty($beta2['permission']))
				$admin['sub_buttons'][$alpha1]['show'] = allowedTo($beta2['permission']);
			$last = $alpha2;
		}
		$admin['sub_buttons'][$alpha1]['sub_buttons'][$alpha2]['is_last'] = true;
	}
}

?>