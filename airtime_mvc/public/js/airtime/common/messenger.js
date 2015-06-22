var unread;

$(document).ready(function() {
    // Get any messages for the user
    $.get(baseUrl+'message/get', function(data) {
        var json = JSON.parse(data);
        unread = json.unread;
        var messages = json.messages;
        for (var k in messages) {
            $("#messages").append("<span class='message'>" + (new Date(k)).toLocaleString()
            + ": " + messages[k] + "</span><br/><br/>");
        }
    });
});

function toggleMessages() {
    if (unread) {
        // Acknowledge any unread messages now that the user has read them
        $.get(baseUrl+'message/ack', function() {
            unread = false;
        });
    }
    var m = $("#messages");
    m.slideToggle();
    $("#message-count").hide();
}

$(document).mouseup(function (e) {
    var m = $("#messages"),
        mb = $("#messenger");
    if (!mb.is(e.target) && mb.has(e.target).length === 0) {
        m.slideUp();
    }
});
