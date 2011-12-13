<?php #  $Id: lang_tr.inc.php,v 1.2 2006/07/18 08:16:53 garvinhicking Exp $

/**
 *  @author Ahmet Usal <ahmetusal@gmail.com>
 *  First public version: lang_tr.inc.php
 */

@define('STATICPAGE_HEADLINE', 'Baþlýklar');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Baþlýklarý içerikten üstte öncelikli göster');
@define('STATICPAGE_TITLE', 'Statik Sayfalar');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Statik sayfalar site içerisinde tasarým ve tüm biçimlemeye dahil olsun. Yönetim arabirimine yeni menü unsuru olarak eklensin.');
@define('CONTENT_BLAHBLAH', 'içerik');
@define('STATICPAGE_PERMALINK', 'Kalýcý Baðlantý');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'URL adresleri için kalýcý baðlantý tanýmý. Kesin HTTP yolunun belirtilmesi ve sonunun .htm ya da .html olarak bitmesi gerekli!');
@define('STATICPAGE_PAGETITLE', 'URL adresinin kýsa adlandýrmasý (Geriye doðru uyumluluk amacýyla)');
@define('STATICPAGE_ARTICLEFORMAT', 'Makale gibi biçimlensin mi?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'Evet seçeneði iþaretlenirse  sitedeki bir makale, yazý gibi biçimlendirilecek. (renkler, kenarlýklar vb.) (öntanýmlý : evet)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Sayfa Baþlýðý "Makale olarak biçimlendir" modunda');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Makale biçimini kullanýrken, yayýnlanma tarihine göre hangi metni gösterilebileceðinizi seçebildiðiniz gibi statik sayfanýza da belirli bir yayýn tarihindeki makalelerle beraber gösterilecek þekilde yayýnlayabilirsiniz.');
@define('STATICPAGE_SELECT', 'Düzenlemek ya da oluþturmak için bir statik sayfa biçimi seçin.');
@define('STATICPAGE_PASSWORD_NOTICE', 'Bu safya þifre korumalý. Lütfen korumayý kaldýrmak için size verilen þifreyi yazýn: ');
@define('STATICPAGE_PARENTPAGES_NAME', 'üst Sayfa');
@define('STATICPAGE_PARENTPAGE_DESC', 'Sayfanýzýn baðlý olmasýný istediðiniz üst sayfayý seçin');
@define('STATICPAGE_PARENTPAGE_PARENT', 'üst Sayfa olarak');
@define('STATICPAGE_AUTHORS_NAME', 'Yazar\Yazarlarýn Adý');
@define('STATICPAGE_AUTHORS_DESC', 'Bu yazar bu sayfanýn sahibidir.');
@define('STATICPAGE_FILENAME_NAME', 'Þablon (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Bu sayfa için kullanmak istediðiniz Þablon dosyasýnýn adýný yazýn. Bu smarty dosyasý eklentileriniz ya da Þablonlarýnýzýn bulunduðu dizine yerleþtirilecek.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Alt Sayfalarý göster');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Bu sayfaya baðlý tüm alt sayfalarý baðlantýlar listesinde güsterir.');
@define('STATICPAGE_PRECONTENT_NAME', 'ön-içerik');
@define('STATICPAGE_PRECONTENT_DESC', 'Bu içeriði kendisine baðlý alt sayfalarýn listesinden önce gösterir.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Bu sayfa bu durumdayken silinemez.Çünkü alt sayfalarý veritabanýna kayýtlý durumda.Lütfen önce bu sayfaya baðlý alt sayfalarý silin.');
@define('STATICPAGE_IS_STARTPAGE', 'Bu sayfayý Serendipity anasayfasý yap');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'öntanýmlý olarak gösterilen Serendipity baþlangýç sayfasý yerine bu statik sayfa gösterilecek. Sadece bir sayfa baþlangýç sayfasý(Ana Sayfa) olarak tanýmlanabilir! Öntanýmlý olarak kullanýlan Serendipity Anasayfasýna baðlantý vermek istiyorsanýz, "index.php?frontpage" baðlantý kalýbýný kullanabilirsiniz.Bu özelliði kullanmak istiyorsanýz, baþka bir kalýcý baðlantý eklentisinin, Serendipity yapýlandýrma sýralamasýnda statik sayfa eklentisinden önce gelmediðine emin olmalýsýnýz.(Anket, Konuk Defteri eklentileri vb.).');
@define('STATICPAGE_TOP', 'YUKARI');
@define('STATICPAGE_NEXT', 'Sonraki');
@define('STATICPAGE_PREV', 'Önceki');
@define('STATICPAGE_LINKNAME', 'Düzenle');

@define('STATICPAGE_ARTICLETYPE', 'Makale türü');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Statik Sayfa olarak belirlemek istediðiniz türü seçin.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Sayfa Sýralamasý');
@define('STATICPAGE_CATEGORY_PAGES', 'Sayfalarý Düzenle');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Sayfa Türleri');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Diðer Eklentiler');

