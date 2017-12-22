##FAQ

#### Is it an evil hack and black SEO?!
Before you say such awful things, read at least [Google's topics on SEO](http://www.google.com/support/webmasters/bin/topic.py?topic=8522).

#### How can I exclude my page with links from masking?   
Now you just put URLS you need to the exclusion list, or disable masking for concrete post - and everything's OK!!!

#### I removed your plugin but all links are masked!!!   
This plugin can't do it after uninstall. It doesn't change base or code of wordpress. Please,
* Remove another links plugin.
* Update your cache.
* Deactivate your caching plugin.

#### How can I mask links in custom field?
You will have to add just a line in theme code where you output custom field data.    
To add same preprocessing for data as for comment text, use    
 ```php
  $metadata=apply_filters('comment_text',$metadata);
 ```
For example, if you use some kind of metadata, it should look like this:    
 ```php
  $metadata = get_post\_meta($id, 'MetaTagName', true);// get data from wordpress database    
  $metadata=apply_filters('comment_text',$metadata);// add this line of code for preprocessing field value    
  echo $metadata;//output preprocessed field value    
```

That's if you want to mask links in custom field like in comments text. Use "the\_content" instead of "comment\_text" if  you want to use the same masking policy as for post text.
