$(document).on("ready click", post_action);
$(function () {
  $("head").append(
    '<style>a[action="post_button"]{cursor:pointer;user-select:none;}</style>'
  );
});
function post_action() {
  $('a[action="post_button"]')
    .off("click")
    .on("click", () => console.log(this));
}
