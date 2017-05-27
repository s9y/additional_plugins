<?php

@define('DEJURE_TITLE', 'dejure.org automatic linking');
@define('DEJURE_DESCRIPTION', 'Automatically links quoted statues and judicature (references and source of information) with contents of dejure.org.');
@define('DEJURE_MAIL', 'Email address of blog owner');
@define('DEJURE_MAIL_DESC', 'This information is sent to dejure.org to provide a contact address when problems arise. No data is used or forwarded for marketing reasons or similar!');
@define('DEJURE_NEWSLETTER', 'Newsletter');
@define('DEJURE_NEWSLETTER_DESC', 'I want to subscribe to updates to the dejure.org service.');
@define('DEJURE_TARGET', 'Open links...');
@define('DEJURE_TARGET_DESC', 'The "target" attribute of the generated links. Leave empty to open links in the same borwser window or frame, use "_blank" top open them in a new browser window.');
@define('DEJURE_CSS', 'CSS class for dejure.org links');
@define('DEJURE_CSS_DESC', '');
@define('DEJURE_LINKSTYLE', 'Style of dejure.org links');
@define('DEJURE_LINKSTYLE_DESC', 'Generated links will span just the article or section number (§ _242_ BGB; §§ _278_, _254_ BGB) or include paragraphs or the abbreviation of the statute (_§ 242 BGB_; _§§ 278_, _254 BGB_).');
@define('DEJURE_LINKSTYLE_SHORT', 'Only link from article/section numbers');
@define('DEJURE_LINKSTYLE_WIDE', 'Use wide linking');
@define('DEJURE_NOHEADINGS', 'Exclude headings');
@define('DEJURE_NOHEADINGS_DESC', 'Do not create links in headings (<h1> bis <h9>).');
@define('DEJURE_BUZER', 'Also link to buzer.de');
@define('DEJURE_BUZER_DESC', 'Link to buzer.de for statutes that are not available at dejure.org.');
@define('DEJURE_CACHE', 'Purge cache');
@define('DEJURE_CACHE_DESC', 'Completely purge the cache - necessary after changes to link targets ("Open links..."), CSS class, style or linking to buzer.de.');
