[hr]
[center][color=red][size=16pt][b]LAZY ADMIN MENU v1.13[/b][/size][/color]
[url=http://www.simplemachines.org/community/index.php?action=profile;u=253913][b]By Dougiefresh[/b][/url] -> [url=http://custom.simplemachines.org/mods/index.php?mod=3901]Link to Mod[/url]
[/center]
[hr]

[color=blue][b][size=12pt][u]Introduction[/u][/size][/b][/color]
This mod was inspired by tip provided by [url=http://www.simplemachines.org/community/index.php?action=profile;u=152526]snow[/url] in [url=http://www.simplemachines.org/community/index.php?topic=400767.msg2785613#msg2785613]Lazy Admin Menu[/url] in order to make it easier for the admin to navigate straight to where they want to go.

The only difference is that this mod built dynamically, so that any changes to the admin menu are shown immediately.

[color=blue][b][size=12pt][u]Admin Settings[/u][/size][/b][/color]
There are no admin settings to this mod.  To disable, you must uninstall this mod.

[color=blue][b][size=12pt][u]Related Discussions[/u][/size][/b][/color]
o [url=http://www.simplemachines.org/community/index.php?topic=400767][TIP] Lazy Admin Menu[/url]

[color=blue][b][size=12pt][u]Compatibility Notes[/u][/size][/b][/color]
This mod was tested on [b]SMF 2.0.8[/b], but should work on SMF 2.0 and up.  SMF 1.1 is not and will not be supported, so please don't ask.

[url=http://custom.simplemachines.org/mods/index.php?mod=2441]Error Log Counter[/url] mod can be installed at any time.

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
[quote]
[b][u]v1.13 - January 6th, 2014[/u][/b]
o Added code to deal with already loaded strings in a lot of unrelated mods....

[b][u]v1.12 - November 12th, 2014[/u][/b]
o Removed SimplePortal changes in favor of loading language files via [b]Subs-LazyAdmin.php[/b]...
o Added support for [url=http://custom.simplemachines.org/mods/index.php?mod=2441]Error Log Counter[/url] mod so that number of errors show up in the top menu.
o Added code to preserve language strings in the event there is a conflict between two strings....

[b][u]v1.11 - October 6th, 2014[/u][/b]
o Added some code to [b]Subs.php[/b] to prevent screwing up forum during uninstallation of mod.
o Upgrade possible from v1.10 to v1.11 since uninstalling mod screws up the forum.
o Added code for 2-second cache to the admin area to prevent double code execution...

[b][u]v1.10 - October 5th, 2014[/u][/b]
o Modified SimplePortal so that the language file will hopefully be loaded if the user can adminstrate anything...
o Moved Lazy Admin Menu hook to [b]Subs.php[/b] to make sure additions made after it show up.

[b][u]v1.9 - October 4th, 2014[/u][/b]
o Changed caching code from caching entire admin menu to only the sub_buttons of the admin menu.

[b][u]v1.8 - September 8th, 2014[/u][/b]
o Bug fix for v1.7 did not include globalized variable $user_info within function.

[b][u]v1.7 - September 7th, 2014[/u][/b]
o Modified Simple Portal language loading code so that it is loaded for mods and global mods.  Thanks, [url=http://www.simplemachines.org/community/index.php?action=profile;u=322341]NekoJonez[/url]!

[b][u]v1.6 - August 21th, 2014[/u][/b]
o Reverted some code back to v1.1 that detects whether Admin menu should be modified.

[b][u]v1.5 - August 17th, 2014[/u][/b]
o Forced loading of Simple Portal language file if logged in user is an admin

[b][u]v1.4 - August 2nd, 2014[/u][/b]
o Corrected some bad caching code in [b]Admin.php[/b]....
o Reverted some code back to allow admin top menu to be rebuilt while in the Admin area

[b][u]v1.3 - August 1st, 2014[/u][/b]
o Edited Simple Portal subs file to force loading of the language file....

[b][u]v1.2 - August 1st, 2014[/u][/b]
o Custom URLs in admin menu are now represented in the top menu...
o Admin top menu will not be rebuilt while you are in the Admin area.
o Moved caching code to [b]Subs-LazyAdmin.php[/b] to speed up admin menu replacement...
o Modified code to preserve error log text from original menu...
o Session ID information attached to the end of each link so all links work properly
o Fixed issue where a certain feature wasn't enabled, but was shown anyways...
o Extended caching time on admin area menu from 2 minutes to 1 day...
o Fixed undeclared variable issue when using SSI.php...
o Removed one operation that caused multiple errors with Simple Portal....

[b][u]v1.1 - July 21th, 2014[/u][/b]
o Reduced the potential need to load so many files by caching the admin area menu.
o [b]Subs-LazyAdmin.php[/b] uses the cached version of admin area menu when possible.

[b][u]v1.0 - July 20th, 2014[/u][/b]
o Initial Release of the mod
[/quote]

[hr]
[url=http://creativecommons.org/licenses/by/3.0][img]http://i.creativecommons.org/l/by/3.0/80x15.png[/img][/url]
This work is licensed under a [url=http://creativecommons.org/licenses/by/3.0]Creative Commons Attribution 3.0 Unported License[/url]
