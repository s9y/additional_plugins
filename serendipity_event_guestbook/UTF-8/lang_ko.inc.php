<?php # $Id: lang_ko.inc.php,v 1.2 2005/10/30 00:29:51 wesley96 Exp $
# Translated by: Wesley Hwang-Chung <wesley96@gmail.com> 
# (c) 2005 http://www.tool-box.info/

@define('GUESTBOOK_HEADLINE', '부제목');
@define('GUESTBOOK_HEADLINE_BLAHBLAH', '페이지에 보일 부제목(헤드라인)');
@define('GUESTBOOK_TITLE', '방명록');
@define('GUESTBOOK_TITLE_BLAHBLAH', '사용중인 블로그 디자인을 그대로 따르는 방명록 페이지를 블로그에 보여줌');
@define('GUESTBOOK_PAGETITLE', '제목');
@define('GUESTBOOK_PAGETITLE_BLAHBLAH', '페이지의 제목');
@define('GUESTBOOK_PAGEURL', '고정 주소');
@define('GUESTBOOK_PAGEURL_BLAHBLAH', '페이지의 고정 주소를 정의 (index.php?serendipity[subpage]=name)');
@define('GUESTBOOK_SESSIONLOCK', '세션 잠금');
@define('GUESTBOOK_SESSIONLOCK_BLAHBLAH', '사용할 경우, 한 세션(사용자) 당 한 개의 글만 허용합니다. 때에 따라 좋을 수도, 나쁠 수도 있습니다. 누군가 글을 써놓은 다음 추가로 적으려고 할 수도 있기 때문에...');
@define('GUESTBOOK_TIMELOCK', '시간 잠금');
@define('GUESTBOOK_TIMELOCK_BLAHBLAH', '사용자가 글을 적은 다음 몇 초 후에 다시 글을 적을 수 있는지 정합니다. 더블 클릭에 의한 중복 글이나 스팸 로봇 등을 방지할 때 유용합니다.');
@define('GUESTBOOK_EMAILADMIN', '관리자에 전자우편 발송');
@define('GUESTBOOK_EMAILADMIN_BLAHBLAH', '사용할 경우 글 하나가 기록될 때마다 관리자가 전자우편을 받게 됩니다.');
@define('GUESTBOOK_NUMBER', '페이지 당 글 수');
@define('GUESTBOOK_NUMBER_BLAHBLAH', '한 페이지에 몇 개의 글을 보이도록 하겠습니까?');
@define('GUESTBOOK_WORDWRAP', '한 줄의 글자 수');
@define('GUESTBOOK_WORDWRAP_BLAHBLAH', '몇 자을 초과하면 자동으로 새 줄로 끊도록 하겠습니까?');
@define('GUESTBOOK_SHOWHOMEPAGE', '사용자의 홈페이지 주소 보이기');
@define('GUESTBOOK_SHOWEMAIL', '사용자의 전자우편 주소 보이기');

@define('SUBMIT', '글 적기');
@define('GUESTBOOK_NEXTPAGE', '다음 페이지');
@define('GUESTBOOK_PREVPAGE', '이전 페이지');
@define('TEXT_DELETE', '삭제');
@define('TEXT_SAY', '님의 한 마디');
@define('TEXT_EMAIL', '전자우편');
@define('TEXT_NAME', '이름');
@define('TEXT_HOMEPAGE', '홈페이지');
@define('TEXT_EMAILSUBJECT', '블로그: 새 방명록 글');
@define('TEXT_EMAILTEXT', "%s(이)가 당신의 방명록에 글을 남겼습니다:\n%s");
@define('ERROR_TIMELOCK', '글 두 개를 적을 때에는 최소한 %s초의 간격을 두어야 합니다.');
@define('ERROR_NAMEEMPTY', '이름을 입력하세요.');
@define('ERROR_TEXTEMPTY', '내용을 적어주세요.');
@define('ERROR_OCCURRED', '에러가 발견되었습니다:');
@define('QUESTION_DELETE', '%s의 글을 정말로 삭제하겠습니까?');

@define('PLUGIN_GUESTSIDE_NAME', '옆줄 방명록');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', '옆줄에 최신 방명록 내용을 보여줌');
@define('PLUGIN_GUESTSIDE_TITLE', '제목');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', '옆줄에 표시될 제목 설정');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', '전자우편 주소 보이기');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', '작성자의 전자우편 주소를 보여주겠습니까?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', '홈페이지 주소 보이기');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', '작성자의 홈페이지 주소를 보여주겠습니까?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', '최대 글자 수');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', '내용의 길이를 글자 수로 설정합니다.');
@define('PLUGIN_GUESTSIDE_MAXITEMS', '최대 아이템 수');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', '보여줄 아이템의 수를 설정합니다.');		

?>
