<?php
// Be nice to the frontend users. They don't need the additional constants and file lookups. Only load them when in Admin mode.
if ($serendipity['GET']['adminModule'] == 'templates' || $serendipity['POST']['adminModule'] != 'templates') {
    // Probe for a language include with constants. Still include defines later on, if some constants were missing
    $probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
    if (file_exists($probelang)) {
        include $probelang;
    } 
    
    include dirname(__FILE__) . '/lang_en.inc.php';
}

$template_config = array(
    array(
	'var'           => 'header_img',
	'name'          => 'Header Image',
	'description'   => 'TESTING/UNUSED: image for header of blog',
	'type'          => 'media',
	'preview_width' => '500px',
	'preview_height' => '100px',
	'default'       => serendipity_getTemplateFile('header.png'),
    ),
    array(
        'var'           => 'colorset',
        'name'          => THEME_COLORSET,
        'description'   => THEME_COLORSET_DESC,
        'type'          => 'select',
        'default'       => 'blue',
        'select_values' => array('default' => 'Default Blue', 'grey' => 'Grey Monotone', 'caramel' => 'Caramel', 'modern' => 'Modern Blue and Green')
    ),
    array(
        'var'           => 'entryfooterposition',
        'name'          => FOOTER_POSITION,
        'description'   => FOOTER_POSITION_DESC,
        'type'          => 'radio',
        'radio'         => array('value' => array('true', 'false'),
                                 'desc'  => array(SMALL_BOX, BELOW_ENTRY)),
        'default'       => 'true',
    ),
    array(
        'var'           => 'amount',
        'name'          => 'Number of navlinks',
        'description'   => 'Enter the number of navlinks you want to use in the navbar.',
        'type'          => 'string',
        'default'       => '5',
    ),
);
if (version_compare($serendipity['version'],"1.1.beta3") >= 0) {
$vars = serendipity_loadThemeOptions($template_config);

$navlinks = array();

for ($i = 0; $i < $vars['amount']; $i++) {
    $navlinks[] = array(
        'title' => $vars['navlink' . $i . 'text'],
        'href'  => $vars['navlink' . $i . 'url']
    );
    $template_config[] = array(
        'var'           => 'navlink' . $i . 'text',
        'name'          => NAV_LINK_TEXT . ' #' . $i,
        'description'   => NAV_LINK_DESC . ' #' .$i,
        'type'          => 'string',
        'default'       => constant('NAV_DEFAULT_' . $i),
	);
    $template_config[] = array(
        'var'           => 'navlink' . $i . 'url',
        'name'          => NAV_LINK_URL . ' #' . $i,
        'description'   => NAV_LINK_URL_DESC . ' #' . $i,
        'type'          => 'string',
        'default'       => '#',
    );
}
$serendipity['smarty']->assign_by_ref('navlinks', $navlinks);
}
