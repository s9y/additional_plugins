<?php # 
# Translated by: Wesley Hwang-Chung <wesley96@gmail.com> 
# (c) 2005 http://www.tool-box.info/

@define('STATICPAGE_HEADLINE', '헤드라인');
@define('STATICPAGE_HEADLINE_BLAHBLAH', '블로그의 일반 글처럼 내용 위에 헤드라인을 보여줍니다.');
@define('STATICPAGE_TITLE', '고정 페이지');
@define('STATICPAGE_TITLE_BLAHBLAH', '블로그의 디자인을 그대로 따르는 고정 페이지를 블로그 속에 보여줍니다. 관리 메뉴에 새 메뉴 아이템을 생성합니다.');
@define('CONTENT_BLAHBLAH', '내용');
@define('STATICPAGE_PERMALINK', '고정 링크');
@define('STATICPAGE_PAGETITLE', '주소의 줄임 이름 (하위 호환성)');
@define('STATICPAGE_PERMALINK_BLAHBLAH', '주소에 대한 고정 링크를 정합니다. HTTP 절대 경로가 필요하며 .htm 또는 .html로 끝맺어야 합니다.');
@define('STATICPAGE_ARTICLEFORMAT', '일반 글 형태로 보이기');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', '"예"를 선택할 경우 자동으로 일반 글 형태(색상, 테두리 등 포함)로 만듭니다. (기본값: 예)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', '"일반 글 형태로" 모드에서의 페이지 제목');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', '일반 글 형태를 사용할 경우 블로그 작성 날짜가 나타나는 위치에 적을 글을 쓰십시오.');
@define('STATICPAGE_SELECT',            '편집하거나 생성할 고정 페이지를 고르십시오.');
@define('STATICPAGE_PASSWORD_NOTICE',   '이 페이지는 암호가 걸려 있습니다. 적절한 암호를 입력하십시오: ');
@define('STATICPAGE_PARENTPAGES_NAME',  '상위 페이지');
@define('STATICPAGE_PARENTPAGE_DESC',   '상위 페이지를 선택하십시오');
@define('STATICPAGE_PARENTPAGE_PARENT', '상위임');
@define('STATICPAGE_AUTHORS_NAME',      '작성자 이름');
@define('STATICPAGE_AUTHORS_DESC',      '이 작성자는 이 페이지의 소유자임');
@define('STATICPAGE_FILENAME_NAME',     '템플릿 (스마티)');
@define('STATICPAGE_FILENAME_DESC',     '이 페이지에 사용할 템플릿의 파일 이름을 입력하십시오. 해당 스마티 파일은 플러그인 디렉토리나 템플릿 디렉토리에 놓일 수 있습니다.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', '하위 페이지 보이기');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', '현재 페이지의 모든 하위 페이지를 링크 목록으로 보여줍니다.');
@define('STATICPAGE_PRECONTENT_NAME', '앞서 보일 내용');
@define('STATICPAGE_PRECONTENT_DESC', '이 내용을 하위 페이지 목록 전에 표시합니다.');
@define('STATICPAGE_CANNOTDELETE_MSG', '이 페이지를 지울 수 없습니다. 하위 페이지가 데이터베이스에 있기 때문이니 이를 먼저 지우십시오.');
@define('STATICPAGE_IS_STARTPAGE', '이 페이지를 세렌디피티의 첫 페이지로 지정하기');
@define('STATICPAGE_IS_STARTPAGE_DESC', '세렌디피티의 기존 첫 페이지를 보여주는 대신에 여기서 지정한 고정 페이지가 나타납니다. 한 페이지만 첫 페이지로 지정해야 합니다. 기존의 첫 페이지로 링크를 걸려면 "index.php?frontpage"를 사용하셔야 합니다.');
@define('STATICPAGE_TOP', '꼭대기로');
@define('STATICPAGE_LINKNAME', '편집');

@define('STATICPAGE_ARTICLETYPE', '글 종류');
@define('STATICPAGE_ARTICLETYPE_DESC', '고정 페이지의 종류를 고릅니다.');

@define('STATICPAGE_CATEGORY_PAGEORDER', '페이지 순서');
@define('STATICPAGE_CATEGORY_PAGES', '페이지 편집');
@define('STATICPAGE_CATEGORY_PAGETYPES', '페이지 종류');

