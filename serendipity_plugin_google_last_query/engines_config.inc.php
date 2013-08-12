<?php # 
/*
 * Created on 05.06.2009
 *
 */
global $serendipity_plugin_google_last_query_engines;
global $serendipity_plugin_google_last_query_engine_configuration;
global $serendipity_plugin_google_last_query_ref_search;
global $serendipity_plugin_google_last_query_vis_search;

$serendipity_plugin_google_last_query_engines = array(
    'Google',
    'Yahoo',
    'Bing',
    'Scroogle',
    'T-Online',
    'Freenet',
    'ixquick',
    'Web.de',
    '1und1',
    'MySpace',
    'Metager2'
);

$serendipity_plugin_google_last_query_engine_configuration =  array( 
                    // 0: regPart host | 1: regQueryPar | 2: linkQueryPar 
    'Google'    => array('\.google\.','q|query','query'),
    'Yahoo'     => array('\.yahoo\.com','p','p'),
    'Bing'      => array('\.bing\.','q','q'),
    'Scroogle'  => array('\.scroogle\.org','Gw','Gw'),
    'T-Online'  => array('suche\.t-online\.de','q','q'),
    'Freenet'   => array('suche\.freenet\.de','query','query'),
    'ixquick'   => array('ixquick\.com','query','query'),
    'Web.de'    => array('suche\.web\.de','su','su'),
    '1und1'     => array('search\.1und1\.de','su','su'),
    'MySpace'   => array('searchservice\.myspace\.com','qry','qry'),
    'Metager2'  => array('metager2\.de','q','q')
);

$serendipity_plugin_google_last_query_ref_search = array(
    'Google'      => "(host like '%.google.%' and path like '/search')",
    'Yahoo'       => "(host like '%.search.yahoo.com' and path like '/search%')",
    'Bing'        => "(host like 'www.bing.com' and path like '/search')",
    'Scroogle'    => "(host like '%.scroogle.org' and path like '/cgi-bin/nbbw.cgi' and query like 'Gw=%')",
    'T-Online'    => "(host like '%.suche.t-online.de' and path like '/fast-cgi/tsc')",
    'Freenet'     => "(host like '%.suche.freenet.de' and path like '/suche')",
    'ixquick'     => "(host like '%.ixquick.com' and path like '/do/metasearch.pl'  and query like 'query=%')",
    'Web.de'      => "(host like '%.suche.web.de' and path like '/search/%'  and query like 'su=%')",
    '1und1'       => "(host like '%.search.1und1.de' and path like '/search/%'  and query like 'su=%')",
    'MySpace'     => "(host like 'searchservice.myspace.com'  and query like 'qry=%')",
    'Metager2'    => "(host like '%metager2.de'  and query like 'q=%')"
);


$serendipity_plugin_google_last_query_vis_search = array(
    'Google'      => "(ref like 'http://www.google.%' and ref like '%search?%')",
    'Yahoo'       => "(ref like '%.search.yahoo.com/search%')",
    'Bing'        => "(ref like 'http://www.bing.com/search%')",
    'Scroogle'    => "(ref like '%scroogle.org/cgi-bin/nbbw.cgi%')",
    'T-Online'    => "(ref like 'http://suche.t-online.de/fast-cgi%')",
    'Freenet'     => "(ref like 'http://suche.freenet.de/suche%')",
    'ixquick'     => "(ref like '%ixquick.com/do/metasearch.pl%')",
    'Web.de'      => "(ref like '%suche.web.de/search%')",
    '1und1'       => "(ref like '%search.1und1.de/search%')",
    'MySpace'     => "(ref like 'http://searchservice.myspace.com%' and ref like '%qry=%')",
    'Metager2'    => "(ref like '%metager2.de/search/index.php%')"
);


