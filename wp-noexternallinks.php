<?php
if(strpos(getcwd(),'wp-content/plugins/wp-noexternallinks'))
	die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');
DEFINE(WPNEL_VERSION,'2.171');
/*
Plugin Name: WP No External Links
Plugin URI: http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/
Description: This plugin will allow you to mask all external links to internal, or to hide them. Your own posts, comments pages, authors pages... To set up, visit <a href="options-general.php?page=wp-noexternallinks/wp-noexternallinks-options.php">configuration panel</a>.
Version: 2.171
Author: Jehy
Author URI: http://jehy.ru/index.en.html
Update Server: http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/
Min WP Version: 2.6
Max WP Version: 2.9.0
*/

/*  Copyright 2008  Jehy  (email : jehy@valar.ru)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class wp_noexternallinks
{
function init_lang()
{
  if(file_exists(ABSPATH . 'wp-content/plugins/wp-noexternallinks/lang/lang.'.WPLANG.'.inc'))
    $lang='.'.WPLANG;
    include_once(ABSPATH . 'wp-content/plugins/wp-noexternallinks/lang/lang'.$lang.'.inc');
}
}
if(is_admin())
  include_once(ABSPATH . 'wp-content/plugins/wp-noexternallinks/wp-noexternallinks-options.php');
else
	include_once(ABSPATH . 'wp-content/plugins/wp-noexternallinks/wp-noexternallinks-parser.php');

?>