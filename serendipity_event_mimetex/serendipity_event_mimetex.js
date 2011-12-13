function serendipity_insTex (loc,area) {
    var tex = prompt('Enter Tex: ');

    if (!loc) {
        area.focus();
        return;
    }
    serendipity_imageSelector_addToBody('<img src="' + loc + '?q=' + escape(tex) + '" title="' + tex + '" alt ="' + tex + '" \/>',area);
}