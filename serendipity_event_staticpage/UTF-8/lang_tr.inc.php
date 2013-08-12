<?php #  

/**
 *  @author Ahmet Usal <ahmetusal@gmail.com>
 *  First public version: lang_tr.inc.php
 */

@define('STATICPAGE_HEADLINE', 'Başlıklar');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Başlıkları içerikten üstte öncelikli göster');
@define('STATICPAGE_TITLE', 'Statik Sayfalar');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Statik sayfalar site içerisinde tasarım ve tüm biçimlemeye dahil olsun. Yönetim arabirimine yeni menü unsuru olarak eklensin.');
@define('CONTENT_BLAHBLAH', 'içerik');
@define('STATICPAGE_PERMALINK', 'Kalıcı Bağlantı');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'URL adresleri için kalıcı bağlantı tanımı. Kesin HTTP yolunun belirtilmesi ve sonunun .htm ya da .html olarak bitmesi gerekli!');
@define('STATICPAGE_PAGETITLE', 'URL adresinin kısa adlandırması (Geriye doğru uyumluluk amacıyla)');
@define('STATICPAGE_ARTICLEFORMAT', 'Makale gibi biçimlensin mi?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'Evet seçeneği işaretlenirse  sitedeki bir makale, yazı gibi biçimlendirilecek. (renkler, kenarlıklar vb.) (öntanımlı : evet)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Sayfa Başlığı "Makale olarak biçimlendir" modunda');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Makale biçimini kullanırken, yayınlanma tarihine göre hangi metni gösterilebileceğinizi seçebildiğiniz gibi statik sayfanıza da belirli bir yayın tarihindeki makalelerle beraber gösterilecek şekilde yayınlayabilirsiniz.');
@define('STATICPAGE_SELECT', 'Düzenlemek ya da oluşturmak için bir statik sayfa biçimi seçin.');
@define('STATICPAGE_PASSWORD_NOTICE', 'Bu safya şifre korumalı. Lütfen korumayı kaldırmak için size verilen şifreyi yazın: ');
@define('STATICPAGE_PARENTPAGES_NAME', 'üst Sayfa');
@define('STATICPAGE_PARENTPAGE_DESC', 'Sayfanızın bağlı olmasını istediğiniz üst sayfayı seçin');
@define('STATICPAGE_PARENTPAGE_PARENT', 'üst Sayfa olarak');
@define('STATICPAGE_AUTHORS_NAME', 'Yazar\Yazarların Adı');
@define('STATICPAGE_AUTHORS_DESC', 'Bu yazar bu sayfanın sahibidir.');
@define('STATICPAGE_FILENAME_NAME', 'Şablon (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Bu sayfa için kullanmak istediğiniz Şablon dosyasının adını yazın. Bu smarty dosyası eklentileriniz ya da Şablonlarınızın bulunduğu dizine yerleştirilecek.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Alt Sayfaları göster');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Bu sayfaya bağlı tüm alt sayfaları bağlantılar listesinde güsterir.');
@define('STATICPAGE_PRECONTENT_NAME', 'ön-içerik');
@define('STATICPAGE_PRECONTENT_DESC', 'Bu içeriği kendisine bağlı alt sayfaların listesinden önce gösterir.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Bu sayfa bu durumdayken silinemez.Çünkü alt sayfaları veritabanına kayıtlı durumda.Lütfen önce bu sayfaya bağlı alt sayfaları silin.');
@define('STATICPAGE_IS_STARTPAGE', 'Bu sayfayı Serendipity anasayfası yap');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'öntanımlı olarak gösterilen Serendipity başlangıç sayfası yerine bu statik sayfa gösterilecek. Sadece bir sayfa başlangıç sayfası(Ana Sayfa) olarak tanımlanabilir! Öntanımlı olarak kullanılan Serendipity Anasayfasına bağlantı vermek istiyorsanız, "index.php?frontpage" bağlantı kalıbını kullanabilirsiniz.Bu özelliği kullanmak istiyorsanız, başka bir kalıcı bağlantı eklentisinin, Serendipity yapılandırma sıralamasında statik sayfa eklentisinden önce gelmediğine emin olmalısınız.(Anket, Konuk Defteri eklentileri vb.).');
@define('STATICPAGE_TOP', 'YUKARI');
@define('STATICPAGE_NEXT', 'Sonraki');
@define('STATICPAGE_PREV', 'Önceki');
@define('STATICPAGE_LINKNAME', 'Düzenle');

@define('STATICPAGE_ARTICLETYPE', 'Makale türü');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Statik Sayfa olarak belirlemek istediğiniz türü seçin.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Sayfa Sıralaması');
@define('STATICPAGE_CATEGORY_PAGES', 'Sayfaları Düzenle');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Sayfa Türleri');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Diğer Eklentiler');

