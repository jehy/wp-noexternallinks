=== WP No External Links ===
Author: Jehy
Tags: seo, link, links, publisher, post, posts, comments
Requires at least: 2.6
Tested up to: 2.7.1
Stable tag: 2.15
Mask all external links - make them internal or hide. On your own posts, comments pages, authors page - no more PR\CY dropping!

== Description ==
>WARNING
>If you upgraded to version 2.10 and higher and have problems - please [download version 2.05](http://downloads.wordpress.org/plugin/wp-noexternallinks.2.05.zip) or help me to debug - currently It seems like I'm having problems with blogs on PHP4.

>If you are having problems even with 2.05
>Then please [download version 0.071](http://downloads.wordpress.org/plugin/wp-noexternallinks.0.071.zip) - it's slower, doesn't have functionality, but works fine on servers with the worst settings. 

>Still not good?
>Tell me about your problems in [my blog](http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/).

Mask all external links to internal! In your own posts, comments pages, authors page... It does not change anything or write to base - just processes output.

Now you don't need to worry about your page rank or index, dropping because of spam bots. You write any kind of http link - and it becomes internal or hidden! You can configure plugin to work with your own posts, pages comments and authors's profiles. Of cause, the link will still be usable :).

####NEW!!!!!
+ Now you can also disable link rewriting, and use **"rel=nofollow"** and **&lt;noindex&gt;** tag instead of it - everything as you wish!   
+ From version 2.0 you can **make all links open in new window!**   
+ After many requests, I finally made an option to **disable masking** for concrete URLs and posts.  
+ Plugin works now without any magic with .htacess - you just install it and it works, and determines itself, if you need to rewrite permalinks, or use default link structure.  
Have fun!

####Example

In short, your links like "http://gmail.com" will be masked into  
"http://YourBlog.com/goto/http://gmail.com" - or  
"http://YourBlog.com?goto=http://gmail.com"

Now you can even tansform simple link "&lt;a href="http://google.com"&gt;google&lt;/a&gt;" to   
"&lt;noindex&gt;&lt;a rel="nofollow" target="_blank" href="http://google.com"&gt;google&lt;/a&gt;&lt;/noindex&gt;"

####Just one poplular question :)
>  **- Is it an evil hack and black SEO?!**   
 - Before you say such awful things, read at least [Google's topics on SEO](http://www.google.com/support/webmasters/bin/topic.py?topic=8522)   

####Note
&lt;noindex&gt; tag is used mostly by russian search system "Yandex" (yandex.ru), and non-russian users don't usually need it.

####History

0.01 - First release  
0.02 - Multilanguagal release  
0.03 - Bugfix  
0.04 - Activation \ Deactivation improved, optimization, localization settings now stored as options  
0.05 - Bugfix for wrong html parsing  
0.06 - Bugfix for email links  
0.07 - Better work for sites wihout mod_rewrite  
0.071 - Russian translation corrected  
   
   
2.0 - Many significant changes, including urls and post exclusion from masking, another rewrite structure, and new options.   
2.01 - Little bugfix, for fixing errors when empty exlusions  
2.02 - Updated to execute later then other link filters, preventing possible problems with other plugins   
2.03 - Fixed broken excludions list   
2.04 - Changed default settings, removed "disable links masking"    
2.05 - Fixed internationalization, added Belarusian language    
    
    
2.10 - Plugin was rewrited for faster performance, fixed adding targer="_blank" for internal links    
2.11 - Removed "public" keyword in class functions definitions. Probably will be more compatible with PHP4.    
2.12 - Fully compatible with PHP4.    
2.13 - Fixed language inclusion problem which apperared in some cases.    
2.14 - Absolute  file paths used now instead of relative.    
2.15 - Fixed for some servers with setup which replaces "//" with"/".

####Localization

* English
* Russian
* Belarusian [by Marcis Gasuns](http://www.comfi.com)
* Your language also can be here - just send me language file :)


####Please!
If you don't rate my plugin as 5/5 - please write why - and I will add or change options and fix bugs. It's very unpleasant to see silient low rates.  
If you don't understand what this plugin does - also don't rate it. SEO specialists only.

####Donate? Just a link!
If you liked this plugin - please write a review or just put somewhere a [link to plugin homepage](http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/) - it will be quite enough for a "thanks" ^_^

== Installation ==

1. Upload the complete folder `wp-noexternallinks` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
2. [Optional] Configure plugin via admin options-&gt;Wp-NoExternalLinks link
4. Write posts with any kind of links, watch comments with links - and enjoy =^___^=

== Frequently Asked Questions ==
- How can I exclude my page with links from masking?   
Now you just put URLS you need to the exclusion list, or disable masking for concrete post - and everything's OK!!!