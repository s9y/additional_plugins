var GB_CURRENT = null;

GB_hide = function() {
    GB_CURRENT.hide();
}

GreyBox = new AJS.Class({
    init: function(options) {
        this.type = "page";
        this.overlay_click_close = false;
        this.salt = 0;
        this.root_dir = GB_ROOT_DIR;
        this.callback_fns = [];
        this.reload_on_close = false;
        this.src_loader = this.root_dir + 'loader_frame.html';
        AJS.update(this, options);
    },

    addCallback: function(fn) {
        if(fn) this.callback_fns.push(fn);
    },

    show: function(url) {
        GB_CURRENT = this;
        this.url = url;

        var elms = [AJS.$bytc("object"), AJS.$bytc("embed")];
        if(AJS.isIe()) {
            elms.push(AJS.$bytc("select"));
        }
        AJS.map(AJS.flattenList(elms), function(elm) {
            elm.style.visibility = "hidden";
        });

        this.createElements();
        return false;
    },

    hide: function() {
        this.onHide();
        if(AJS.fx) {
            var elm = this.overlay;
            AJS.fx.fadeOut(this.overlay, {
                onComplete: function() {
                    AJS.removeElement(elm);
                    elm = null;
                },
                duration: 300
            });
            AJS.removeElement(this.g_window);
        }
        else {
            AJS.removeElement(this.g_window, this.overlay);
        }

        this.removeFrame();

        AJS.REV(window, "scroll", _GB_setOverlayDimension);
        AJS.REV(window, "resize", _GB_update);

        if(AJS.isIe()) 
            AJS.map(AJS.$bytc("select"), function(elm) {elm.style.visibility = "visible"});
        AJS.map(AJS.$bytc("object"), function(elm) {elm.style.visibility = "visible"});

        var c_bs = this.callback_fns;
        if(c_bs != []) {
            AJS.map(c_bs, function(fn) { 
                fn();
            });
        }

        GB_CURRENT = null;

        if(this.reload_on_close)
            window.location.reload();
    },

    update: function() {
        this.setOverlayDimension();
        this.setFrameSize();
        this.setWindowPosition();
    },

    createElements: function() {
        this.initOverlay();

        this.g_window = AJS.DIV({'id': 'GB_window'});
        AJS.hideElement(this.g_window);
        AJS.getBody().insertBefore(this.g_window, this.overlay.nextSibling);

        this.initFrame();
        this.initHook();
        this.update();
        
        var me = this;
        if(AJS.fx) {
            AJS.fx.fadeIn(this.overlay, {
                duration: 300,
                to: 0.7,
                onComplete: function() {
                    me.onShow();
                    AJS.showElement(me.g_window);
                    me.startLoading();
                }
            });
        }
        else {
            AJS.setOpacity(this.overlay, 0.7);
            AJS.showElement(this.g_window);
            this.onShow();
            this.startLoading();
        }

        AJS.AEV(window, "scroll", _GB_setOverlayDimension);
        AJS.AEV(window, "resize", _GB_update);
    },

    removeFrame: function() {
        try{ AJS.removeElement(this.iframe); }
        catch(e) {}

        this.iframe = null;
    },

    startLoading: function() {
        this.iframe.src = this.src_loader + '?s='+this.salt++;
        AJS.showElement(this.iframe);
    },

    setOverlayDimension: function() {
        var page_size = AJS.getWindowSize();
        if(AJS.isMozilla() || AJS.isOpera())
            AJS.setWidth(this.overlay, "100%");
        else
            AJS.setWidth(this.overlay, page_size.w);

        var max_height = Math.max(AJS.getScrollTop()+page_size.h, AJS.getScrollTop()+this.height);

        if(max_height < AJS.getScrollTop())
            AJS.setHeight(this.overlay, max_height);
        else
            AJS.setHeight(this.overlay, AJS.getScrollTop()+page_size.h);
    },

    initOverlay: function() {
        this.overlay = AJS.DIV({'id': 'GB_overlay'});

        if(this.overlay_click_close)
            AJS.AEV(this.overlay, "click", GB_hide);

        AJS.setOpacity(this.overlay, 0);
        AJS.getBody().insertBefore(this.overlay, AJS.getBody().firstChild);
    },

    initFrame: function() {
        if(!this.iframe) {
            var d = {'name': 'GB_frame', 'class': 'GB_frame', 'frameBorder': 0};
            this.iframe = AJS.IFRAME(d);
            this.middle_cnt = AJS.DIV({'class': 'content'}, this.iframe);

            this.top_cnt = AJS.DIV();
            this.bottom_cnt = AJS.DIV();

            AJS.ACN(this.g_window, this.top_cnt, this.middle_cnt, this.bottom_cnt);
        }
    },

    /* Can be implemented */
    onHide: function() {},
    onShow: function() {},
    setFrameSize: function() {},
    setWindowPosition: function() {},
    initHook: function() {}

});

