<?php # 
@define('PLUGIN_SNAPSHOTLINKS_NAME',                'Link SnapShots using snap.com');
@define('PLUGIN_SNAPSHOTLINKS_DESC',                "This plugin shows page previews, while the user is hovering over a link. To reach this aim the SnapShot service at www.snap.com is used. You have to register your domain and email once, to get a key for your domain needed for calling the SnapShot functionality.\nSnap.com is a free service, but be aware that snap.com *might* be able to collect data profiles about user IPs loading links from this blog site, although their privacy statement promise not to do so.");
@define('PLUGIN_SNAPSHOTLINKS_DESC_DUMMY',          "This plugin shows page previews, while the user is hovering over a link. To reach this aim the SnapShot service at www.snap.com is used. \nSnap.com is a free service, but be aware that snap.com *might* be able to collect data profiles about user IPs loading links from this blog site, although their privacy statement promise not to do so.");

@define('PLUGIN_SNAPSHOTLINKS_URL_NAME',            'Registered domain');
@define('PLUGIN_SNAPSHOTLINKS_URL_DESC',            'The domain you have registered in the key registration process');
@define('PLUGIN_SNAPSHOTLINKS_KEY_NAME',            'Your SnapShots key');
@define('PLUGIN_SNAPSHOTLINKS_KEY_DESC',            'After you have registrated your domain and email you will get a script snippet. You will see a key between "key=" and "&". Copy & paste it here, but don\'t paste the "&" with it');

@define('PLUGIN_SNAPSHOTLINKS_THEME_NAME',          'Color theme');
@define('PLUGIN_SNAPSHOTLINKS_THEME_DESC',          'Choose your color theme');

@define('PLUGIN_SNAPSHOTLINKS_THEME_ASPHALT',       'Asphalt');
@define('PLUGIN_SNAPSHOTLINKS_THEME_GREEN',         'Green');
@define('PLUGIN_SNAPSHOTLINKS_THEME_ICE',           'Light Blue');
@define('PLUGIN_SNAPSHOTLINKS_THEME_LINEN',         'Linen');
@define('PLUGIN_SNAPSHOTLINKS_THEME_ORANGE',        'Orange');
@define('PLUGIN_SNAPSHOTLINKS_THEME_PINK',          'Pink');
@define('PLUGIN_SNAPSHOTLINKS_THEME_PURPLE',        'Purple');
@define('PLUGIN_SNAPSHOTLINKS_THEME_SILVER',        'Silver');

@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_NAME',    'Preview size');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_DESC',    'Please note that increasing the dimensions will also increase file size and may slow down load times for your end users.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_SMALL',   'small');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSIZE_LARGE',   'large');

@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_NAME', 'Trigger preview on');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_DESC', 'The preview is triggerd by the mouse hovering over the link and/or the icon near the link.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_LINK', 'cursor is over the link');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_ICON', 'cursor is over the icon');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWTRIGGER_BOTH', 'cursor is over both link and icon');

@define('PLUGIN_SNAPSHOTLINKS_LINKICON_NAME',       'Show link icon');
@define('PLUGIN_SNAPSHOTLINKS_LINKICON_DESC',       'Do you want to have an icon near the link?');

@define('PLUGIN_SNAPSHOTLINKS_USERPREVIEW_NAME',    'Preload previews');
@define('PLUGIN_SNAPSHOTLINKS_USERPREVIEW_DESC',    'Load previews first. Should be switched off, else your page gets very slow!');
@define('PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_NAME',     'Custom logo');
@define('PLUGIN_SNAPSHOTLINKS_CUSTOMLOGO_DESC',     'You have to upload your custom logo to the snap.com service to have it displayed in the preview.');

// "Advanced options"
@define('PLUGIN_SNAPSHOTLINKS_SEARCHBOX_NAME',      'Search Box');
@define('PLUGIN_SNAPSHOTLINKS_SEARCHBOX_DESC',      'Show an inpot box to search the Web on Snap.com');
@define('PLUGIN_SNAPSHOTLINKS_ALLLINKS_NAME',       'Preview External Links');
@define('PLUGIN_SNAPSHOTLINKS_ALLLINKS_DESC',       'Do you want to preview external links? These are linky outside your domain.');
@define('PLUGIN_SNAPSHOTLINKS_LOCALLINKS_NAME',     'Preview Internal Links');
@define('PLUGIN_SNAPSHOTLINKS_LOCALLINKS_DESC',     'Do you want to preview your internal links? These are linky inside your domain.');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_NAME',   'Preview images always');
@define('PLUGIN_SNAPSHOTLINKS_PREVIEWSHOTS_DESC',   'Always display previews as snapshot images. If switched off, text only previews are tried to be loaded (RSS feeds). Switching this off reduces your users bandwidth.');

// Wikipedia options:
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_NAME',         'Show Wikipedia previews');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_DESC',         'Words my be followed by icons that will open a Wikipedia description of this word when hovering over the icon. Do you want to use this feature?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_NAME',    'Wikipedia language');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_LANG_DESC',    'Here you define, what wikipedia language version should be used. If you want to use the English version, enter "en" here.');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_NAME',    'Wikipedia markup');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_DESC',    'How you want to mark words, that will have the Wikipedia icon later when displaying the article?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_BOLD',    'Bold');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_ITALIC',  'Italic');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_TYPE_SUBLINED','Underlined');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_NAME',     'Remove Wikipedia markup?');
@define('PLUGIN_SNAPSHOTLINKS_WIKIFY_REMOVE_TYPE_DESC',     'Do you want to replace the markup with the new SnapShot code or do you want the markup to stay visible when displaying the article?');

?>