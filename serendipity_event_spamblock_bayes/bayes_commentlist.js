function spam(commentID) {
    $.post(learncommentPath, {id: commentID, category: 'spam'}).done(function() {
        location.reload();
    });
}

function ham(commentID) {
    $.post(learncommentPath, {id: commentID, category: 'ham'}).done(function() {
        location.reload();
    });
}