_GB_update = function() { if(GB_CURRENT) GB_CURRENT.update(); }
_GB_setOverlayDimension = function() { if(GB_CURRENT) GB_CURRENT.setOverlayDimension(); }

AJS.preloadImages(GB_ROOT_DIR+'indicator.gif');

script_loaded = true;


var GB_SETS = {};
function decoGreyboxLinks() {
    var as = AJS.$bytc('a');
    AJS.map(as, function(a) {
        if(a.getAttribute('href') && a.getAttribute('rel')) {
            var rel = a.getAttribute('rel');
            if(rel.indexOf('gb_') == 0) {
                var name = rel.match(/\w+/)[0];
                var attrs = rel.match(/\[(.*)\]/)[1];
                var index = 0;

                var item = {
                    'caption': a.title || '',
                    'url': a.href
                }

                //Set up GB_SETS
                if(name == 'gb_pageset' || name == 'gb_imageset') {
                    if(!GB_SETS[attrs]) { GB_SETS[attrs] = []; }
                    GB_SETS[attrs].push(item);
                    index = GB_SETS[attrs].length;
                }

                //Append onclick
                if(name == 'gb_pageset') {
                    a.onclick = function() {
                        GB_showFullScreenSet(GB_SETS[attrs], index);
                        return false;
                    };
                }
                if(name == 'gb_imageset') {
                    a.onclick = function() {
                        GB_showImageSet(GB_SETS[attrs], index);
                        return false;
                    };
                }
                if(name == 'gb_image') {
                    a.onclick = function() {
                        GB_showImage(item.caption, item.url);
                        return false;
                    };
                }
                if(name == 'gb_page') {
                    a.onclick = function() {
                        var sp = attrs.split(/, ?/);
                        GB_show(item.caption, item.url, parseInt(sp[1]), parseInt(sp[0]));
                        return false;
                    };
                }
                if(name == 'gb_page_fs') {
                    a.onclick = function() {
                        GB_showFullScreen(item.caption, item.url);
                        return false;
                    };
                }
                if(name == 'gb_page_center') {
                    a.onclick = function() {
                        var sp = attrs.split(/, ?/);
                        GB_showCenter(item.caption, item.url, parseInt(sp[1]), parseInt(sp[0]));
                        return false;
                    };
                }
            }
        }});
}

AJS.AEV(window, 'load', decoGreyboxLinks);


GB_showImage = function(caption, url, callback_fn) {
    var options = {
        width: 300,
        height: 300,
        type: 'image',

        fullscreen: false,
        center_win: true,
        caption: caption,
        callback_fn: callback_fn
    }
    var win = new GB_Gallery(options);
    return win.show(url);
}

GB_showPage = function(caption, url, callback_fn) {
    var options = {
        type: 'page',

        caption: caption,
        callback_fn: callback_fn,
        fullscreen: true,
        center_win: false
    }
    var win = new GB_Gallery(options);
    return win.show(url);
}

