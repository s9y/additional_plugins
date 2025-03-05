<?php

/**
 *  @version 1.0
 *  @author Wesley Woo-Duk Hwang-Chung <wesley96@gmail.com>
 *  EN-Revision: 3.66 Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', '글에 태그 달기');
@define('PLUGIN_EVENT_FREETAG_DESC', '글에 자유롭게 태그를 달 수 있게 합니다');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', '알맞은 태그를 입력합니다. 각 태그는 쉼표(,)로 분리합니다.');
@define('PLUGIN_EVENT_FREETAG_LIST', '이 글에 대한 태그: %s');
@define('PLUGIN_EVENT_FREETAG_USING', '%s 태그가 달린 글');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', '%s 태그와 관련된 태그');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','관련된 태그 없음.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', '입력한 모든 태그');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', '태그 관리하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', '모든 태그 관리하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', '\'낱개\' 태그 관리하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', '태그 없는 글 나열하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', '\'낱개\' 태그가 달린 글 나열하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP', '글-태그 연결상태 정돈하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO', '다음 목록은 존재하지 않는 글에 할당된 태그를 보여줍니다. ;정돈하기&quot;를 눌러서 이렇게 불필요하게 된 태그를 삭제하세요.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING', '존재하지 않는 글에 할당된 태그를 찾을 수 없었습니다. 정돈할 내역이 없습니다.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR', '존재하지 않는 글에 할당된 태그를 찾는 도중 오류가 발생하여 진행할 수 없습니다.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM', '정돈하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES', '영향받는 글의 ID');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL', '불필요한 할당 내역을 모두 성공적으로 삭제했습니다.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED', '불필요한 할당 내역을 삭제하는데 실패했습니다.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', '태그 없는 글이 없습니다!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', '태그');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', '가중치');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', '작업');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', '이름 바꾸기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', '분리하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', '삭제하기');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', '%s 태그를 정말로 삭제하겠습니까?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', '쉼표로 태그를 분리합니다:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', '관련 태그에 태그 클라우드를 보여줍니까?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'X-FreeTag HTTP 헤더 보내기');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', '글을 쓸 때 선택할 수 있는 모든 태그의 목록을 보여주기');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', '입력 중 자동으로 태그를 찾는 기능 활성화하기');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', '태그 달린 글 보여주기');
@define('PLUGIN_FREETAG_BLAHBLAH', '글에 대해 현재 존재하는 태그의 목록 보여주기');
@define('PLUGIN_FREETAG_NEWLINE', '각 태그 뒤에 줄바꿈을 합니까?');
@define('PLUGIN_FREETAG_XML', 'XML 아이콘을 보여줍니까?');
@define('PLUGIN_FREETAG_SCALE','테크노라티, 플리커 등의 서비스처럼 사용빈도에 따라 태그 글자 크기를 조절합니까?');
@define('PLUGIN_FREETAG_UPGRADE1_2','%d 개의 태그를 %d 번 글에서 업그레이드합니다');
@define('PLUGIN_FREETAG_MAX_TAGS', '몇 개의 태그를 보여줍니까?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', '태그가 몇 번 쓰여야 나타날 수 있게 됩니까?');

//
// later on additions
//
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', '태그 클라우드에 표시되는 태그 글자의 최소 크기 비율(%)');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', '태그 클라우드에 표시되는 태그 글자의 최대 크기 비율(%)');


@define('PLUGIN_FREETAG_META_KEYWORDS', 'HTML 소스에 삽입할 메타 키워드의 수 (0: 사용 안 함)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', '태그로 연관된 글:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','태그로 연관된 글을 보여줍니까?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','연관된 글을 몇 개 보여줍니까?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', '글 말미(푸터)에 태그를 보여줍니까?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', '사용할 경우 글 말미(푸터)에 태그를 표시합니다. 사용하지 않을 경우 글 본문이나 확장영역에 태그를 삽입합니다.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', '소문자 태그');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', '관련 태그');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', '태그 링크');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', '관련된 모든 범주에 대해 태그를 생성합니까?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', '사용할 경우 글에 지정된 모든 범주에 대해서도 태그로 추가됩니다. 모든 글의 범주 연결 상태는 관리 도구 화면의 "태그 관리하기" 메뉴에서 설정할 수 있습니다.');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG', '자동화 키워드를 통해 태그를 생성합니까?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC', '사용할 경우 글 본문에 자동화 키워드가 있는지 확인하고 해당 태그를 추가하게 됩니다. 키워드는 관리 도구 화면의 "태그 관리하기" 메뉴에서 설정할 수 있습니다.');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE', '옆줄 템플릿');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', '설정할 경우 옆줄에 태그를 표시할 때 템플릿을 사용합니다. 템플릿 내에는 <tags> 변수가 있는데, <tagName> => array(href => <tagLink>, count => <tagCount> 형태로 태그 목록을 담고 있습니다.)');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', '기존 글에 지정된 모든 범주를 태그로 변환하여 입력하기');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', '%d 번 글 (%s)에 대해 변환된 범주: %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', '모든 범주를 태그로 변환했습니다.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', '자동화 키워드');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', '각 태그에 대한 키워드를 지정할 수 있습니다 (쉼표 ","로 여러 개 분리). 글 본문에 해당 키워드를 사용하게 될 경우 해당되는 태그가 그 글에 추가됩니다. 자동화 키워드를 사용할 경우 글을 저장하는 시간이 길어질 수 있음에 유의하기 바랍니다.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', '<strong>%s</strong> 키워드를 발견하여 <strong><em>%s</em></strong> 태그를 자동으로 지정했습니다.<br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', '%d 번부터 %d 번까지 글 불러오는 중');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (총 %d 개의 글)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', '다음 글 묶음 불러오는 중...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', '모든 자동화 키워드를 다시 색인하기');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', '경고: 이 기능은 모든 글을 불러들여 하나씩 다시 저장하는 작업을 합니다. 시간이 오래 걸릴 수 있으며 기존 글이 손상될 수도 있습니다. 진행 전에 데이터베이스를 미리 백업하기를 권장합니다. 중단하려면 "취소" 버튼을 누르세요');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', '태그 이름');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', '태그 수');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE', 'XML 그림의 상대경로 (템플릿 위치 기준)');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', '"스마티"로 설정할 경우 entries.tpl 템플릿 파일 내에 자유롭게 넣을 수 있는 {$entry.freetag} 스마티 변수를 생성합니다.');

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY', '확장된 스마티');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC', '나중에 템플릿에서 사용할 수 있는 별도의 스마티 변수를 만들어냅니다. 이는 다른 설정에 우선합니다. 사용 예제는 Readme 파일을 참고하기 바랍니다.');

@define('PLUGIN_EVENT_FREETAG_COLLATION', 'entrytags.tag 열에 대한 (MySQL) 데이터베이스의 데이터 정렬 방식 (자동감지)');
@define('PLUGIN_EVENT_FREETAG_KILL', '체크 표시를 하게 되면 이 글에 지정한 모든 태그를 삭제합니다.');

@define('PLUGIN_EVENT_FREETAG_TAGLINK_DESC', '태그 링크에 줄 수 있는 변화 중 하나는 "plugin/tag" 대신 "plugin/taglist/"로 쓰는 것입니다. 이렇게 하면 태그가 이미 열린 글로 나타나는 것이 아니라 클릭 가능한 목록으로 나타나게 됩니다. 일반 페이지에서 나타나는 태그 링크 중 일부를 이런 식으로 수동 추가할 수도 있고 기존 경로에 "/taglist"를 추가할 수도 있습니다 (예: "/plugin/tag/your/tags/append/taglist"). 두 경우 모두 "taglist"가 예약된 단어가 되기 때문에 다른 곳에서 일반 태그로 더 이상 사용할 수 없게 됩니다. 이렇게 사용하고자 한다면 다음 옵션을 활성화한 뒤 "목록으로 나타나는 태그" 옵션에 대한 설명에 따라 작동 코드를 수동으로 입력하기 바랍니다.');

@define('PLUGIN_EVENT_FREETAG_TAGSASLIST', '"목록으로 나타나는 태그" 사용하기 = 곧바로 열리지 않는 글');
@define('PLUGIN_EVENT_FREETAG_TAGSASLIST_DESC', '이 플러그인의 내부 문서에 설명되어 있는 내용을 참조하여 기존  entries.tpl 파일에 스마티 태그 목록 작동 코드를 추가하기 바랍니다.');

