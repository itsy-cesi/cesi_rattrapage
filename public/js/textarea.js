$(function () {
  $("textarea").each(function () {
    $(this).attr("default_height", $(this).height());
    $(this).on("keyup", function (e) {
      $(this)
        .height($(this).attr("default_height"))
        .height(
          this.scrollHeight +
            parseFloat($(this).css("borderTopWidth")) +
            parseFloat($(this).css("borderBottomWidth"))
        );
    });
  });
  $("head").append("<style>textarea{resize:none}</style>");
});
