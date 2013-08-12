<?php # 

/**
 *  @version $Revision$
 *  @author Tadashi Jokagi <elf2000@users.sourceforge.net>
 *  EN-Revision: 1.1
 */

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'カテゴリのプロパティとテンプレート');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'このプラグインは、選択されたカテゴリに依存するテンプレートと他のいくつかのプロパティを変更することを可能にします。');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'このカテゴリで使用したいテンプレートのディレクトリ名を入力してください。相対ディレクトリ名は templates/ 構造で始まります。従って例えば「blue」や「kubrick」を使うことができます。You can also enter a subdirectory name, if you saved a subdirectory within your template directory as if it were a template on its own. Then you can enter i.e. "blue/category1" or "blue/category2".');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Entries to display on category frontpage');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'パスワード保護:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'カテゴリのパスワード保護の許可をするべきですか? The drawbacks are that another database lookup needs to be made, and that entries in password-protected categories are NOT shown on the frontpage for users until they go to the protected category\'s view.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Serendipity カテゴリのパスワード保護');

?>
