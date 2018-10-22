[hr]
[center][color=red][size=16pt][b]LAZY ADMIN MENU v1.2[/b][/size][/color]
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

The admin menu on the menu will not be replaced while you are in the Admin area.  The admin area code empties the admin menu cache each page load, thereby forcing the next page load to rebuilt the menu.  Not allowing the menu to be replaced while in the admin area removes this duplication of effort.

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
[b][u]v1.2 - July 21th, 2013[/u][/b]
o Custom URLs in admin menu are now represented in the top menu...
o Admin top menu will not be rebuilt while you are in the Admin area.
o Moved caching code to [b]Subs-LazyAdmin.php[/b] to speed up admin menu replacement...
o Modified code to preserve error log text from original menu...
o Session ID information attached to the end of each link so all links work properly
o Fixed issue where a certain feature wasn't enabled, but was shown anyways...
o Extended caching time on admin area menu from 2 minutes to 1 day...
o Fixed undeclared variable issue when using SSI.php...
o Removed one operation that caused multiple errors with Simple Portal....

[b][u]v1.1 - July 21th, 2013[/u][/b]
o Reduced the potential need to load so many files by caching the admin area menu.
o [b]Subs-LazyAdmin.php[/b] uses the cached version of admin area menu when possible.

[b][u]v1.0 - July 20th, 2013[/u][/b]
o Initial Release of the mod

[hr]
[url=http://creativecommons.org/licenses/by/3.0][img]http://i.creativecommons.org/l/by/3.0/80x15.png[/img][/url]
This work is licensed under a [url=http://creativecommons.org/licenses/by/3.0]Creative Commons Attribution 3.0 Unported License[/url]