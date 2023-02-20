$(document).ready(() => {
    $('form[name="post_form"]').on('submit', (event) => {
        event.preventDefault();

        const form = $(event.currentTarget);
        const messageInput = form.find('[name="message"]');
        const parentInput = form.find('[name="parent"]');
        const message = messageInput.val();
        const parent = parentInput.val();
        messageInput.val('');

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: {
                message,
                parent
            },
            success: (data) => {
                console.log(`Success: ${data}`);
                location.reload();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error(`Error: ${errorThrown}`);
            }
        });
    });
});
