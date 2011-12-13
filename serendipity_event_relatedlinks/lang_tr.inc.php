<?php # $Id: lang_tr.inc.php,v 1.1 2006/07/24 08:32:47 garvinhicking Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Ahmet Usal <ahmetusal@gmail.com>
 *  First public version: lang_tr.inc.php
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'Ýlgili yazýlar/makaleler/web baðlantýlarý');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Yazý baþýna konuyla ilgili sitede mevcut yazý-makale ya da site dýþý web baðlantýsý ekle. Ölçeklenebilirlik amacýyla  "plugin_relatedlinks.tpl" adlý Smarty-Þablon dosyasýný düzenleyerek web sayfasý çýktýný istediðin görünümde oluþturabilirsin.Not: Bu eklenti sadece yazýnýn ayrýntýlý-tam gösterimi sýrasýnda etkin olur.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Göstermek istediðiniz ilgili web baðlantýsýný yazýn. Her satýr için bir URL adresi (HTML kodu içermesin!)  (altsatýrlar yeni satýrbaþlarý anlamýna gelir)yazýn. Açýklama eklemek isterseniz, þu formatý kullanabilirsiniz: http://ornek.com/link.html=Ornek Link. Þu iþaretten sonraki herþey "=" açýklama amacýyla kullanýlacaktýr. Eðer açýklama yazmazsanýz, sadece web baðlantýnýz baþlýk olarak görüntülenecektir.');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'Ýlgili Web Baðlantýlarý:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'Ýlgili yazýlar/web baðlantýlarý için yerleþim düzeni');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Yazýnýzýn altýna ilgili makale ve web baðlantýlarýný ekleme ya da Smarty Þablonlama sistemini kullanma seçeneðidir. Eðer Smarty þablonlama sistemini etkin kýlarsanýz, þu aþaðýdaki satýrý entries.tpl þablon dosyanýza, foreach döngüsünde $entry deðiþkeni neredeyse  oraya eklemeniz gerekmektedir.(burada görüþler, izdüþümleri ve yazýnýn daha fazla yazý ekleme gövde bölgesi gösterilmektedir): {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Yazý altýna yerleþtir');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Yazýnýn içine yerleþtir');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Smarty çaðrýsý kullan');

@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', 'Baðlantý ayýrma karakteri');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', 'Yazýnýzdaki URL adreslerini ve açýklamalarý ayýracak bir harf karakteri ekleyin. Bu karakterin URL ya da baþlýkta mevcut olmadýðýna emin olun, bunun gibi bir karakterle ayrým yapýn: "|".');

?>