@define('PAGETYPES_SELECT', 'Bir sayfa türü seçin.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Açıklama:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Sayfa türünün açıklaması.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Şablon Adı:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Şablondan isim. Statik Sayfa eklentisinde ya da ön tanımlı Şablon dizininizde mevcut olmalı.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Resim yolu:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'Kullanılacak resmin URL adresi.');

@define('STATICPAGE_SHOWNAVI', 'Site Menüsünü göster');
@define('STATICPAGE_SHOWNAVI_DESC', 'Bu sayfada site menüsünü göster.');
@define('STATICPAGE_SHOWONNAVI', 'Yan-blok menüsünde göster');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Bu sayfayı yan-blok menüsünde göster.');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Site Menüsünde göster');
@define('STATICPAGE_DEFAULT_DESC', 'Yeni sayfalar için öntanımlı ayardır.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Sayfayı Site Yan-Bloktaki menüde göster.');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'İşaretleme dilini göster');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Makale olarak biçimle');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Sayfaya bağlı altsayfaları göster.');

@define('STATICPAGE_PAGEORDER_DESC', 'Buradan statik sayfalarınızın gösterilme sırasını değiştirebilirsiniz.');
@define('STATICPAGE_PAGEADD_DESC', 'Statik Sayfalar menüsüne eklemek istediğiniz siteyi seçin.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'Aşağıda sıralanan eklentiler yanbloktaki statik sayfalar menüsüne eklenebilir.');

@define('STATICPAGE_PUBLISHSTATUS', 'Yayınlama-Durumu');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Bu sayfanın yayın durumu.');
@define('STATICPAGE_PUBLISHSTATUS_DRAFT', 'Taslak');
@define('STATICPAGE_PUBLISHSTATUS_PUBLISHED', 'Yayında');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Menüde başlığı ya da Önceki/Sonraki linklerini göster.');
@define('STATICPAGE_SHOWTEXTORHEADLINE_DESC', '');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Metin: Önceki/Sonraki');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Başlık');

@define('STATICPAGE_LANGUAGE', 'Dil');
@define('STATICPAGE_LANGUAGE_DESC', 'Bu bülümde kulllanılacak dili seçin.');

@define('STATICPAGE_PLUGINS_INSTALLED', 'Eklenti kurulu');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Eklenti kurulabilir');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'Eklenti kurulamaz');

@define('LANG_ALL', 'Tüm Diller');
@define('LANG_EN', 'İngilizce');
@define('LANG_DE', 'Almanca');
@define('LANG_DA', 'Danimarkaca');
@define('LANG_ES', 'İspanyolca');
@define('LANG_FR', 'Fransızca');
@define('LANG_FI', 'Fince');
@define('LANG_CS', 'Çekce (Win-1250)');
@define('LANG_CZ', 'Çekce (ISO-8859-2)');
@define('LANG_NL', 'Flemenkçe');
@define('LANG_IS', 'İzlandaca');
@define('LANG_PT', 'Portekiz Brezilcesi');
@define('LANG_BG', 'Bulgarca');
@define('LANG_NO', 'Norveçce');
@define('LANG_RO', 'Rumence');
@define('LANG_IT', 'İtalyanca');
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
@define('PLUGIN_STATICPAGELIST_NAME_DESC',              'Bu eklenti statik sayfaların yapılandırılabilir bir listesini gösterir. Bu işlemin gerçekleşebilmesi için Statik Sayfa Eklentisinin 1.22 ya da daha yüksek bir sürümünün kurulu olması gereklidir.');
@define('PLUGIN_STATICPAGELIST_TITLE',                  'Başlık');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',             'Yan-Blokta gösterilecek başlığını yazın:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',          'Statik Sayfalar');
@define('PLUGIN_STATICPAGELIST_LIMIT',                  'Gösterilecek Statik Sayfa Sayısı');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',             'Gösterilecek Statik Sayfa Sayısını yazın. 0, sınır yok anlamındadır.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',         'Anasayfa bağlantısını göster');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',         'Anasayfada bağlantı oluştur');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',     'Anasayfa');
@define('PLUGIN_LINKS_IMGDIR',                          'Eklenti resim dizinini kullan');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',                 'Resimlere ulaşılabilmesi için URL adresi yolunu belirtin. "img" altdizini bu tanımlanacak üst dizine ihtiyaç duyar ve bu eklentiyle anılan dizini kullanabilir.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',         'İkonlar ya da düz metin');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',         'Dizinlerin ağaç yapısını grafik ikonlarla ya da düz metin olarak gösterir.');
@define('PLUGIN_STATICPAGELIST_ICON',                   'Ağaç Yapısı');
@define('PLUGIN_STATICPAGELIST_TEXT',                   'Düz Metin');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',            'Sadece üst-ebeveyn sayfalar gösterilsin mi?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',       'Eğer bu seçenek etkin olursa sadece üst-ebeveyn sayfalar gösterilir. Etkinleştirilmezse üst sayfalara bağlı altsayfalarda gösterilir.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',               'Ağaç Yapısında grafik gösterim etkin');

?>
