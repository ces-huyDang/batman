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
