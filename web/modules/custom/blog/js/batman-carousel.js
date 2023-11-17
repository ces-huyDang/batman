(function ($) {
  Drupal.behaviors.myDropdown = {
    attach: function (context, settings) {
      // Ensure the code runs only once
      if (context !== document) {
        return;
      }
      const carousel = $("#carousel");

      function nextSlide() {
        window.clearInterval(interval);
        var $currentSlide = $("#carousel").find("div:first");
        var width = $currentSlide.width();
        $currentSlide.animate({ marginLeft: -width }, 1000, function () {
          var $lastSlide = $("#carousel").find("div:last");
          $lastSlide.after($currentSlide);
          $currentSlide.css({ marginLeft: 0 });
          interval = window.setInterval(rotateSlides, 3000);
        });
      }

      function previousSlide() {
        window.clearInterval(interval);
        var $currentSlide = $("#carousel").find("div:first");
        var width = $currentSlide.width();
        var $previousSlide = $("#carousel").find("div:last");
        $previousSlide.css({ marginLeft: -width });
        $currentSlide.before($previousSlide);
        $previousSlide.animate({ marginLeft: 0 }, 1000);
      }
      $.ajax({
        url: "/carousel",
        success: function (data) {
          data.forEach(function (item) {
            var slide =
              '<div class="slide-image"><img src="' + item.url + '"></div>';
            carousel.append(slide);
          });
        },
        error: function () {
          console.error("Failed to retrieve dynamic data.");
        },
      });

      var interval = window.setInterval(rotateSlides, 3000);

      function rotateSlides() {
        var $firstSlide = $("#carousel").find("div:first");
        var width = $firstSlide.width();

        $firstSlide.animate({ marginLeft: -width }, 3000, function () {
          var $lastSlide = $("#carousel").find("div:last");
          $lastSlide.after($firstSlide);
          $firstSlide.css({ marginLeft: 0 });
        });
      }

      $("#left-arrow").click(previousSlide);
      $("#right-arrow").click(nextSlide);
      $(".slide-image").click(nextSlide);
    },
  };
})(jQuery);
