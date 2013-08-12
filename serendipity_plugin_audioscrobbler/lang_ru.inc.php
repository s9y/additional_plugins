<?php # 

/**
 *  @version $Revision$
 *  @author Alexey Noskov <alexey.noskov@gmail.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_AUDIOSCROBBLER_TITLE', 'Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_TITLE_BLAHBLAH', 'Отображает список последних композиций в вашем блоге');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER', 'Количество композиций');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'Как много композиций отображать? (Должно быть не меньше 1)');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME', 'Логин на Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME_BLAHBLAH', 'Введите ваш логин, чтобы плагин мог получить доступ к соотвествующей ленте.');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW', 'Новое окно');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW_BLAHBLAH', 'Sollen die Links in einem neuen Fenster ge??ffnet werden (needs Javascript)');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME', 'Как часто список должен обновляться');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME_BLAHBLAH', 'Содержимое списка кэшируется. Когда превышается некоторый интервал времени, кэш обновляется. (Стандартно: 30 минут, минимум 5 минут)');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING', 'Форматирование записи');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLAHBLAH', 'Используйте %ARTIST% для имени исполнитея, %SONG% для имени композиции, %ALBUM% для имени альбома and %DATE% для даты.');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE', 'Stunden Unterschied zur UTC Zeit');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE_BLAHBLAH', 'Смещение времени от GMT (Пример: Москва (Россия) = 3)');   
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK', 'Форматирование всего блока');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK_BLAHBLAH', 'Используйте %ENTRIES% для списка композицийt, %PROFILE% для ссылки на профиль, и %LASTUPDATE% для времени последнего кэширования.');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE', 'Заголовок для ссылки на профиль');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE_BLAHBLAH', 'Текст для отображения в ссылке на Ваш профиль. (Для использования имени пользователя введите %USER%');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK', 'Ссылки на композиции');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK_BLAHBLAH', 'Должны ли композиции ссылаться на их страницы на Audioscrobbler?');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK', 'Ссылки на исполнителей');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_BLAHBLAH', 'Ставить ли ссылки на исполнителей? (Выберите вариант)');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_NONE', 'Не ставить ссылок');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_SCROBBLER', 'Ссыли на страницы исполнителей на Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_NONE', 'Ссылки на Musicbrainz, если доступно');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_SCROBBLER', 'Ссылки на Musicbrainz, если не доступно, то на Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_SPACER', 'Разделитель');
@define('PLUGIN_AUDIOSCROBBLER_SPACER_BLAHBLAH', 'Что должно быть использовано для разделения композиций в списке?');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_WRITE', 'Кэш не может быть записан');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_READ', 'Кэш не может быть прочитан');
@define('PLUGIN_AUDIOSCROBBLER_FEED_OFFLINE', 'Список композиций не доступен');
@define('PLUGIN_AUDIOSCROBBLER_STACK', 'Использовать повторение?');
@define('PLUGIN_AUDIOSCROBBLER_STACK_BLAHBLAH', 'Если количество композиций в списке меньше чем размер списка, Вы можете разрешить эту установку, чтобы последняя композициця была повторена X раз до заполнения списка.');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'как много композиций отображать? (Стандартно: одну, не может быть меньше 1)');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING', 'Использовать кодировку:');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING_BLAHBLAH', 'Поу молчанию, Serendipity использует UTF-8 при разборе данных. Если это вызывает прооблемы, так как ваш блог не поддерживает UTF-8, введите подходящую кодировку.');

