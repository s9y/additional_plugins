/*
*Check markups activated in the comments 
*/

function requestMarkups() {
    $.post(lcnewbase,
            '',
            function(data){
                interpretMarkups(data);
            },
            'text')
}

function interpretMarkups(message) {
    var markups = message.split(";");
    s9ymarkup = eval(markups[0]);
    nl2br = eval(markups[1]);
    textile = eval(markups[2]);
    bb = eval(markups[3]);
    markdown = eval(markups[4]);
    preview_animation = markups[5];
    preview_animation_speed = markups[6];
    if (isInt(preview_animation_speed)){
        preview_animation_speed = parseInt(preview_animation_speed)
    }
    button_animation = markups[7];
    button_animation_speed = markups[8];
    if (isInt(preview_animation_speed)){
        button_animation_speed = parseInt(button_animation_speed);
    }
    preview_title = markups[9];
}

function isInt(x) {
   var y=parseInt(x);
   if (isNaN(y)) return false;
   return x==y && x.toString()==y.toString();
 }