GB_Gallery = GreyBox.extend({
    init: function(options) {
        this.parent({});
        this.img_close = this.root_dir + 'g_close.gif';
        AJS.update(this, options);
        this.addCallback(this.callback_fn);
    },

    initHook: function() {
        AJS.addClass(this.g_window, 'GB_Gallery');

        var inner = AJS.DIV({'class': 'inner'});
        this.header = AJS.DIV({'class': 'GB_header'}, inner);
        AJS.setOpacity(this.header, 0);
        AJS.getBody().insertBefore(this.header, this.overlay.nextSibling);

        var td_caption = AJS.TD({'id': 'GB_caption', 'class': 'caption', 'width': '40%'}, this.caption);
        var td_middle = AJS.TD({'id': 'GB_middle', 'class': 'middle', 'width': '20%'});

        var img_close = AJS.IMG({'src': this.img_close});
        AJS.AEV(img_close, 'click', GB_hide);
        var td_close = AJS.TD({'class': 'close', 'width': '40%'}, img_close);

        var tbody = AJS.TBODY(AJS.TR(td_caption, td_middle, td_close));

        var table = AJS.TABLE({'cellspacing': '0', 'cellpadding': 0, 'border': 0}, tbody);
        AJS.ACN(inner, table);

        if(this.fullscreen)
            AJS.AEV(window, 'scroll', AJS.$b(this.setWindowPosition, this));
        else
            AJS.AEV(window, 'scroll', AJS.$b(this._setHeaderPos, this));
    },

    setFrameSize: function() {
        var overlay_w = this.overlay.offsetWidth;
        var page_size = AJS.getWindowSize();

        if(this.fullscreen) {
            this.width = overlay_w-40;
            this.height = page_size.h-80;
        }
        AJS.setWidth(this.iframe, this.width);
        AJS.setHeight(this.iframe, this.height);

        AJS.setWidth(this.header, overlay_w);
    },

    _setHeaderPos: function() {
        AJS.setTop(this.header, AJS.getScrollTop()+10);
    },

    setWindowPosition: function() {
        var overlay_w = this.overlay.offsetWidth;
        var page_size = AJS.getWindowSize();
        AJS.setLeft(this.g_window, ((overlay_w - 50 - this.width)/2));

        if(!this.center_win) {
            AJS.setTop(this.g_window, AJS.getScrollTop()+55);
        }
        else {
            var fl = ((page_size.h - this.height) /2) - 20 + AJS.getScrollTop();
            if(fl < 0) fl = 0;
            AJS.setTop(this.g_window, fl);
        }
        this._setHeaderPos();
    },

    onHide: function() {
        AJS.removeElement(this.header);
        AJS.removeClass(this.g_window, 'GB_Gallery');
    },

    onShow: function() {
        if(AJS.fx)
            AJS.fx.fadeIn(this.header, {to: 1});
        else
            AJS.setOpacity(this.header, 1);
    }
});

AJS.preloadImages(GB_ROOT_DIR+'g_close.gif');


GB_showFullScreenSet = function(set, start_index, callback_fn) {
    var options = {
        type: 'page',
        fullscreen: true,
        center_win: false
    }
    var gb_sets = new GB_Sets(options, set);
    gb_sets.addCallback(callback_fn);
    gb_sets.showSet(start_index-1);
    return false;
}

GB_showImageSet = function(set, start_index, callback_fn) {
    var options = {
        type: 'image',
        fullscreen: false,
        center_win: true,
        width: 300,
        height: 300
    }
    var gb_sets = new GB_Sets(options, set);
    gb_sets.addCallback(callback_fn);
    gb_sets.showSet(start_index-1);
    return false;
}

GB_Sets = GB_Gallery.extend({
    init: function(options, set) {
        this.parent(options);
        if(!this.img_next) this.img_next = this.root_dir + 'next.gif';
        if(!this.img_prev) this.img_prev = this.root_dir + 'prev.gif';
        this.current_set = set; 
    },

    showSet: function(start_index) {
        this.current_index = start_index;

        var item = this.current_set[this.current_index];
        this.show(item.url);
        this._setCaption(item.caption);

        this.btn_prev = AJS.IMG({'class': 'left', src: this.img_prev});
        this.btn_next = AJS.IMG({'class': 'right', src: this.img_next});

        AJS.AEV(this.btn_prev, 'click', AJS.$b(this.switchPrev, this));
        AJS.AEV(this.btn_next, 'click', AJS.$b(this.switchNext, this));

        GB_STATUS = AJS.SPAN({'class': 'GB_navStatus'});
        AJS.ACN(AJS.$('GB_middle'), this.btn_prev, GB_STATUS, this.btn_next);
        
        this.updateStatus();
    },

    updateStatus: function() {
        AJS.setHTML(GB_STATUS, (this.current_index + 1) + ' / ' + this.current_set.length);
        if(this.current_index == 0) {
            AJS.addClass(this.btn_prev, 'disabled');
        }
        else {
            AJS.removeClass(this.btn_prev, 'disabled');
        }

        if(this.current_index == this.current_set.length-1) {
            AJS.addClass(this.btn_next, 'disabled');
        }
        else {
            AJS.removeClass(this.btn_next, 'disabled');
        }
    },

    _setCaption: function(caption) {
        AJS.setHTML(AJS.$('GB_caption'), caption);
    },

    updateFrame: function() {
        var item = this.current_set[this.current_index];
        this._setCaption(item.caption);
        this.url = item.url;
        this.startLoading();
    },

    switchPrev: function() {
        if(this.current_index != 0) {
            this.current_index--;
            this.updateFrame();
            this.updateStatus();
        }
    },

    switchNext: function() {
        if(this.current_index != this.current_set.length-1) {
            this.current_index++
            this.updateFrame();
            this.updateStatus();
        }
    }
});

