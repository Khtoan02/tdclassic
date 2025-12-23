jQuery(document).ready(function ($) {
  // Tab switching functionality
  $(".tab-button").on("click", function () {
    const tabId = $(this).data("tab");

    // Remove active class from all buttons and panels
    $(".tab-button").removeClass("active");
    $(".tab-panel").removeClass("active");

    // Add active class to clicked button and corresponding panel
    $(this).addClass("active");
    $("#tab-" + tabId).addClass("active");
  });

  // Smooth scroll to contact section when clicking message button
  $(".contact-button.message").on("click", function (e) {
    e.preventDefault();
    $("html, body").animate(
      {
        scrollTop: $(".contact-section").offset().top - 100,
      },
      800
    );
  });

  // Add animation when scrolling to sections
  $(window).on("scroll", function () {
    $(".product-section").each(function () {
      if ($(this).isInViewport()) {
        $(this).addClass("animate");
      }
    });
  });

  // Helper function to check if element is in viewport
  $.fn.isInViewport = function () {
    const elementTop = $(this).offset().top;
    const elementBottom = elementTop + $(this).outerHeight();
    const viewportTop = $(window).scrollTop();
    const viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
  };
});
