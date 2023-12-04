(function ($) {
  let finalPostList = [];

  function getPostInformation() {
    const postList = [];
    for (let i = 1; i < $(".posts").length; i++) {
      const element = document.getElementById("post" + i);
      const post = {
        id: i,
        top: element.getBoundingClientRect().top - 450,
        functionCalled: false,
      };
      postList.push(post);
    }
    return postList;
  }

  function createAnimation(postList) {
    var scrollPosition = window.scrollY;
    postList.forEach((element) => {
      if (element.functionCalled === true) return;
      if (scrollPosition > element.top) {
        $("#post" + element.id).animate({ opacity: 1 }, 1500);
        $("#btn" + element.id).removeClass("btn-secondary");
        $("#btn" + element.id).addClass("btn-primary");
        element.functionCalled = true;
      }
    });
  }

  $(document).ready(function () {
    finalPostList = getPostInformation();
    $("#btn0").removeClass("btn-secondary");
    $("#btn0").addClass("btn-primary");
    finalPostList.forEach((element) => {
      $("#post" + element.id).css("opacity", 0.3);
    });

    // Carousel

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
        console.log(data);
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
  });
  $(window).scroll(function () {
    createAnimation(finalPostList);
  });
})(jQuery);
