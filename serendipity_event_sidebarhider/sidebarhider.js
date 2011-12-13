var _sideBars;
function collectionToArray(col) {
    a = new Array();
    for (i = 0; i < col.length; i++)
        a[a.length] = col[i];
    return a;
}
function getSideBars(main_bar)
{
    var sideBars = new Array();
    var item_count = 0;
    var title_count = 0;
    var content_count = 0;
    
    var tags = main_bar.getElementsByTagName('*');
    var elements = collectionToArray(tags);
    
    for (i = 0; i < elements.length; i++)
    {
        var element = elements[i];
        if (element.attributes)
        {
            var attribute = element.attributes['class'];
            if (attribute && attribute.value.indexOf("serendipitySideBarItem") >= 0)
            {
                if (!sideBars[item_count])
                    sideBars[item_count] = new Array(5);
                sideBars[item_count][0] = element;
                sideBars[item_count][3] = element.className;
                item_count++;
            }
            else if (attribute && attribute.value.indexOf("serendipitySideBarTitle") >= 0)
            {
                if (!sideBars[title_count])
                    sideBars[title_count] = new Array(5);
                sideBars[title_count][1] = element;
                sideBars[title_count][4] = element.className;
                title_count++;
            }
            else if (attribute && attribute.value.indexOf("serendipitySideBarContent") >= 0)
            {
                if (!sideBars[content_count])
                    sideBars[content_count] = new Array(5);
                sideBars[content_count][2] = element;
                content_count++;
            }
        }
    }
    
    return sideBars;
}

function addSideBarHiders(sideBars)
{
    for (i = 0; i < sideBars.length; i++)
    {
		if (!sideBars[i]) {
			continue;
		}
		
        var sideBar = sideBars[i];
        for (j = 0; j < sideBar.length; j++)
        {
            var title = sideBar[j][1];
            if (!title) {
	            continue;
            }
            var item = title.parentNode;
            
            // change the style of title
            title.style.styleFloat = "left";
            title.style.cssFloat = "left";
            
            // this is what is in our link
            linkText = _html_link_visible;
            
            // put the title's inner html in a div tag and add a div tag on the end with our button
            title.innerHTML = "<div style='float:left'>" + title.innerHTML + "</div><a href=\"javascript:sideBarHide("+i+","+j+")\" id='sbl_"+i+"_"+j+"' style='text-decoration:none;float:right;margin-right:3px'>"+linkText+"</a>";
            
            // create new tag and toss title bar in it
            var titleWrap = document.createElement('div');
            titleWrap.className = "clearfix";
            item.insertBefore(titleWrap,title);
            item.removeChild(title);
            titleWrap.appendChild(title);
            
            if (!_sideBarVisibility[i][j])
                sideBarHide(i,j);
        }
    }
}
function sideBarHide(sideBarSide,sideBar)
{
    var sideBarItem = _sideBars[sideBarSide][sideBar][0];
    var sideBarTitle = _sideBars[sideBarSide][sideBar][1];
    var sideBarLink = document.getElementById('sbl_'+sideBarSide+'_'+sideBar);
    var sideBarContent = _sideBars[sideBarSide][sideBar][2];
    var sideBarItemClass = _sideBars[sideBarSide][sideBar][3];
    var sideBarTitleClass = _sideBars[sideBarSide][sideBar][4];
    
    // show
    if (sideBarContent.style.display == 'none')
    {
        sideBarContent.style.display = '';
        sideBarItem.className = sideBarItemClass;
        sideBarTitle.className = sideBarTitleClass;
        sideBarLink.innerHTML = _html_link_visible;
    }
    // hide
    else
    {
        sideBarContent.style.display = 'none';
        sideBarItem.className = sideBarItemClass + " serendipitySideBarItemHidden ";
        sideBarTitle.className = sideBarTitleClass + " serendipitySideBarTitleHidden ";
        sideBarLink.innerHTML = _html_link_hidden;
    }
}
function sideBarHideRun()
{
    _sideBars = new Array();
    var sideBarA = document.getElementById('serendipityLeftSideBar');
    if (sideBarA) {
    	_sideBars[0] = getSideBars(sideBarA);
    }
    
    var sideBarB = document.getElementById('serendipityRightSideBar');
	if (sideBarB) {
	    _sideBars[1] = getSideBars(sideBarB);
    }
    addSideBarHiders(_sideBars);
}

function sideBaraddLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}

sideBaraddLoadEvent(sideBarHideRun);
