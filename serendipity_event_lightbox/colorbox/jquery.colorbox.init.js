jQuery(document).ready(function($){

    // remove anchors onclick handler, if have
    $('a[rel^="colorbox"]').removeAttr('onclick');
    $('a[rel^="singlebox"]').removeAttr('onclick');

    // init by group - init with :visible to ensure to not show hidden elements via hideafter function in imageselectorplus ranges
    $('a:visible[rel^="colorbox"]').colorbox({
        slideshow: true,
        slideshowAuto: false,
        slideshowSpeed: 6000,
        scalePhotos: true,
        maxWidth: '98%'
    }); 
    // this is a single image only init - plugin option : Single Image
    $('a:visible[rel="singlebox"]').colorbox({
        rel: 'nofollow',
        scalePhotos: true,
        maxWidth: '98%'
    });
});
