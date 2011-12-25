<?php # $Id$

/**
 *  @version $Revision$
 *  @author Ahmet Usal <ahmetusal@gmail.com>
 *  First public version: lang_tr.inc.php
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'İlgili yazılar/makaleler/web bağlantıları');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Yazı başına konuyla ilgili sitede mevcut yazı-makale ya da site dışı web bağlantısı ekle. Ölçeklenebilirlik amacıyla  "plugin_relatedlinks.tpl" adlı Smarty-Şablon dosyasını düzenleyerek web sayfası çıktını istediğin görünümde oluşturabilirsin.Not: Bu eklenti sadece yazının ayrıntılı-tam gösterimi sırasında etkin olur.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Göstermek istediğiniz ilgili web bağlantısını yazın. Her satır için bir URL adresi (HTML kodu içermesin!)  (altsatırlar yeni satırbaşları anlamına gelir)yazın. Açıklama eklemek isterseniz, şu formatı kullanabilirsiniz: http://ornek.com/link.html=Ornek Link. Şu işaretten sonraki herşey "=" açıklama amacıyla kullanılacaktır. Eğer açıklama yazmazsanız, sadece web bağlantınız başlık olarak görüntülenecektir.');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'İlgili Web Bağlantıları:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'İlgili yazılar/web bağlantıları için yerleşim düzeni');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Yazınızın altına ilgili makale ve web bağlantılarını ekleme ya da Smarty Şablonlama sistemini kullanma seçeneğidir. Eğer Smarty şablonlama sistemini etkin kılarsanız, şu aşağıdaki satırı entries.tpl şablon dosyanıza, foreach döngüsünde $entry değişkeni neredeyse  oraya eklemeniz gerekmektedir.(burada görüşler, izdüşümleri ve yazının daha fazla yazı ekleme gövde bölgesi gösterilmektedir): {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Yazı altına yerleştir');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Yazının içine yerleştir');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Smarty çağrısı kullan');

@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', 'Bağlantı ayırma karakteri');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', 'Yazınızdaki URL adreslerini ve açıklamaları ayıracak bir harf karakteri ekleyin. Bu karakterin URL ya da başlıkta mevcut olmadığına emin olun, bunun gibi bir karakterle ayrım yapın: "|".');

?>
