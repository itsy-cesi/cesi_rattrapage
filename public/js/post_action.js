// Set up event handlers for "ready" and "click" events on the document
$(window).on("load click", handlePostActions);
//$(document).on("load", handlePostActions);

// Set up CSS style for post button link
$(function () {
    $("head").append(
        '<style>a[action="post_button"] {cursor: pointer; user-select: none;}</style>'
    );
});

// Handle post button and delete button click events
function handlePostActions() {


    $('a[action="post_button"][name="share"]')
        .off("click")
        .on("click", (event) => {
            event.preventDefault();
            const { target } = event;
            const action = $(target).closest('a[action="post_button"]');
            try {
                navigator.clipboard.writeText(
                    $(action).closest("div.card[share-link]").attr("share-link")
                );
                new Noty({
                    theme: "mint",
                    type: "success",
                    text: "Link copied to clipboard",
                    timeout: 3000,
                }).show();
            } catch (error) {
                new Noty({
                    theme: "mint",
                    type: "error",
                    text: "Copy to clipboard failed",
                    timeout: 3000,
                }).show();
            }
        });
        $('a[action="post_button"][name="like"]')
        .off("click")
        .on("click", (event) => {
            const { target } = event;
            const action = $(target).closest('a[action="post_button"]');

            action.toggleClass("text-danger text-dark");
            $.ajax({
                type: "POST",
                url: "/api/like",
                data: {
                    post_id: $(action).closest("div.card").attr('message-id'),
                },
                success: (data) => {
                    json = JSON.parse(data);
                    action.find('*[name="count_like"]').html(json['likes']);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(`Error: ${errorThrown}`);
                },
            });
        });

    $('a[action="delete_post"]')
        .off("click")
        .on("click", (event) => {
            event.preventDefault();
            const { target } = event;
            const deleteLink = $(target).closest('a[action="delete_post"]');
            $.ajax({
                type: "POST",
                url: deleteLink.attr("target"),
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: JSON.stringify({
                    postId: deleteLink.attr("post_id"),
                }),
                contentType: "application/json",
                success: () => document.location.reload(),
                error: (data) => console.log(data),
            });
        });

    $('a[action="post_button"][name="comment"]')
        .off("click")
        .on("click", (event) => {
            event.preventDefault();
            const { target } = event;
            const action = $(target).closest('a[action="post_button"]');
            document.location = $(action).closest("div.card[share-link]").attr("share-link")
        })
}
