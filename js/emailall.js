$(function() {
    // These first three lines of code compensate for Javascript being turned on and off. 
    // It simply changes the submit input field from a type of "submit" to a type of "button".

    var paraTag = $('input#sendtoall').parent('p');
    $(paraTag).children('input').remove();
    $(paraTag).append('<input type="button" name="sendtoall" id="sendtoall" value="Send Email" />');

    $('#main input#sendtoall').click(function() {
        $('#main').append('<img src="images/ajax-loader.gif" class="loaderIcon" alt="Loading..." />');

        var subject = $('input#subject').val();
        var body = $('textarea#body').val();

        $.ajax({
            type: 'post',
            url: 'sendEmailUsers.php',
            data: 'subject=' + subject + '&body=' + body,

            success: function(results) {
                $('#main img.loaderIcon').fadeOut(1000);
                $('ul#response').html(results);
            }
        }); // end ajax
    });
});
