��    N      �  k   �      �     �  
   �  =   �  5   �  V   4     �  �   �     O     c  =   x  3   �  D   �  �   /	     �	  u   �	  i   Q
  2   �
  Q   �
     @     Q  
   X  �   c       8     T   J  6   �     �     �     �       \     A   z     �     �  -   �       u   ,  &   �     �     �     �  #     T   =     �     �     �     �  �   �     �     �     �  �   �  9   U  r   �  d     �   g       F    �   W  '   �     "  '   A     i     �  
   �     �     �  _   �          +  -   8  �   f  [   �     E     H     W     e  �  h     .  ,   >  �   k  ]     �   m  c     �  |  ,        ?  f   ]  `   �  x   %  �   �  P   �  	  �  �   �   �   �!  �   R"  (   �"     #     #    5#  2   D$  w   w$  �   �$  j   �%  8   �%     -&  I   I&  	   �&  �   �&  �   B'  !   �'  Q   (  ^   `(  :   �(  �   �(  k   �)  F   D*  ?   �*  N   �*  E   +  �   `+  .   �+  ]   ,  &   x,  !   �,  Y  �,  3   .     O.  !   m.  �   �.  [   �/  �   �/  �   �0    c1     x2  �  �2    05  a   86  =   �6  X   �6  D   17     v7     �7     �7  .   �7    �7  "   �8     !9  f   ?9  �   �9  �   �:     6;  %   =;     c;     y;         '   D          -       E           L   3              B   (   5          =         /       H   I                  0           9                 ?   N   :   M      C   6          	              &   "   
       4   A                          !      )      G      K   7   #      @                   ;   J   2   *      1          +   <   8      >       F                ,          %   $   .        manually.   to go to  (may result in invalid RSS if used with some masking options) Add <b>rel=nofollow</b> for masked links (for google) Add <b>target="blank"</b> for all links to other sites (links will open in new window) Can not get output buffer! Check for document referer and restrict redirect if it is not your own web site. Useful against spoofing attacks. User will be redirected to main page of your web site. Choose masking type Common configuration Completely remove links from your posts. Someone needed it... Configuration for javascript redirects (if enabled) Custom parser file found but <b>custom_parser</b> class not defined! Custom redirect text. Use word "LINKURL" where you want to use redirect url. For example, <b>CLICK &lt;a href="LINKURL"&gt;HERE NOW&lt;/a&gt;</b> Days to keep clicks stats Debug mode (Adds comments lines like "&lt;!--wp-noexternallinks debug: some info--&gt;" to output. For testing only!) Default masking type is via 302 redirects. Please choose one of the following mods if you do not like it: Do not mask links when registered users visit site Do not mask links which have <b>rel="follow"</b> atribute and are posted by admin Don`t mask links Donate Error was: Exclude URLs that you don`t want to mask (all urls, beginning with those, won`t be masked). Put one adress on each line, including protocol prefix (for example, Failed SQL:  Failed to create table. Please, check mysql permissions. Failed to make masked link. MySQL link table does not exist. Trying to create table. Failed to save statistic data. Trying to create table. Failed to update options! Feedback Global links masking settings HERE  If you need to make custom modifications for plugin - you can simply extend it, according to If you need to mask links in posts`s custom field, take a look at Link encoding Link masking for this post Link separator for redirects (default="goto") Log all outgoing clicks. Mask ALL links in document (can slow down your blog and conflict with some cache and other plugins. Not recommended). Mask comments authors`s homepage links Mask links in RSS comments Mask links in comments Mask links in posts and pages Mask links in your RSS post content Mask url with special numeric code. Be careful, this option may slow down your blog. No redirect No statistic for given period. Options updated. Output buffer empty! Please note that domains with "www" and without it are considered different. So if you want to disable masking for "pinterest.com" and "www.pinterest.com", you should specify both domains Redirect time (seconds) Redirecting... Save Changes Skype, javascript and mail links are excluded by default. To exclude full protocol, just add line with it`s prefix - for example, Sorry, no url redirect specified. Can`t complete request. Statistic for plugin is disabled! Please, go to options page and enable it via checkbox "Log all outgoing clicks". Surround masked links with <b>&lt;noindex&gt;link&lt;/noindex&gt;</b> tag (for yandex search engine) Surround masked links with comment <b>&lt;!--noindex--&gt;link&lt;!--/noindex--&gt;</b> (for yandex search engine, better then noindex tag because valid) Table created. That plugins allows you to mask all external links and make them internal or hidden - using PHP redirect or special link tags and attributes. Yeah, by the way - it does not change anything in the base - only replaces links on output. If you disabled this plugin and still have links masked - it is your caching plugin`s fault! Those options are not secure enough if you want to protect your data from someone but are quite enough to make link not human-readable. Please choose one of them: Turn all links into text. For perverts. Use base64 encoding for links. Use default policy from plugin settings Use javascript redirect View View Stats View options View stats from WP_NoExternalLinks Can`t use output buffer. Please, disable full masking and use other filters. What to exclude from masking What to mask You can also disable plugin on per-post basis You have been redirected through this website from a suspicious source. We prevented it and you are going to be redirected to our  You were going to the redirect link, but something did not work properly.<br>Please, click  or safe web site. this article. to Project-Id-Version: wp-noexternallinks
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2017-06-13 11:04+0300
PO-Revision-Date: 2017-06-13 12:30+0300
Last-Translator: Jehy <fate@jehy.ru>
Language-Team: jehy <fate@jehy.ru>
Language: ru_RU
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Poedit-KeywordsList: __;_e
X-Poedit-Basepath: ..
X-Poedit-SourceCharset: UTF-8
X-Generator: Poedit 1.8.7
X-Poedit-SearchPath-0: .
 вручную. чтобы перейти по ссылке  (может привести к невалидному RSS при использованию некоторых настроек маскировки ссылок) Добавлять <b>rel=nofollow</b> в маскируемые ссылки (для google) Добавлять <b>target="blank"</b> для всех ссылок на другие сайты (ссылки будут открываться в новом окне) Не получилось установить контроль над буфером вывода! Проверять адрес, с которого пришёл пользователь, и зарпещать переход в случае, если он пришёл не с вашего веб сайта. Это защита от атак с подменой адреса. Пользователи будут перенаправлены на главную страницу вашего сайта. Выберите тип маскировки Общие настройки Полностью удалить ссылки из постов. Кому-то было нужно... Настройки редиректа через яваскрипт (если он выбран) Найден файл расширения плагина, но класс <b>custom_parser</b> не определён! Свой текст редиректа. Используйте слово "LINKURL"  где должен быть адрес. Например, <b>НАЖМИ &lt;a href="LINKURL"&gt;СЮДА ПРЯМО СЕЙЧАС&lt;/a&gt;</b> Время (в днях) хранения статистики по кликам Режим отладки (Добавляет комментарии HTML вроде "&lt;!--wp-noexternallinks debug: какая-то информация--&gt;"). Не должен быть использован в нормальном режиме работы. По умолчанию, при маскировке используются 302е редиректы. Пожалуйста, выберите один из вариантов ниже, если вас это не устраивает: Не маскировать ссылки при выдаче сайта зарегистрированным пользователям Не маскировать сссылки с атрибутом <b>rel="follow"</b>, написанные администратором Не маскировать ссылки Пожертвовать Ошибка была: Укажите адреса, которые вы не хотите маскировать - все адреса, начинающиеся с указанных, не будут маскированы. По одному на каждой строчке (например, SQL запрос, вызвавший ошибку: Не удалось создать таблицу. Пожалуйста, проверьте полномочия MySQL. Не удалось сохранить маску ссылки. Таблица MySQL не существует. Попытаемся её создать. Не удалось сохранить статистику. Пытаюсь создать таблицу. Не удалось обновить настройки! Обратная связь Глобальные настройки маскировки ссылок СЮДА  Если вам требуется сделать модификации в работе плагина - просто расширьте его по примеру Если вам требуется маскировать ссылки из произвольных полей постов, сделайте это по примеру Шифрование ссылок Настройка маскировки ссылок для этого поста Разделитель ссылок для редиректа (по молчанию = "goto") Логировать все исходящие клики. Маскировать ВСЕ ссылки в документе (может замедлить ваш блог и конфликтовать с кеширующими плагинами. Не рекомендуется). Маскировать ссылки  авторов комментариев на свои страницы Маскировать ссылки в комментариях в RSS Маскировать ссылки в комментариях Маскировать ссылки в постах и на страницах Маскировать ссылки в ваших постах в RSS Маскировать ссылки цифровым кодом. Осторожно, это может замедлить ваш блог. Не использовать редирект За указанный период времени статистики не найдено. Настройки обновлены. Буфер вывода пуст! Пожалуйста, обратите внимание, что домены с "www" и без - это разные домены! То есть, если вы хотите выключить маскирование ссылок для домена "pinterest.com" и "www.pinterest.com" - вам нужно указать оба домена. Время редиректа (в секундах) Перенаправляю... Сохранить измения Ссылки на скайп, яваскрипт и почту уже исключены из маскировки. Чтобы исключить весь протокол, добавьте строчку с его префиксом - например, Не был определён адрес, невозможно перенаправить. Статистика для плагина отключена. Пожалуйста, зайдите в настройки и установите галочку "Вести статистику по кликам на внешние ссылки". Окружать маскируемые ссылки тегом <b>&lt;noindex&gt;link&lt;/noindex&gt;</b> (для яндекса) Окружать маскируемые ссылки комментарием <b>&lt;!--noindex--&gt;link&lt;!--/noindex--&gt;</b> (для яндекса, это лучшая альтернатива тегу noindex, поскольку HTML остаётся валидным) Таблица создана. Этот плагин позволяет вам маскировать внешние ссылки и делать их внутренними или прятать - при помощи перенаправлений или специальных тагов и атрибутов. Он ничего не меняет в базе блога, только перехватывает и редактирует вывод пользователю. Если вы отключили этот плагин, а ваши ссылки всё ещё маскируются - скорее всего, это связано с вашим кеширующим плагином! Эти виды шифрования небезопасно, если вы хотите защитить от кого-то данные, но его вполне хватает, чтобы сделать ссылку нечитаемой для человека. Превратить все ссылки в текст. Опция для извращенцев. Кодировать ссылки при помощи base64. Использовать настройки маскировки по умолчанию Использовать яваскриптовый редирект Смотреть Статистика Настройки Посмотреть статистику от WP NoExternalLinks не удалось использовать буфер вывода wordpress. Пожалуйста, выключите опцию полной маскировки ссылок в настройках плагина и используйте другие опции. Что не маскировать Что маскировать Так же вы можете отключить плагин для конкретных постов Вас перенеправили по этой сссылке из подозрительного источника. Мы предотвратили переход, и вы будете перенаправлены на наш  Вы должны были быть перенаправлены по ссылке, но что-то не получилось.<br> Пожалуйста, нажмите  или безопасный веб сайт. этой статьи до 