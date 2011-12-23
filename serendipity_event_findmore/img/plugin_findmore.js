function toggleSwitcher($switcher, path) {
    var on = path+'socialshareprivacy_on.png';
    var off = path+'socialshareprivacy_off.png';
    $switcher.active = ! $switcher.active
    if ($switcher.active) {
        $switcher.attr('src', on);
        return;
    }
    $switcher.attr('src', off);
}

function toggleButton($button, $dummy, $switcher, path) {
    if ($switcher.active) {
        $dummy.replaceWith($button);
        return;
    }
    $button.replaceWith($dummy);
    $dummy.click(function() {
        toggleSwitcher($switcher, path);
        toggleButton($button, $dummy, $switcher);
    });
}

function insertLazyLoadButton(button, service, path, desc) {
    var off = path+'socialshareprivacy_off.png';
    var $switcher = jQuery('<img class="'+service+'_lazyload_switcher lazyload_switcher" src="'+off+'" />');
    $switcher.status = false;
    var $dummy = jQuery('<a rel="nofollow" class="'+service+'_dummy"><img src="'+path+service+'_dummy.png" alt="'+desc+'" title="'+desc+'" /></a>');
    var $button = jQuery(button);

    $dummy.click(function() {
        toggleSwitcher($switcher, path);
        toggleButton($button, $dummy, $switcher, path);
    });
    
    $switcher.click(function() {
        toggleSwitcher($switcher, path);
        toggleButton($button, $dummy, $switcher, path);
    });

    
    
    jQuery("script:last").parent().first().append($switcher);
    jQuery("script:last").parent().first().append($dummy);
}