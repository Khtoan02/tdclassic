/**
 * TD Classic Theme Scripts
 */

(function ($) {
  "use strict";

  // Document ready
  $(document).ready(function () {
    // Set animation delays and wave bar heights from data attributes
    initDataAttributes();
    
    // Initialize basic features first
    initSmoothScrolling();
    initBackToTop();
    initFormValidation();
    initCardHoverEffects();
    // Mobile Menu now handled by mega-menu.js module

    initStickyHeader(); // Initialize sticky header
    initFooter(); // Explicitly init footer here too just in case
  });

  // Homepage features removed - simple homepage only

  // Initialize data attributes (animation delays, wave bar heights, etc.)
  function initDataAttributes() {
    // Set animation delays from data attributes
    $('[data-animation-delay]').each(function() {
      var delay = $(this).data('animation-delay');
      if (delay !== undefined) {
        $(this).css('--animation-delay', delay + 's');
      }
    });

    // Set wave bar heights from data attributes
    $('.wave-bar[data-height]').each(function() {
      var height = $(this).data('height');
      if (height !== undefined) {
        $(this).css('--wave-height', height + '%');
      }
    });
  }

  // Smooth Scrolling (universal)
  function initSmoothScrolling() {
    $('a[href^="#"]').on("click", function (e) {
      var target = $(this.hash);
      if (target.length) {
        e.preventDefault();
        $("html, body").animate(
          {
            scrollTop: target.offset().top - 80,
          },
          1000
        );
      }
    });
  }

  // Back to Top Button (universal)
  function initBackToTop() {
    var backToTop = $(
      '<button id="back-to-top" class="btn position-fixed" style="display: none;"><i class="fas fa-arrow-up"></i></button>'
    );
    $("body").append(backToTop);

    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
        $("#back-to-top").fadeIn();
      } else {
        $("#back-to-top").fadeOut();
      }
    });

    $("#back-to-top").click(function () {
      $("html, body").animate({ scrollTop: 0 }, 800);
      return false;
    });
  }

  // Form Validation (universal)
  function initFormValidation() {
    $("form").on("submit", function (e) {
      var form = $(this);
      var isValid = true;

      form.find("input[required], textarea[required]").each(function () {
        if ($(this).val() === "") {
          $(this).addClass("is-invalid");
          isValid = false;
        } else {
          $(this).removeClass("is-invalid");
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert("Vui lòng điền đầy đủ thông tin hợp lệ.");
      }
    });
  }

  // Card Hover Effects (universal)
  function initCardHoverEffects() {
    $(".card").hover(
      function () {
        $(this).addClass("shadow-lg");
      },
      function () {
        $(this).removeClass("shadow-lg");
      }
    );
  }

  // Mobile Menu - Now handled by mega-menu.js module for new header design
  // Removed duplicate function - header mới sử dụng mega-menu.js

  // Active menu item
  function setActiveMenuItem() {
    var currentPath = window.location.pathname;
    var currentPathClean = currentPath.replace(/\/$/, "") || "/"; // Remove trailing slash except for root

    $(".navbar-nav .nav-link").each(function () {
      var link = $(this);
      var href = link.attr("href");

      if (href) {
        var hrefClean = href.replace(/\/$/, "") || "/"; // Remove trailing slash except for root

        // Exact match for home page
        if (currentPathClean === "/" && hrefClean === "/") {
          link.addClass("active");
        }
        // For other pages, check if current path matches or starts with the href
        else if (currentPathClean !== "/" && hrefClean !== "/") {
          if (
            currentPathClean === hrefClean ||
            currentPathClean.startsWith(hrefClean + "/")
          ) {
            link.addClass("active");
          }
        }
      }
    });
  }

  // Sticky Header Logic
  function initStickyHeader() {
    var header = $('.header-wrapper');
    var lastScrollTop = 0;
    
    $(window).scroll(function(event){
       var st = $(this).scrollTop();
       
       // Add scrolled class for background effect
       if (st > 50) {
         header.addClass('sticky-header scrolled');
       } else {
         header.removeClass('sticky-header scrolled');
       }
       
       lastScrollTop = st;
    });
  }

  // Call on page load
  setActiveMenuItem();
})(jQuery);

// Performance optimization - debounce function
function debounce(func, wait) {
  var timeout;
  return function executedFunction(...args) {
    var later = function () {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Optimized scroll handler only for homepage
if (document.body.classList.contains("home")) {
  var optimizedScrollHandler = debounce(function () {
    // Homepage specific scroll effects can go here
  }, 10);

  window.addEventListener("scroll", optimizedScrollHandler);
}

// Footer functionality
function initFooter() {
  // Footer accordion functionality - chỉ hoạt động trên mobile
  const footerItems = document.querySelectorAll(".footer-item");
  const isMobile = window.innerWidth <= 768;

  footerItems.forEach((item) => {
    const header = item.querySelector(".footer-item-header");
    const content = item.querySelector(".footer-item-content");

    if (header && content) {
      // Xóa event listeners cũ bằng cách clone và replace
      const newHeader = header.cloneNode(true);
      header.parentNode.replaceChild(newHeader, header);
      
      // Lấy lại reference sau khi replace
      const newHeaderRef = item.querySelector(".footer-item-header");
      
      if (isMobile) {
        // Mobile: Accordion behavior
        newHeaderRef.addEventListener("click", function() {
          item.classList.toggle("active");
        });

        // Mobile: Đóng tất cả items mặc định (trừ item đầu tiên)
        if (item === footerItems[0]) {
          item.classList.add("active"); // Mở item đầu tiên
        } else {
          item.classList.remove("active"); // Đóng các item khác
        }
      } else {
        // Desktop: Luôn mở tất cả items và xóa inline styles
        item.classList.add("active");
        // Xóa tất cả inline styles để CSS tự nhiên hoạt động
        if (content) {
          content.style.display = "";
          content.style.maxHeight = "";
          content.style.opacity = "";
          content.style.overflow = "";
          content.style.visibility = "";
        }
      }
    }
  });

  // Newsletter form handling
  const newsletterForm = document.querySelector(".newsletter-form");
  if (newsletterForm) {
    newsletterForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const emailInput = this.querySelector('input[type="email"]');
      const submitBtn = this.querySelector(".newsletter-btn");

      if (emailInput && emailInput.value) {
        // Show loading state
        submitBtn.classList.add("loading");

        // Simulate form submission
        setTimeout(() => {
          submitBtn.classList.remove("loading");

          // Show success message
          const successMsg = document.createElement("div");
          successMsg.className = "newsletter-success";
          successMsg.textContent = "Cảm ơn bạn đã đăng ký!";
          successMsg.style.cssText =
            "color: #4CAF50; font-size: 0.875rem; margin-top: 8px;";

          this.appendChild(successMsg);

          // Clear input
          emailInput.value = "";

          // Remove success message after 3 seconds
          setTimeout(() => {
            successMsg.remove();
          }, 3000);
        }, 1000);
      }
    });
  }

  // Social links hover effects
  const socialLinks = document.querySelectorAll(".social-link");
  socialLinks.forEach((link) => {
    link.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-2px) scale(1.1)";
    });

    link.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0) scale(1)";
    });
  });
}

// Initialize footer when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  initFooter();
});

// Re-initialize footer on window resize
window.addEventListener(
  "resize",
  debounce(function () {
    initFooter();
  }, 250)
);
