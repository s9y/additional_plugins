<?php # 

/**
 *  @version 
 *  @author Ivan Cenov JWalker@hotmail.bg
 *  EN-Revision: 1.23
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', '��������� �� ������');
@define('PLUGIN_EVENT_FREETAG_DESC', '��������� �������� ��������� �� ��������');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', '�������� �������, ��������� �� ���� ������. ��������� ��������� ��� ��������� (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', '�������, ���������� ��� ���� ������: %s');
@define('PLUGIN_EVENT_FREETAG_USING', '������, ��������� � \'%s\'');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', '�������, �������� � ������ \'%s\'');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','���� �������� �������.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', '������ ���������� �������');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', '���������� �� ���������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', '���������� �� ������ �������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', '���������� �� �������� �������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', '������ �� ������������� ������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', '������ �� ������, ��������� � �������� �������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', '���� ������������ ������!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', '������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', '�����');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', '��������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', '������������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', '���������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', '���������');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', '������������ �� ������� �� �������� ������ \'%s\'?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', '����������� ������� �� ��������� �� ���������:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', '��������� �� ����� � ���������?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', '��������� �� X-FreeTag-HTTP-Headers');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', '��������� �� ������ � ������ ������� ��� ������ �� ������');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', '���������� �� ��������� "�������� �� ������� �� ����� �� ������"');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', '�������');
@define('PLUGIN_FREETAG_BLAHBLAH', '������� ������ �� ������� ��� ��������');
@define('PLUGIN_FREETAG_NEWLINE', '����� ������ �� ��� ���?');
@define('PLUGIN_FREETAG_XML', '��������� �� XML �����?');
@define('PLUGIN_FREETAG_SCALE','���������� �� ���������� �� ������ � ���������� �� ������������� �� ������� (������� �� Technorati, flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','���������� �� %d ������� �� ������ ����� %d');
@define('PLUGIN_FREETAG_MAX_TAGS', '����� ������� �� ����� ���������?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', '��������� ���� �� ���������� �� ������, �� �� ���� ��������?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', '���-����� ����� % �� ��������� � ������');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', '���-����� ����� % �� ��������� � ������');

@define('PLUGIN_EVENT_FREETAG_USE_FLASH', '���������� �� Flash �� ��������� �� ������ �� �������?');
@define('PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR', '���� �� ��������� (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT', '��������� ��� �� ������?');
@define('PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR', '���� �� ���� �� ������ (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_FLASH_WIDTH', '������ �� ������');
@define('PLUGIN_EVENT_FREETAG_FLASH_SPEED', '������� �� �������� �� ������');


@define('PLUGIN_FREETAG_META_KEYWORDS', '���� �� ����-��������� ����, ����� �� �� �������� � HTML (0: ���������)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', '������ � ������� �������:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','��������� �� �������� � ������� �������?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','����� ������ � ����� ������ �� ����� ���������?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', '��������� �� ��������� ���� ��������?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', '��� � ���������, ��������� �� �� �������� ���� ��������. ��� � ���������, ��������� �� ����� ��������� � ������ �� �������� (� ��������� ��� �������������� ����).');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', '��������� � ����� �����');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', '�������� �������');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', '������');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', '��������� �� ������� �� ������ ���������� ���������?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', '��� � ���������, ������ ���������, ��� ����� ������ ������ � ���������� �� ����� �������� ���� ������� ��� ��������. ������ �� ���������� ������ ��������� �� ��������� �� ������ ������������ ������ ���� ����� "���������� �� ���������" � ����������������� ��������.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE', '������ �� ���������� �����');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', '��� � ���������, �������� �� �������� �� ������������ �� ��������� � ���������� �����. � ������� ��� ���������� <tags> ����� ������� ������� �� ��������� ��� ������ <tagName> => array(href => <tagLink>, count => <tagCount>)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', '������������� �� ������ ���������� ��������� �� ������������ ������ � �������');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', '������������� ��������� �� ������ #%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', '������ ��������� �� ������������� � �������.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', '����������� ������� ����');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', '������ �� ���������� ������� ����, ��������� ��� \',\' �� ����� ������. ������ ��������� ���� �� ��������� � ������ �� ��������, ����������� ������� �� ��������� ��� ��������. ��� ��� �� �� ��� �������, �� ������ ����� ������� ���� ����� �� �������� ������� �� ����� �� ��������.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', '�������� ������� ���� <strong>%s</strong>, ������ <strong><em>%s</em></strong> � ��������� �����������.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', '������� �� ������ �� %d �� %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (���� %d ������)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', '������� �� ��������� ����� ������...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', '�������������� �� ������ ������� ����');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', '��������: ���� ������� �� ��������� ����� ������ ��� ����� ����. ���� �� ������ �������� ����� � � ����������� ������ �� ��������. ���� ����� ��������� �������� ����� �� ������ �����. ��������� \'CANCEL\', ��� ������� �� ���������� ����������.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', '��� �� ������');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', '���� �����');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE',    'XML ����������� (����������� ������ ���� �� ��������� ���� �� �����)');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', '��� ����� �� \'Smarty\', �� ���� ��������� \'Smarty\' ���������� {$entry.freetag}, ����� ������ �� ������� ��������� � ���� entries.tpl.');
