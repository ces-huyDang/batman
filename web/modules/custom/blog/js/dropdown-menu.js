(function ($) {
  function characters() {
    let newParent;
    // Your selector for the dropdown parent
    const originParent = $("#menu-link2");
    if (currentPath.startsWith("/vi", 0)) {
      newParent = $("<div></div>", {
        html: '<button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Nhân Vật</button>',
        id: originParent.attr("id"),
      });
    } else {
      newParent = $("<div></div>", {
        html: '<button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Characters</button>',
        id: originParent.attr("id"),
      });
    }
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
  }

  function menuAnimation() {
    setTimeout(function () {
      $(".menu-link").removeClass("text-invisible");
      $(".menu-link").addClass("text-visible");
      $(".menu").removeClass("menu-bg-light");
      $(".menu").addClass("menu-bg-dark");
    }, 100);
  }

  function language() {
    const originParent = $("#menu-link3");
    const dropdownMenu = $('<ul class="dropdown-menu text-center"></ul>');
    let newPath;
    let newParent;
    if (currentPath.startsWith("/vi", 0)) {
      newPath = currentPath.slice(3, currentPath.length);
      console.log(newPath);
      newParent = $("<div></div>", {
        html: '<button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Language</button>',
        id: originParent.attr("id"),
      });
      dropdownMenu.append(
        '<li class="text-invisible chars-name"><a href="' +
          newPath +
          '">English</a></li>'
      );
    } else {
      newPath = "/vi" + currentPath;
      newParent = $("<div></div>", {
        html: '<button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Ngôn Ngữ</button>',
        id: originParent.attr("id"),
      });
      dropdownMenu.append(
        '<li class="text-invisible chars-name"><a href="' +
          newPath +
          '">Tiếng Việt</a></li>'
      );
    }
    originParent.replaceWith(newParent);

    newParent.hover(
      function () {
        $("#menu-link3").append(dropdownMenu);
        // Perform an AJAX request to get dynamic data
        dropdownMenu.show();
        console.log(currentPath);
      },
      function () {
        // On hover out, hide the dropdown menu
        $(".dropdown-menu").hide();
      }
    );
  }

  const currentPath = window.location.pathname;

  $(document).ready(function () {
    characters();
    language();
    // Menu Animation
    menuAnimation();
  });
})(jQuery);
