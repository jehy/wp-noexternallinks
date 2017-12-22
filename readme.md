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
* Stable tag: 5.0.0  

Mask all external links - make them internal or hide. On your own posts, comments pages, authors page - no more PR\CY dropping!

## Installation
1. `Git clone` this repo or [download it as a zip](https://github.com/jehy/wp-noexternallinks/archive/master.zip).
2. Upload the complete folder `wp-noexternallinks` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. [Optional] Configure plugin via admin options-&gt;Wp-NoExternalLinks link
5. Write posts with any kind of links, watch comments with links - and enjoy =^___^=


### Description
This plugin has many cool features - outgoing clicks stats, fulllink masking, custom redirects,masking links to digital short code and base64 encoding and so on.It is designed for specialists who sell different kind of advertisment on their web site (for example, with [sape](http://www.sape.ru/r.f6054dfcc2.php) system) and care about the number of outgoing links that can be found by search engines. Now you can make all external links internal! In your own posts, comments pages, authors page... Plugin does not change anything or write to base - just processes output.

Now you don't need to worry about your page rank or index, dropping because of spam bots. You write any kind of http link - and it becomes internal or hidden! Of cause, all the links will still be usable :).

Warning: this plugin may conflict with your caching plugins, including Hyper Cache. Usually adding redirect page to caching plugin exclusions works fine, but I can't garantee that everything will go smoothly. By the way, after deactivation this plugins leaves no traces in your database or hard drive - so if you have you have problems after deactivation - please, search them in another source, for example, caching plugins. Flushing cache should help.

You can take part in plugin development on [github](https://github.com/jehy/wp-noexternallinks).

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
