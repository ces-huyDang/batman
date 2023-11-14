(function ($) {
  Drupal.behaviors.myDropdown = {
    attach: function (context, settings) {
      // Ensure the code runs only once
      if (context !== document) {
        return;
      }
      // Your selector for the dropdown parent
      var originParent = $("#menu-link2");
      var newParent = $("<div></div>", {
        html: '<button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Characters</button>',
        id: originParent.attr("id"),
      });
      originParent.replaceWith(newParent);
      var dropdownMenu = $('<ul class="dropdown-menu text-center"></ul>');
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
    },
  };
})(jQuery);