@define('STATICPAGE_CATEGORY_PAGES_COMMON', '공통');
@define('STATICPAGE_CATEGORY_PAGES_EXTENDED', '확장');

@define('PAGETYPES_SELECT', '페이지 종류를 고릅니다.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', '설명:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', '페이지의 종류를 설명합니다.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', '템플릿 이름:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', '템플릿의 이름으로써, 고정 페이지 플러그인과 같이 있거나 기본 템플릿 디렉토리에 있을 수 있습니다.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', '그림 경로:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', '그림이 있는 주소입니다.');

@define('STATICPAGE_SHOWNAVI', '상단 링크 보이기');
@define('STATICPAGE_SHOWNAVI_DESC', '이 페이지 위쪽에 페이지 이동 링크를 보이게 합니다.');
@define('STATICPAGE_SHOWONNAVI', '옆줄 링크에 보이기');
@define('STATICPAGE_SHOWONNAVI_DESC', '이 페이지를 옆줄에 나타나는 페이지 링크에 보이게 합니다.');

@define('STATICPAGE_SHOWNAVI_DEFAULT', '상단 링크 보이기');
@define('STATICPAGE_SHOWNAVI_DEFAULT_DESC', '새 페이지의 기본 설정입니다.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', '옆줄 링크에 보이기');
@define('STATICPAGE_SHOWONNAVI_DEFAULT_DESC', '새 페이지의 기본 설정입니다.');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', '마크업 보이기');
@define('STATICPAGE_SHOWMARKUP_DEFAULT_DESC', '새 페이지의 기본 설정입니다.');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', '일반 글 형태로 보이기');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT_DESC', '새 페이지의 기본 설정입니다.');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', '하위 페이지 보이기');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT_DESC', '새 페이지의 기본 설정입니다.');

@define('STATICPAGE_PUBLISHSTATUS', '게시 상태');
@define('STATICPAGE_PUBLISHSTATUS_DESC', '이 페이지의 게시 설정 상태입니다.');
@define('STATICPAGE_PUBLISHSTATUS_DRAFT', '초안');
@define('STATICPAGE_PUBLISHSTATUS_PUBLISHED', '게시');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', '상단 링크에 헤드라인 또는 이전/다음 링크 보이기');
@define('STATICPAGE_SHOWTEXTORHEADLINE_DESC', '');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', '글: 이전/다음');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', '헤드라인');

@define('PLUGIN_STATICPAGELIST_NAME',              '고정 페이지 목록');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',         '이 플러그인은 자유자재로 설정 가능한 고정 페이지를 보여줍니다. 고정 페이지 플러그인 1.22 이상이 필요합니다.');
@define('PLUGIN_STATICPAGELIST_TITLE',             '제목');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',        '옆줄에 보여질 제목을 입력하시오:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',     '고정 페이지');
@define('PLUGIN_STATICPAGELIST_LIMIT',             '표시할 글의 수');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',        '옆줄에 보여질 고정 페이지의 수를 입력하시오.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',    '첫 페이지 링크 보이기');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',    '첫 페이지로 걸리는 링크를 만듭니다.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME','첫 페이지');
@define('PLUGIN_LINKS_IMGDIR',                     '플러그인 그림 디렉토리 사용');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',            '트리 구조 그림을 불러들이는데 쓸 경로를 지정합니다. 이 디렉토리에 "img"라는 하위 디렉토리가 있어야 합니다. 기본적으로 이 플러그인에 포함되어 있습니다.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',    '아이콘 모양 또는 일반 텍스트');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',    '트리 구조로 보여줄지 일반 텍스트 형식의 메뉴로 보여줄지 결정합니다.');
@define('PLUGIN_STATICPAGELIST_ICON',              '트리');
@define('PLUGIN_STATICPAGELIST_TEXT',              '텍스트');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',       '상위 페이지만 보여주기');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',  '사용할 경우, 상위 페이지만 나타나게 됩니다. 사용하지 않으면 하위 페이지도 보입니다.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',          '트리 구조에 그림 사용');
@define('PLUGIN_STATICPAGELIST_SELECTPAGES',       '페이지 선택');
@define('PLUGIN_STATICPAGELIST_SELECTPAGES_DESC',  '첫 페이지에 나타낼 상위 페이지를 고릅니다.');

?>