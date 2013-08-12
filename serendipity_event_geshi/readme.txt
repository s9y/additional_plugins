
------------------------
About
------------------------
This plugin allows you to embed code snippets from various computer languages in your articles,
and have the code color/syntax hi-lighted, and optionally have the lines numbered.  Line numbering
is done with styles so visitors can still cut and paste your code, without having the line numbers
interfere with the code.

It is based on the GeSHi generic syntax highlighter library (included with the plugin).  GeSHi's
home page is http://qbnz.com/highlighter/.

The GeSHi plugin was written by David Rolston.  If you have questions or suggestions, you can
visit my website forum, available from my homepage -> http://www.gizmola.com/


------------------------
Upgrades
------------------------
If you are replacing version .01, you will either have to uninstall and reinstall the Geshi plugin, or
use the http://yourblog/admin to go into the geshi plugin configuration screen and re-save the settings.
This was necessitated by the addition of the geshi path configuration item which was previously hardcoded. 

------------------------
How to use
------------------------
1.Enable this event plugin.  

2. You should make sure that it comes before the NL2BR plugin.  I'd also suggest you order it 
before the BBCode Plugin.  

3. The default settings should be best for most people, with the possible exception of the 
"showlinenumbers" setting, which defaults to off.  If you turn this setting on, your geshi 
blocks will include line numbers without you having to manually override line numbering to on.

When you want to enclose a block use this syntax:

[geshi lang=name] Code here [/geshi]

For a list of supported languages and the language name to use, look in the /geshi directory.  Each supported
language has a name.php file.

Here's a few of the more popular decodes:
c - (C language)
cpp (C++)
java
php
actionscript
javascript
python
css
sql

Each Article can have as many geshi blocks as desired.  There is no problem having multiple geshi blocks
with different languages in the same article.

------------------------
Override line numbering
------------------------
If you want to add or remove line numbering explicitly, you can use the optional ln= parameter.
The options are ln={y|n} where y = yes (on) and n = no (off).  So for example, to turn on line numbering
in a php block you would use:

[geshi lang=php ln=y]...php code [/geshi]

Unlike html, the ln parameter must come AFTER the lang parameter.

------------------------
Known issues
------------------------
This version is now stable beta!!! Use at your own risk (although risks are probably minimal).  

-Line numbering will start on the tag line, so if you don't want extra blank numbered lines, code must
immediately follow the block tag.

-Unlike html, the ln parameter must come AFTER the lang parameter.  If you use ln= first, your geshi
block will not work.

------------------------
An Example (c++)
------------------------

[geshi lang=cpp]
double CAAPluto::EclipticLongitude(double JD)
{
  double T = (JD - 2451545) / 36525;
  double J = 34.35 + 3034.9057*T;
 
  //Calculate Longitude
  double L = 0;
  int nPlutoCoefficients = sizeof(g_PlutoArgumentCoefficients) / sizeof(PlutoCoefficient1);
  for (int i=0; i<nPlutoCoefficients; i++)
  {
    double Alpha = g_PlutoArgumentCoefficients[i].J * J +  g_PlutoArgumentCoefficients[i].S * S + g_PlutoArgumentCoefficients[i].P * P;
    Alpha = CAACoordinateTransformation::DegreesToRadians(Alpha);
    L += ((g_PlutoLongitudeCoefficients[i].A * sin(Alpha)) + (g_PlutoLongitudeCoefficients[i].B * cos(Alpha)));
  }
  L = L / 1000000;
  L += (238.958116 + 144.96*T);
  L = CAACoordinateTransformation::MapTo0To360Range(L);

  return L;
}
[/geshi]
