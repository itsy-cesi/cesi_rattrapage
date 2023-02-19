$(document).ready(function() {
    $('*[name="post_form"]').submit(function(e) {
        e.preventDefault();
        alert($(e.target).find('[name="message"]').val());
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: {
                'message': $(e.target).find('[name="message"]').val()
            },
            success: function(data) {
                console.log(data);
            }
        });
    })
});
