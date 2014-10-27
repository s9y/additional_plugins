jQuery(document).ready(function(){

    // remove anchors onclick handler, if have
    jQuery('a[rel^="colorbox"]').removeAttr('onclick');
    jQuery('a[rel^="singlebox"]').removeAttr('onclick');

    // init by group - init with :visible to ensure to not show hidden elements via hideafter function in imageselectorplus ranges
    jQuery('a:visible[rel^="colorbox"]').colorbox({
        slideshow: true,
        slideshowAuto: false,
        slideshowSpeed: 6000,
        scalePhotos: true,
        maxWidth: '98%'
    }); 
    // this is a single image only init - plugin option : Single Image
    jQuery('a:visible[rel="singlebox"]').colorbox({
        rel: 'nofollow',
        scalePhotos: true,
        maxWidth: '98%'
    });
});
