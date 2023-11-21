(function ($) {
  $(document).ready(function () {
    setTimeout(function () {
      $(".menu-link").removeClass("text-invisible");
      $(".menu-link").addClass("text-visible");
      $(".menu").removeClass("menu-bg-light");
      $(".menu").addClass("menu-bg-dark");
    }, 100);
  });
})(jQuery);