@define('PAGETYPES_SELECT', 'Bir sayfa türü seçin.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Açýklama:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Sayfa türünün açýklamasý.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Þablon Adý:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Þablondan isim. Statik Sayfa eklentisinde ya da ön tanýmlý Þablon dizininizde mevcut olmalý.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Resim yolu:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'Kullanýlacak resmin URL adresi.');

@define('STATICPAGE_SHOWNAVI', 'Site Menüsünü göster');
@define('STATICPAGE_SHOWNAVI_DESC', 'Bu sayfada site menüsünü göster.');
@define('STATICPAGE_SHOWONNAVI', 'Yan-blok menüsünde göster');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Bu sayfayý yan-blok menüsünde göster.');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Site Menüsünde göster');
@define('STATICPAGE_DEFAULT_DESC', 'Yeni sayfalar için öntanýmlý ayardýr.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Sayfayý Site Yan-Bloktaki menüde göster.');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Ýþaretleme dilini göster');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Makale olarak biçimle');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Sayfaya baðlý altsayfalarý göster.');

@define('STATICPAGE_PAGEORDER_DESC', 'Buradan statik sayfalarýnýzýn gösterilme sýrasýný deðiþtirebilirsiniz.');
@define('STATICPAGE_PAGEADD_DESC', 'Statik Sayfalar menüsüne eklemek istediðiniz siteyi seçin.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'Aþaðýda sýralanan eklentiler yanbloktaki statik sayfalar menüsüne eklenebilir.');

@define('STATICPAGE_PUBLISHSTATUS', 'Yayýnlama-Durumu');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Bu sayfanýn yayýn durumu.');
@define('STATICPAGE_PUBLISHSTATUS_DRAFT', 'Taslak');
@define('STATICPAGE_PUBLISHSTATUS_PUBLISHED', 'Yayýnda');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Menüde baþlýðý ya da Önceki/Sonraki linklerini göster.');
@define('STATICPAGE_SHOWTEXTORHEADLINE_DESC', '');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Metin: Önceki/Sonraki');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Baþlýk');

@define('STATICPAGE_LANGUAGE', 'Dil');
@define('STATICPAGE_LANGUAGE_DESC', 'Bu bülümde kulllanýlacak dili seçin.');

@define('STATICPAGE_PLUGINS_INSTALLED', 'Eklenti kurulu');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Eklenti kurulabilir');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'Eklenti kurulamaz');

@define('LANG_ALL', 'Tüm Diller');
@define('LANG_EN', 'Ýngilizce');
@define('LANG_DE', 'Almanca');
@define('LANG_DA', 'Danimarkaca');
@define('LANG_ES', 'Ýspanyolca');
@define('LANG_FR', 'Fransýzca');
@define('LANG_FI', 'Fince');
@define('LANG_CS', 'Çekce (Win-1250)');
@define('LANG_CZ', 'Çekce (ISO-8859-2)');
@define('LANG_NL', 'Flemenkçe');
@define('LANG_IS', 'Ýzlandaca');
@define('LANG_PT', 'Portekiz Brezilcesi');
@define('LANG_BG', 'Bulgarca');
@define('LANG_NO', 'Norveçce');
@define('LANG_RO', 'Rumence');
@define('LANG_IT', 'Ýtalyanca');
@define('LANG_RU', 'Rusça');
@define('LANG_FA', 'Farsça');
@define('LANG_TR', 'Türkçe (ISO-8859-9)');
@define('LANG_TW', 'Geleneksel Çince (Big5)');
@define('LANG_TN', 'Geleneksel Çince (UTF-8)');
@define('LANG_ZH', 'Basit Çince (GB2312)');
@define('LANG_CN', 'Basit Çince (UTF-8)');
@define('LANG_JA', 'Japonca');
@define('LANG_KO', 'Korece');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',                   'Statik Sayfalar Listesi');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',              'Bu eklenti statik sayfalarýn yapýlandýrýlabilir bir listesini gösterir. Bu iþlemin gerçekleþebilmesi için Statik Sayfa Eklentisinin 1.22 ya da daha yüksek bir sürümünün kurulu olmasý gereklidir.');
@define('PLUGIN_STATICPAGELIST_TITLE',                  'Baþlýk');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',             'Yan-Blokta gösterilecek baþlýðýný yazýn:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',          'Statik Sayfalar');
@define('PLUGIN_STATICPAGELIST_LIMIT',                  'Gösterilecek Statik Sayfa Sayýsý');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',             'Gösterilecek Statik Sayfa Sayýsýný yazýn. 0, sýnýr yok anlamýndadýr.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',         'Anasayfa baðlantýsýný göster');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',         'Anasayfada baðlantý oluþtur');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',     'Anasayfa');
@define('PLUGIN_LINKS_IMGDIR',                          'Eklenti resim dizinini kullan');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',                 'Resimlere ulaþýlabilmesi için URL adresi yolunu belirtin. "img" altdizini bu tanýmlanacak üst dizine ihtiyaç duyar ve bu eklentiyle anýlan dizini kullanabilir.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',         'Ýkonlar ya da düz metin');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',         'Dizinlerin aðaç yapýsýný grafik ikonlarla ya da düz metin olarak gösterir.');
@define('PLUGIN_STATICPAGELIST_ICON',                   'Aðaç Yapýsý');
@define('PLUGIN_STATICPAGELIST_TEXT',                   'Düz Metin');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',            'Sadece üst-ebeveyn sayfalar gösterilsin mi?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',       'Eðer bu seçenek etkin olursa sadece üst-ebeveyn sayfalar gösterilir. Etkinleþtirilmezse üst sayfalara baðlý altsayfalarda gösterilir.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',               'Aðaç Yapýsýnda grafik gösterim etkin');

?>
