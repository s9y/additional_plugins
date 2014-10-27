jQuery(document).ready(function(){

    // remove anchors onclick handler, if have
    jQuery('a[rel^="magnificPopup"]').removeAttr('onclick');
    jQuery('a[rel="onemagnificPopup"]').removeAttr('onclick');

    // get all magnificPopup anchors by group
    $('a:visible[rel^="magnificPopup"]').each(function() {
        // get the real rel attribute name including index entry id, eg "magnificPopup[28]"
        theRel = $(this).attr('rel');

        // check grouped galleries
        //console.log(theRel);

        // Init magnificPopup for grouped galleries
        $('a:visible[rel^="'+theRel+'"]').magnificPopup({
            gallery:{
                enabled:true
            },
            type:'image'
        });
    });

    // this is a single image only init - plugin option : Single Image
    jQuery('a:visible[rel="onemagnificPopup"]').magnificPopup({
        type:'image'
    });
    
});