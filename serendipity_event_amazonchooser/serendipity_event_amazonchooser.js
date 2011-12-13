
function serendipity_amazonSelector_done(textarea)
{
    var f = document.forms['serendipity[selForm]'].elements;
    asin = f['asin'].value;
    mode = f['searchmode'].value;
    block = '[amazon_chooser]'
           +    asin
           +  ','
           +    mode
           +'[/amazon_chooser]'
    self.opener.serendipity_imageSelector_addToBody(block, textarea);
    self.close();
}

function serendipity_amazonSelector_next()
{
    var f = document.forms['serendipity[selForm]'].elements;

    url = unescape(f['url'].value);
    step = f['step'].value;
    txtarea = f['txtarea'].value;
    mode = f['mode'].value;
    keyword = f['keyword'].value;
    simple =  f['simple'].value;

    jsgoto = url + '&step=' + step + '&simple=' + simple + '&mode=' + mode + '&keyword=' + keyword + '&txtarea=' + txtarea;

   self.location=jsgoto;

}

function serendipity_amazonSelector_simpledone(textarea)
{
    var f = document.forms['serendipity[selForm]'].elements;
    asin = f['asin'].value;
    mode = f['searchmode'].value;
    block = asin
           +  '-'
           +    mode;
    starget = 'serendipity' + textarea;
    t = self.opener.document.getElementsByName(starget)[0];
    text = t.value;
    if (text.length>0) {
      text += ',' + block;
    } else {
      text = block;
    }
    t.value = text;
    self.close();
}

