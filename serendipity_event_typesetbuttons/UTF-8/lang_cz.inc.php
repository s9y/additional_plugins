<?php # $Id: lang_cz.inc.php,v 1.1 2007/12/03 11:30:07 garvinhicking Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/30
 */

@define('PLUGIN_EVENT_TYPESETBUTTONS_TITLE',                    'Rozšířená tlačítka pro ne-WYSIWYG editor');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DESC',                     'Přidá tlačítka pro vložení kódů různých html entit (čárky, tečky, uvozovky) + další akce.');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SPACE_BUTTON',             'Mez');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_SPACE_BUTTON',      'Povol zobrazit tlačítko "Nedělitelná mezera".');
@define('PLUGIN_EVENT_TYPESETBUTTONS_AMP_BUTTON',               '&');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_AMP_BUTTON',        'Povol zobrazit tlačítko "Ampersand" ');
@define('PLUGIN_EVENT_TYPESETBUTTONS_EMDASH_BUTTON',            '&mdash;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_EMDASH_BUTTON',     'Povol zobrazit tlačítko "em pomlčka" ');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENDASH_BUTTON',            '&ndash;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_ENDASH_BUTTON',     'Povol zobrazit tlačítko "en pomlčka"');
@define('PLUGIN_EVENT_TYPESETBUTTONS_BULLET_BUTTON',            '&bull;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_BULLET_BUTTON',     'Povol zobrazit tlačítko "Tečka"');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_DQUOTES_BUTTON',    'Povol zobrazit tlačítko "Dvojité uvozovky"');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_SQUOTES_BUTTON',    'Povol zobrazit tlačítko "Jednoduché uvozovky"');
@define('PLUGIN_EVENT_TYPESETBUTTONS_APOS_BUTTON',              '&apos;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_APOS_BUTTON',       'Povol zobrazit tlačítko "Apostrof"');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ACCENT_BUTTON',            '&nbsp;&#x0301;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_ACCENT_BUTTON',     'Povol zobrazit tlačítko "Akcent" (čárka)');
@define('PLUGIN_EVENT_TYPESETBUTTONS_GACCENT_BUTTON',           '&nbsp;&#x0300;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_GACCENT_BUTTON',    'Povol zobrazit tlačítko "Grave" (obrácený akcent)');
@define('PLUGIN_EVENT_TYPESETBUTTONS_STRIKE_BUTTON',            'Škrt');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_STRIKE_BUTTON',     'Povol zobrazit tlačítko "Přeškrtnutí"');
@define('PLUGIN_EVENT_TYPESETBUTTONS_CENTER_BUTTON',            'Centrovat');
@define('PLUGIN_EVENT_TYPESETBUTTONS_ENABLE_CENTER_BUTTON',     'Povol zobrazit tlačítko "Vycentrovat"');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES1',                'Typ 1');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES2',                'Typ 2');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES3',                'Typ 3');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES4',                'Typ 4');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES5',                'Typ 5');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES6',                'Typ 6');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES7',                'Typ 7');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES8',                'Typ 8');
@define('PLUGIN_EVENT_TYPESETBUTTONS_TYPE_DQUOTES_NOTE',        "Dvojitých uvozovek může být několikero druhů:<br />
<div style=\"margin: auto;\">
<span style=\"padding-left:40px;\">Typ 1: &ldquo;...&rdquo;</span>
<span style=\"padding-left:40px;\">Typ 2: &bdquo;...&ldquo;</span>
<span style=\"padding-left:40px;\">Typ 3: &bdquo;...&rdquo;</span>
<span style=\"padding-left:40px;\">Typ 4: &rdquo;...&rdquo;</span>
</div><div style=\"margin: auto;\">
<span style=\"padding-left:40px;\">Typ 5: &ldquo;...&bdquo;</span>
<span style=\"padding-left:40px;\">Typ 6: &laquo;&nbsp;...&nbsp;&raquo;</span>
<span style=\"padding-left:40px;\">Typ 7: &raquo;...&laquo;</span>
<span style=\"padding-left:40px;\">Typ 8: &raquo;...&raquo;</span>
</div>");
@define('PLUGIN_EVENT_TYPESETBUTTONS_TYPE_DQUOTES_BUTTON',      'Vyber typ dvojitých uvozovek, který se má použít');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES1_BUTTON',         '&ldquo; &rdquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES2_BUTTON',         '&bdquo; &ldquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES3_BUTTON',         '&bdquo; &rdquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES4_BUTTON',         '&rdquo; &rdquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES5_BUTTON',         '&ldquo; &bdquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES6_BUTTON',         '&laquo;&nbsp; &nbsp;&raquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES7_BUTTON',         '&raquo; &laquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_DBQUOTES8_BUTTON',         '&raquo; &raquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES1',                 'Typ 1');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES2',                 'Typ 2');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES3',                 'Typ 3');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES4',                 'Typ 4');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES5',                 'Typ 5');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES6',                 'Typ 6');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES7',                 'Typ 7');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES8',                 'Typ 8');
@define('PLUGIN_EVENT_TYPESETBUTTONS_TYPE_SQUOTES_NOTE',        "Jednoduchých uvozovek může být několikero druhů:<br />
<div style=\"margin: auto;\">
<span style=\"padding-left:40px;\">Typ 1: &lsquo;...&rsquo;</span>
<span style=\"padding-left:40px;\">Typ 2: &sbquo;...&lsquo;</span>
<span style=\"padding-left:40px;\">Typ 3: &sbquo;...&rsquo;</span>
<span style=\"padding-left:40px;\">Typ 4: &rsquo;...&rsquo;</span>
</div><div style=\"margin: auto;\">
<span style=\"padding-left:40px;\">Typ 5: &lsquo;...&sbquo;</span>
<span style=\"padding-left:40px;\">Typ 6: &lsaquo;...&rsaquo;</span>
<span style=\"padding-left:40px;\">Typ 7: &rsaquo;...&lsaquo;</span>
<span style=\"padding-left:40px;\">Typ 8: &rsaquo;...&rsaquo;</span>
</div>");
@define('PLUGIN_EVENT_TYPESETBUTTONS_TYPE_SQUOTES_BUTTON',      'Vyber typ jednoduchých uvozovek, který se má použít');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES1_BUTTON',          '&lsquo; &rsquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES2_BUTTON',          '&sbquo; &lsquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES3_BUTTON',          '&sbquo; &rsquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES4_BUTTON',          '&rsquo; &rsquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES5_BUTTON',          '&lsquo; &sbquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES6_BUTTON',          '&lsaquo; &rsaquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES7_BUTTON',          '&rsaquo; &lsaquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_SQUOTES8_BUTTON',          '&rsaquo; &rsaquo;');
@define('PLUGIN_EVENT_TYPESETBUTTONS_REAL_APOS',                'Použít skutečný apostrof (pokud není vybráno, tlačítko vloží "pravou jednoduchou uvozovku")');
@define('PLUGIN_EVENT_TYPESETBUTTONS_USED_NAMED_ENTS',          'Použít pojmenované entity, kde to jen jde. Pojmenované entity mohou rozhodit některé typy xml výstupů.');

@define('PLUGIN_EVENT_TYPESETBUTTONS_CUSTOM',                   'Volitelné HTML tagy');
@define('PLUGIN_EVENT_TYPESETBUTTONS_CUSTOM_DESC',              'Tady můžete zadat seznam libovolných HTML tagů, které chcete přidat do lišty se speciálními tlačítky. Formát je: Nadpis@<otevírací tag>@<uzavírací tag>. Různé tagy jsou odděleny znakem | (roura - pipe). Příklad: MojeCitace@<div class="MojeCitace">@</div>|Vystraha@<script type="text/javascript">alert(\'@\');</script>. Pokud nepotřebujete uzavírací tag, nechte jeho místo jednoduše nevyplněné. Příklad: MůjObrázek@<img src="blabla.gif">@');
