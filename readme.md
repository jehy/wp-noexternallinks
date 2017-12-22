# WP No External Links

**Warning:** if you have plugin version 4.0.0-4.2.2 - please remove it as soon as possible!

This plugin was originally on [wordpress directory ](https://wordpress.org/plugins/wp-noexternallinks/) but
I transferred it to another person who published vulnerable plugin version so plugin was banned from wordpress directory.

However, you can install and update it manually from this repository. Plugin version
from here will always be safe.

#### Short info
* Author: Jehy  
* Tags: seo, link, links, publisher, post, posts, comments  
* Requires at least: 2.6  
* Tested up to: 4.5.3  
* Stable tag: 3.5.20  

Mask all external links - make them internal or hide. On your own posts, comments pages, authors page - no more PR\CY dropping!

## Installation

1. Upload the complete folder `wp-noexternallinks` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
2. [Optional] Configure plugin via admin options-&gt;Wp-NoExternalLinks link
4. Write posts with any kind of links, watch comments with links - and enjoy =^___^=


### Description
This plugin has many cool features - outgoing clicks stats, fulllink masking, custom redirects,masking links to digital short code and base64 encoding and so on.It is designed for specialists who sell different kind of advertisment on their web site (for example, with [sape](http://www.sape.ru/r.f6054dfcc2.php) system) and care about the number of outgoing links that can be found by search engines. Now you can make all external links internal! In your own posts, comments pages, authors page... Plugin does not change anything or write to base - just processes output.

Now you don't need to worry about your page rank or index, dropping because of spam bots. You write any kind of http link - and it becomes internal or hidden! Of cause, all the links will still be usable :).

Warning: this plugin may conflict with your caching plugins, including Hyper Cache. Usually adding redirect page to caching plugin exclusions works fine, but I can't garantee that everything will go smoothly. By the way, after deactivation this plugins leaves no traces in your database or hard drive - so if you have you have problems after deactivation - please, search them in another source, for example, caching plugins. Flushing cache should help.

You can take part in plugin development on [github](https://github.com/jehy/wp-noexternallinks).

### New Features:    

#### Version 3.5.1 implemented:   
+ Extending plugin with custom functions   

#### Version 3.3.2 implemented:   
+ Debug mode   

#### Version 3.3 implemented:   
+ Masking links with base64 (quick and no need for mysql table)   

#### Version 3.2 implemented:   
+ Completely removing links from your posts (someone requested this option)   
+ Masking links to text. Option for perverts.   

#### Version 3.1 implemented:  
+ Masking links with digital short codes    

#### Version 3.0 implemented:    
+ Outgoing clicks stats    
+ Javascript redirect with custom text and timeout    
+ .po file translation (sorry, now only english and russian versions are available)    
+ FULL link masking    
+ No masking for registered users    

#### Example

To make the long story short, your links like `http://gmail.com` will be masked into
`http://YourBlog.com/goto/http://gmail.com` - or  `http://YourBlog.com?goto=http://gmail.com`

Now you can even tansform simple link `<a href="http://google.com">google</a>` to 
`<noindex><a rel="nofollow" target="_blank" href="http://google.com">google</a></noindex>`

#### Donate or help?
If you want to ensure the future development and support of this plugin, you can make donation [on this page](http://jehy.ru/articles/donate/) or just write about this plugin in your blog.

#### Note
&lt;noindex&gt; tag is used mostly by russian search system "Yandex" (yandex.ru), and non-russian users don't usually need it.

#### Localization

* English
* Russian
* Spanish
* Your language also can be here - just send me language file :)

### Changelog

It is [here](changelog.md).

### Frequently Asked Questions
Those are [here](faq.md).
