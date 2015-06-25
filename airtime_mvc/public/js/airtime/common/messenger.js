var unread;

$(document).ready(function() {
    // Get any messages for the user
    $.get(baseUrl+'message/get', function(data) {
        var json = JSON.parse(data);
        unread = json.unread;
        var messages = json.messages;
        var m = $("#messages");  // Since jquery lookups are (relatively) slow, only do this once
        if (messages.length <= 0) {
            m.append("<span class='message'>" + $.i18n._("You have no messages!") + "</span>");
        } else {
            for (var k in messages) {
                m.append("<span class='message'>" + (new Date(k)).toLocaleString()
                    + ": " + messages[k] + "</span><br/><br/>");
            }
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
    $("#messages").slideToggle();
    $("#message-count").hide();
}

$(document).mouseup(function (e) {
    var mb = $("#messenger");
    if (!mb.is(e.target) && mb.has(e.target).length === 0) {
        $("#messages").slideUp();
    }
});
