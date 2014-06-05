
function sortwithcolor(column) {
	$("#bayesDatabaseTable > tbody > tr").heatcolor(
		function() { return $("td:nth-child(" + column + ")", this).text(); },
		{ colorStyle: 'greentored' }
	);
};

$(document).ready(function() {
    var checked = false;
    $("#bayesDeleteDB").submit(function(event) {
        if (! checked) {
            event.preventDefault()
            var answer = confirm("Completely delete the database?")
            if (answer){
                window.location.href = $("#bayesDeleteDB").attr('action');
            } else {
                
            }
        }
    });
});

$("th").click(function() {
	$(this).siblings().css("background-color","#cccccc").end().css("background-color","#dd0000");
	sortwithcolor( $(this).parent().children().index( this ) + 1 );
});

function shortenAll(textclass, lines) {
    $.each( $('.'+textclass), function() {
        shorten($(this), lines);
    });
}

function shorten($element, lines) {
    var o = $element.text();
    $r = $('<a href="#" style="padding-left: 5px;">... show</a>');
    $element.excerpt({ lines: lines, end: $r});
    $element.find('a').click(function(e){
        e.preventDefault();
        var $cell = $(this).parent();
        var $link = $('<a></a>')
            .attr('href', '#')
            .text('shorten')
            .css('padding-left', '5px');
        $link.click( function(e) {
            e.preventDefault();
            $link.remove();
            shorten($cell);
        });
        $cell.text(o);
        $cell.append($link);
    });
}

function colorize() {
    $ratings = $(".ratingBox").children(".rating");
    $.each($ratings, function() {
        var rating = parseInt($(this).text().replace("%",""));
        if (rating > 70) {
            $(this).parent().css('background', 'rgba(249, 199, 199, 0.5)');
        } else if ( rating > 10) {
            $(this).parent().css('background', 'rgba(248, 246, 137, 0.5)');
        } else if (rating >= 0){
            $(this).parent().css('background', 'rgba(202, 248, 199, 0.5)');
        } else {
            /*detect those without a rating*/
            $(this).parent().css('background', 'rgba(165, 165, 165, 0.5)');
        }
    });
    
}
