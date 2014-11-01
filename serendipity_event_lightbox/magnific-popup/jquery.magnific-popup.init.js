jQuery(document).ready(function($){

    // remove anchors onclick handler, if have
    $('a[rel^="magnificPopup"]').removeAttr('onclick');
    $('a[rel="onemagnificPopup"]').removeAttr('onclick');

    // get all magnificPopup anchors by group
    $('a:visible[rel^="magnificPopup"]').each(function() {
        // get the real rel attribute name including index entry id, eg "magnificPopup[28]"
        theRel = $(this).attr('rel');

        // check grouped galleries
        //console.log(theRel);

        // Init magnificPopup for grouped galleries
        $('a:visible[rel^="'+theRel+'"]').magnificPopup({
            type: 'image',
            gallery: { enabled: true },
            removalDelay: 300,
            mainClass: 'popup-slide'
        });
    });

    // this is a single image only init - plugin option : Single Image
    $('a:visible[rel="onemagnificPopup"]').magnificPopup({
        type:'image'
    });
    
});