AJS.AEV(window, 'load', function() {
    AJS.preloadImages(GB_ROOT_DIR+'next.gif', GB_ROOT_DIR+'prev.gif');
});


GB_show = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: caption,
        height: height || 500,
        width: width || 500,
        fullscreen: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}

GB_showCenter = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: caption,
        center_win: true,
        height: height || 500,
        width: width || 500,
        fullscreen: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}

GB_showFullScreen = function(caption, url, callback_fn) {
    var options = {
        caption: caption,
        fullscreen: true,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}

GB_Window = GreyBox.extend({
    init: function(options) {
        this.parent({});
        this.img_header = this.root_dir+"header_bg.gif";
        this.img_close = this.root_dir+"w_close.gif";
        this.show_close_img = true;
        AJS.update(this, options);
        this.addCallback(this.callback_fn);
    },

    initHook: function() {
        AJS.addClass(this.g_window, 'GB_Window');

        this.header = AJS.TABLE({'class': 'header'});
        this.header.style.backgroundImage = "url("+ this.img_header +")";

        var td_caption = AJS.TD({'class': 'caption'}, this.caption);
        var td_close = AJS.TD({'class': 'close'});

        if(this.show_close_img) {
            var img_close = AJS.IMG({'src': this.img_close});
            var span = AJS.SPAN('Close');

            var btn = AJS.DIV(img_close, span);

            AJS.AEV([img_close, span], 'mouseover', function() { AJS.addClass(span, 'on'); });
            AJS.AEV([img_close, span], 'mouseout', function() { AJS.removeClass(span, 'on'); });
            AJS.AEV([img_close, span], 'mousedown', function() { AJS.addClass(span, 'click'); });
            AJS.AEV([img_close, span], 'mouseup', function() { AJS.removeClass(span, 'click'); });
            AJS.AEV([img_close, span], 'click', GB_hide);

            AJS.ACN(td_close, btn);
        }

        tbody_header = AJS.TBODY();
        AJS.ACN(tbody_header, AJS.TR(td_caption, td_close));

        AJS.ACN(this.header, tbody_header);
        AJS.ACN(this.top_cnt, this.header);

        AJS.AEV(window, 'scroll', AJS.$b(this.setWindowPosition, this));
    },

    setFrameSize: function() {
        if(this.fullscreen) {
            var page_size = AJS.getWindowSize();
            overlay_h = page_size.h;
            this.width = Math.round(this.overlay.offsetWidth - (this.overlay.offsetWidth/100)*10);
            this.height = Math.round(overlay_h - (overlay_h/100)*10);
        }

        AJS.setWidth(this.header, this.width+6); //6 is for the left+right border
        AJS.setWidth(this.iframe, this.width);
        AJS.setHeight(this.iframe, this.height);
    },

    setWindowPosition: function() {
        var page_size = AJS.getWindowSize();
        AJS.setLeft(this.g_window, ((page_size.w - this.width)/2)-13);

        if(!this.center_win) {
            AJS.setTop(this.g_window, AJS.getScrollTop());
        }
        else {
            var fl = ((page_size.h - this.height) /2) - 20 + AJS.getScrollTop();
            if(fl < 0)
                fl = 0;
            AJS.setTop(this.g_window, fl);
        }
    }
});

AJS.preloadImages(GB_ROOT_DIR+'w_close.gif', GB_ROOT_DIR+'header_bg.gif');
