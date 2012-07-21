+--------------------------------------------------------+
| Type: ...... User Field
| Name: ...... Multi Url
| Version: ... 1.01
| Author: .... Valerio Vendrame (lelebart)
| Released: .. Mar, 19th 2011
| Download: .. http://www.php-fusion.it
| Demo: ...... http://www.valeriovendrame.it/dev
| Idea: ...... Goldenhawk2011
+--------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+---------------------------------------------------------+

	/************************************************\
	
		Table of Contents
		- Description
		- Install
		- Upgrade
		- Uninstall
		- Usage
		- Changelog
		- Notes
		
	\************************************************/

+-------------+
| DESCRIPTION |
+-------------+

With this User Field, users can add more sites into profile informations.
Users can set visibility of these urls, guests aren't allowed to read links.

+---------+
| INSTALL |
+---------+

1. Upload all files and folders to your ftp site root;
2. Go to Admin -> User Administration -> User Fields and
3. just enable "Multi Url" User Fields, that's it!

+---------+
| UPGRADE |
+---------+

v1.00 -> v1.01:
  1. Go to Admin -> User Administration -> User Fields and
  2. disable "Multi Url" User Fields (NOTE: you'll lost all previus urls, sorry for that);
  3. Upload (Overwrite) all files and folders to your ftp site root;
  4. Go to Admin -> User Administration -> User Fields and
  5. just enable "Multi Url" User Fields, that's it!

+-----------+
| UNINSTALL |
+-----------+

1. Go to Admin -> User Administration -> User Fields and
2. disable "Multi Url" User Fields, then (optional)
3. delete the files used from "Multi Url" from your server:
3.1 /includes/user_fields/user_multiurl_include.php
3.2 /includes/user_fields/user_multiurl_include_var.php
3.3 /locale/English/user_fields/user_multiurl.php
3.4 as above, delete i18n-file for each installed locale:
	 move trough /locale/{YOUR_LANG}/user_fields/ and delete "user_multiurl.php" 

+-------+
| USAGE |
+-------+

1. Go to "Edit Profile", move to "Web Sites"
2. Every new line entails a different url

+-----------+
| CHANGELOG |
+-----------+

1.01 19th Mar, 2011
  - users can set visibility of urls (kudos Fangree_Craig - http://www.fangree.co.uk/)
  - new locale for visibility: $locale['uf_multi-url_visibility'] = "Visibility";
1.00 13th Mar, 2011
  - first public release

+-------+
| NOTES |
+-------+

- Only urls starting with "http://" "https://" or "www." are allowed
- Urls starting with "www." will be replaced with "http://www."
- This User Field won't override the "Site Url" one
- trimlink is used to show link on profile, and its limit is set to 50