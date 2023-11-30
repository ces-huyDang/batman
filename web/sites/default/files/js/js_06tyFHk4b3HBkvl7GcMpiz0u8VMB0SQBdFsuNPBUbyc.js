;
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
  });
  $(window).scroll(function () {
    createAnimation(finalPostList);
  });
})(jQuery);
;
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

    // Menu Animation

    setTimeout(function () {
      $(".menu-link").removeClass("text-invisible");
      $(".menu-link").addClass("text-visible");
      $(".menu").removeClass("menu-bg-light");
      $(".menu").addClass("menu-bg-dark");
    }, 100);
  });
})(jQuery);
;
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
;
(function ($) {
  function mouseEnter() {
    const ratingScore = $(this).attr("id");
    const btnColorClass = this.classList[2];
    const currentColorClass = btnColorClass.slice(12, btnColorClass.length);
    const btnColor = "btn-" + currentColorClass;
    globalRatingScore = ratingScore;
    globalBtnColor = btnColor;
    var scoreCircle;
    if (ratingScore <= 3) {
      scoreCircle =
        '<div id="circle" class="circle bg-danger row"><div class="score pt-2 text-center col-12">' +
        ratingScore +
        "</div></div>";
    } else if (ratingScore > 3 && ratingScore <= 6) {
      scoreCircle =
        '<div id="circle" class="circle bg-warning row"><div class="score pt-2 text-center col-12">' +
        ratingScore +
        "</div></div>";
    } else {
      scoreCircle =
        '<div id="circle" class="circle bg-success row"><div class="score pt-2 text-center col-12">' +
        ratingScore +
        "</div></div>";
    }
    $("#rating-score").append(scoreCircle);
    for (let i = 0; i <= ratingScore; i++) {
      $("#" + i).removeClass(document.getElementById(i).classList[2]);
      $("#" + i).addClass(btnColor);
    }
  }

  function mouseOut() {
    $("#rating-score").find("#circle").remove();
    $(".rate-btn").removeClass(globalBtnColor);
    for (let i = 0; i <= globalRatingScore; i++) {
      if (i <= 3) {
        $("#" + i).addClass("btn-outline-danger");
      }
      if (i > 3 && i <= 6) {
        $("#" + i).addClass("btn-outline-warning");
      }
      if (i > 6) {
        $("#" + i).addClass("btn-outline-success");
      }
    }
  }

  function ratingBtnClick() {
    const scoreBtn = $(".rate-btn");
    scoreBtn.off("mouseout", mouseOut);
    scoreBtn.off("mouseenter", mouseEnter);
    $(".rate-btn").prop("disabled", true);
    const confirmBtnGroup =
      '<div class="btn-group mt-3" role="group">' +
      '<button id="cancel" type="button" class="btn btn-light border border-dark">No</button>' +
      '<button id="confirm" type="button" class="btn ' +
      globalBtnColor +
      ' border border-dark">Yes</button>' +
      "</div>";
    $("#confirm-btn").append(confirmBtnGroup);
    $("#noti").html("Rate the post with this score?");
    const cancelBtn = $("#cancel");
    const confirmBtn = $("#confirm");
    cancelBtn.click(cancel);
    confirmBtn.click(confirm);
  }

  function cancel() {
    const scoreBtn = $(".rate-btn");
    scoreBtn.on("mouseout", mouseOut);
    scoreBtn.on("mouseenter", mouseEnter);
    $(".rate-btn").removeAttr("disabled");
    $("#confirm-btn").find(".btn-group").remove();
    $("#noti").html("Hover and click to give a rating");
    mouseOut();
  }

  function confirm() {
    $.ajax({
      url: "/current-user",
      success: function (uid) {
        const score_info = {
          score: globalRatingScore,
          nid: nid,
          uid: uid,
        };
        const jsonString = JSON.stringify(score_info);
        $.ajax({
          url: "/rate/" + jsonString,
          success: function (response) {
            const squareColor = document.getElementById("square").classList[2];
            $("#square").removeClass(squareColor);
            $("#average-score").html("");
            $("#voted-users").html(" ");
            getScore();
            cancel();
            $("#noti").html(response);
          },
        });
      },
      error: function () {
        console.error("Failed to retrieve dynamic data.");
      },
    });
  }

  function getScore() {
    $.ajax({
      url: "/score/" + nid,
      success: function (data) {
        // Create and append the dropdown menu with dynamic data
        if (data.message) {
          $("#user-score").html(
            '<div class="col-12">' + data.message + "</div>"
          );
        } else {
          let squareColor;
          $("#voted-users").append(data.voted_users);
          if (data.average_score <= 3) {
            squareColor = "bg-danger";
          } else if (data.average_score > 3 && data.average_score <= 6) {
            squareColor = "bg-warning";
          } else {
            squareColor = "bg-success";
          }
          $("#square").addClass(squareColor);
          $("#average-score").append(data.average_score);
        }
      },
      error: function () {
        console.error("Failed to retrieve dynamic data.");
      },
    });
  }

  let globalRatingScore;
  let globalBtnColor;
  const nid = window.location.pathname.charAt(
    window.location.pathname.length - 1
  );

  $(document).ready(function () {
    const scoreBtn = $(".rate-btn");
    scoreBtn.click(ratingBtnClick);
    scoreBtn.mouseenter(mouseEnter);
    scoreBtn.mouseout(mouseOut);
    getScore();
  });
})(jQuery);
;
