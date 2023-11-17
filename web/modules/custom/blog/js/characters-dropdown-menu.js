(function ($) {
  $(document).ready(function () {
    // Your selector for the dropdown parent
    const originParent = $("#menu-link2");
    const newParent = $("<div></div>", {
      html: '<button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Characters</button>',
      id: originParent.attr("id"),
    });
    originParent.replaceWith(newParent);
    const dropdownMenu = $('<ul class="dropdown-menu text-center"></ul>');
    $.ajax({
      url: "/characters",
      success: function (data) {
        // Create and append the dropdown menu with dynamic data
        data.forEach(function (item) {
          dropdownMenu.append(
            '<li class="text-invisible chars-name"><a href="/taxonomy/term/' +
              item.tid +
              '">' +
              item.term_name +
              "</a></li>"
          );
        });
      },
      error: function () {
        console.error("Failed to retrieve dynamic data.");
      },
    });
    newParent.hover(
      function () {
        $("#menu-link2").append(dropdownMenu);
        // Perform an AJAX request to get dynamic data
        dropdownMenu.show();
      },
      function () {
        // On hover out, hide the dropdown menu
        $(".dropdown-menu").hide();
      }
    );
  });
})(jQuery);
