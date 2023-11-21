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
            console.log(response);
          },
        });
      },
      error: function () {
        console.error("Failed to retrieve dynamic data.");
      },
    });
  }

  let globalRatingScore;
  let globalBtnColor;
  let currentUserId;
  const nid = window.location.pathname.charAt(
    window.location.pathname.length - 1
  );

  $(document).ready(function () {
    const scoreBtn = $(".rate-btn");
    scoreBtn.click(ratingBtnClick);
    scoreBtn.mouseenter(mouseEnter);
    scoreBtn.mouseout(mouseOut);
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
  });
})(jQuery);
