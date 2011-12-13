<?php # $Id: lang_cn.inc.php,v 1.1 2006/01/25 10:30:11 garvinhicking Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Demin Yin <damon@deminy.net>
 *  CN-Revision: Revision of lang_cn.inc.php
 */

@define('PLUGIN_WIKIPEDIAFINDER_TITLE',                     "维基百科搜索");
@define('PLUGIN_WIKIPEDIAFINDER_DESC',                      "选中一个短语，再点击图标后在维基百科中搜索。");
@define('PLUGIN_WIKIPEDIAFINDER_PROMPT',                    "要使用维基百科搜索，请先输入短语。");        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE',                "标题");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TITLE_DESC',           "侧栏区块标题");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE',                 "维基百科网站");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_SITE_DESC' ,           "将被使用的维基百科网址");
@define('PLUGIN_WIKIPEDIAFINDER_SITE' ,                     "http://cn.wikipedia.org");        
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR',                "背景颜色模版");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DESC' ,          "背景模版颜色深还是浅？维基百科图像选择需要这个设置。");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_DARK' ,          "深色背景");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_COLOR_LIGHT' ,         "浅色背景");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET',               "目标窗口");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW',             "使用JavaScript打开目标窗口");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_TARGET_DESC' ,         "如果维基百科将在新窗口打开，新窗口的名字（例如“wikimedia”）可在这里输入。这个设置会覆盖\"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\"里的设置。");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_DESC',        "A new window can be opened using Javascript that controls the height and width of the window. If \"Yes\" is selected this overrides the \"" .PLUGIN_WIKIPEDIAFINDER_PROP_TARGET. "\" setting.");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT',      "Javascript窗口高度");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_HEIGHT_DESC', "目标窗口高度。仅在\"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\"选项被选择的时候有效。");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH',       "Javascript窗口宽度");
@define('PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW_WIDTH_DESC',  "目标窗口高度。仅在\"" . PLUGIN_WIKIPEDIAFINDER_PROP_JSWINDOW . "\"选项被选择的时候有效。");

?>
