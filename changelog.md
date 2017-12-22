
## New Features:    

#### Version 3.5.1 implemented:   
* Extending plugin with custom functions   

#### Version 3.3.2 implemented:   
* Debug mode   

#### Version 3.3 implemented:   
* Masking links with base64 (quick and no need for mysql table)   

#### Version 3.2 implemented:   
* Completely removing links from your posts (someone requested this option)   
* Masking links to text. Option for perverts.   

#### Version 3.1 implemented:  
+ Masking links with digital short codes    

#### Version 3.0 implemented:    
* Outgoing clicks stats    
* Javascript redirect with custom text and timeout    
* .po file translation (sorry, now only english and russian versions are available)    
* FULL link masking    
* No masking for registered users  

## Changelog

0.01 - First release.  
0.02 - Multilanguagal release.  
0.03 - Bugfix.  
0.04 - Activation \ Deactivation improved, optimization, localization settings now stored as options.  
0.05 - Bugfix for wrong html parsing.  
0.06 - Bugfix for email links.  
0.07 - Better work for sites wihout mod_rewrite.  
0.071 - Russian translation corrected.  
   
   
2.0 - Many significant changes, including urls and post exclusion from masking, another rewrite structure, and new options.   
2.01 - Little bugfix, for fixing errors when empty exlusions.  
2.02 - Updated to execute later then other link filters, preventing possible problems with other plugins.   
2.03 - Fixed broken exclusions list.   
2.04 - Changed default settings, removed "disable links masking".    
2.05 - Fixed internationalization, added Belarusian language.    
    
    
2.10 - Plugin was rewrited for faster performance, fixed adding targer="_blank" for internal links.    
2.11 - Removed "public" keyword in class functions definitions. Probably will be more compatible with PHP4.    
2.12 - Fully compatible with PHP4.    
2.13 - Fixed language inclusion problem which apperared in some cases.    
2.14 - Absolute  file paths used now instead of relative.    
2.15 - Fixed for some servers with setup which replaces "//" with"/".    
2.16 - Javascript links aren't broken by plugin now, thanks to [Andu](http://anduriell.es).    
2.17 - Several bugfixes for low possible case scenarios...    
2.171 - Added automatic exclusion of internal links (#smth) from masking.    
2.172 - fixed javascript error when redirects ended with ";"    
    
    
3.0.0 - Code improvements, added .po translation,clicks stats and option to mask Everything.  
3.0.1 - Fixed option update issue.   
3.0.2 - Removed test message "failed to update options" when nothing changed in options. Also, fixed issue when, if link masking was disabled for post, it was also disabled for comments.   
3.0.3 - Removed some extra info, added some error handlers, repaired broken system for flushing click stats.    
3.0.4 - Fixed when some options in checkboxes couldn't be changed.    
3.1.0 - Added masking links with digital short codes.    
3.1.1 - Improved compatibility with some shitty servers.    
3.2 - Two new options, little backslashes fix, error reporting fix.    
3.3 - Additional protect from masking links in RSS, fix for admin panel in wordpress 3.4.2, Perfomance fixes.   
3.3.1 - Hotfix for some blogs which crashed on checking if page is RSS feed, improvements for option "Mask ALL links in document" - now it doesn'n mask RSS and posts with option "don't mask links".    
3.3.2 - Imporovements for option "Mask ALL links in document", debug mode.    
3.3.3b - Exclusions list fix, possible fix for not found 'is_user_logged_in' function.    
3.3.4 - Now you can customize link view if you chose "remove links" or "turn links into text". Use CSS classes "waslinkname" and "waslinkurl" for it.
3.3.5 - Little update so that plugin won't cause harmless warning.    
3.3.6 - More output for debug mode.    
3.3.7 - Crytical update for 3.3.6.    
3.3.8 - Correct redirection links with GET parameters, sometimes damaged by wordpress output.    
3.3.9 - Updated for correct work with enabled statistics and Hyper Cache plugin.    
3.3.9.1 - Added some more debug.    
3.3.9.2 - Now debug mode does not mess up web site. Also added some text to options page.    

3.4 - Replaced direct SQL queries with WPDB interface.   
3.4.1, 3.4.2 - Fixed displaying error where there are no stats for today.   
3.4.3 - Added detection and prevention of possible spoofing attacks. See new option in plugin settings. It is enabled by default.   
3.4.4 - Added exclusion for polugin from WP Super Cache.   
3.4.5 - Added option to disable links masking when link is made by admin and has **rel="follow"** attribute   
3.5 - Redesigned user friendly admin area!   
3.5.1 - Added option for developers - now you can extend plugin with custom parsing functions! Just rename "custom-parser.sample.php" to "custom-parser.php" and extend the class (see sample file for details). Your modifications will stay even after plugin upgrade!  
3.5.2 - Some refactoring.  
3.5.3 - Do not disable error reporting on server any more.  
3.5.4 - Fixed "rel=follow" feature.  Added icon for admin menu.  
3.5.5 - Divided code to smaller functions for easier overwrite with custom modes.  
3.5.6 - Fixed bug with writing click stats to database.  
3.5.7,3.5.8 - Custom parser file moved to uploads directory to avoid deletion.  
3.5.9 - Updated filter to support multiline links code.  
3.5.9.1 - Fixed bug when statistic was not written.  
3.5.9.2 - Parser logic optimization and fixes.  
3.5.9.3 - Added noindex comment option for yandex search engine.  
3.5.9.4 - Added masking options for RSS feed.  
3.5.9.5 - Added support for relative links, beginning with slash (/).  
3.5.9.6 - Fix for RSS masking.  
3.5.9.7 - Add support for custom location of wp-content dir.  
3.5.9.8 - Fixed custom parser load.  
3.5.9.9 - Added custom filter with name "wp_noexternallinks". Please use it for custom fields and so on.  
3.5.9.10 - Disabled full masking when running cron job to avoid collisions.  
3.5.10 - Fixed issues with cron job  
3.5.11 - minor improvements  
3.5.12, 3.5.13 - bugged versions  
3.5.14 - fallback to 3.5.11  
3.5.15 - fix masking issues with mixed http/https  
3.5.16 - minor security fix  
3.5.17 - fix for better compatibility with php7  
3.5.18 - added index on links table  
3.5.19 - minor XSS fix (thanks to DefenseCode WebScanner), more debug, fix possible bug with numeric masking  
3.5.20 - minor text fixes  
5.0.0 - simply bumped version to avoid confusion
