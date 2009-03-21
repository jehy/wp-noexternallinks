<?php
DEFINE(WPNEL_REDIRECTING,'Перенаправляю...');
DEFINE(WPNEL_REDIRECT1,'Вы должны были перейти по ссылке автоматически, но что-то не получилось...<br>Пожалуйста, нажмите ');
DEFINE(WPNEL_REDIRECT2,'СЮДА ');
DEFINE(WPNEL_REDIRECT3,' чтобы перейти на ');
DEFINE(WPNEL_REDIRECT4,' вручную. ');
DEFINE(WPNEL_PLUGIN_HOMEPAGE,'Страница плагина');
DEFINE(WPNEL_FEEDBACK,'Отзывы');
DEFINE(WPNEL_PATH_TO_GOTO,'Путь к редирект файлу "goto.php"');
DEFINE(WPNEL_DEFAULT,'По умолчанию');
DEFINE(WPNEL_IF_MODE_REWRITE,'Если вы используете mode rewrite для создания красивых адресов, можно сделать так');
DEFINE(WPNEL_PUT_HERE_SMTH_LIKE,'Напишите сюда что-то вроде');
DEFINE(WPNEL_PUT_LINE_LIKE,'Напишите строку вроде');
DEFINE(WPNEL_TO_YOUR_FILE,'в ваш файл');
DEFINE(WPNEL_THEN_APACHE_LEVEL_REDIRECT,'Тогда ваш сервер будет делать перенаправление на уровне apache, без использования файла goto.php');
DEFINE(WPNEL_MASK_LINKS_IN_POSTS,'Маскировать ссылки в ваших сообщениях');
DEFINE(WPNEL_MASK_LINKS_IN_COMMENTS,'Маскировать ссылки в комментариях');
DEFINE(WPNEL_MASK_LINKS_IN_AUTHORS,'Маскировать ссылки авторов комментариев');
DEFINE(WPNEL_HINT,'Этот плагин позволяет заменить все внешние ссылки на внутренние, или спрятать их - при помощи PHP редиректа, или  специальных тегов и атрибутов ссылок. Да, между прочим - он не меняет ничего в базе и не пишет туда - только заменяет ссылки на выводе.<br>P.S. Внутренние и исключённые ссылки плагин не маскирует:).');
DEFINE(WPNEL_SAVE_CHANGES,'Сохранить изменения');
DEFINE(WPNEL_CONFIGURATION,'Настройки');
DEFINE(WPNEL_LANGUAGE,'Язык');
DEFINE(WPNEL_NO_REDIRECT,'Извините, не найдено пути редиректа, невозможно совершить переход.');
DEFINE(WPNEL_EXCLUDE_URLS,'Адреса-исключения, к которым не будет применяться маскировка (ко всем, начинающимся с данного текста, по каждый адрес - с новой строки, включая префикс (например, http://jehy.ru))');
DEFINE(WPNEL_ADD_NOFOLLOW,'Добавлять <b>rel=nofollow</b> для маскируемых ссылок (любит google)');
DEFINE(WPNEL_ADD_BLANK,'Добавлять <b>target="blank"</b> для всех ссылок (будут открываться в новом окне)');
DEFINE(WPNEL_PUT_NOINDEX,'Окружать ссылки тегом <b>&lt;noindex&gt;ссылка&lt;/noindex&gt;</b>  (для yandex)');
DEFINE(WPNEL_DISABLE_MASK_LINKS,'Выключить подмену путей для ссылок (если вам достаточно тега <b>noindex</b> и атрибута <b>rel=nofollow</b>)');
DEFINE(WPNEL_DEFAULT_OPTIONS,'<h2>Глобальные настройки для маскировки ссылок</h2>(Вы можете отменить действие плагина  на конкретные посты)');

DEFINE(WPNEL_DEFAULT_POLICY,'Использовать общие настройки плагина');
DEFINE(WPNEL_MASK,'Маскировать ссылки');
DEFINE(WPNEL_DONT_MASK,'Не маскировать ссылки');
DEFINE(WPNEL_PERPOST_SETTINGS,'Маскировка ссылок для этого поста');
?>