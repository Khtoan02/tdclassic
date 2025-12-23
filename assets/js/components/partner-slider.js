/**
 * Partner Slider Auto-scroll Functionality
 * TD Classic Theme
 */

document.addEventListener("DOMContentLoaded", function () {
  const partnerSlider = document.getElementById("partner-slider");

  if (!partnerSlider) return;

  const partnerItems = partnerSlider.querySelectorAll(".partner-item");
  const itemWidth = 240; // 200px width + 40px gap
  const totalWidth = partnerItems.length * itemWidth;

  // Clone items for seamless loop
  partnerItems.forEach((item) => {
    const clone = item.cloneNode(true);
    partnerSlider.appendChild(clone);
  });

  // Auto-scroll animation
  let scrollPosition = 0;
  const scrollSpeed = 0.5; // pixels per frame for smoother movement
  let animationId;

  function autoScroll() {
    scrollPosition += scrollSpeed;

    // Reset position when reaching the end
    if (scrollPosition >= totalWidth) {
      scrollPosition = 0;
    }

    partnerSlider.style.transform = `translateX(-${scrollPosition}px)`;
    animationId = requestAnimationFrame(autoScroll);
  }

  // Start auto-scroll
  autoScroll();

  // Pause on hover
  partnerSlider.addEventListener("mouseenter", () => {
    if (animationId) {
      cancelAnimationFrame(animationId);
    }
  });

  partnerSlider.addEventListener("mouseleave", () => {
    autoScroll();
  });

  // Touch/swipe support for mobile
  let startX = 0;
  let endX = 0;
  let isScrolling = false;

  partnerSlider.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
    isScrolling = true;

    // Pause animation on touch
    if (animationId) {
      cancelAnimationFrame(animationId);
    }
  });

  partnerSlider.addEventListener("touchmove", (e) => {
    if (isScrolling) {
      endX = e.touches[0].clientX;
      const diff = startX - endX;

      if (Math.abs(diff) > 10) {
        // User is actively scrolling, keep animation paused
        if (animationId) {
          cancelAnimationFrame(animationId);
        }
      }
    }
  });

  partnerSlider.addEventListener("touchend", () => {
    isScrolling = false;

    // Resume animation after a short delay
    setTimeout(() => {
      autoScroll();
    }, 1000);
  });

  // Pause animation when tab is not visible
  document.addEventListener("visibilitychange", () => {
    if (document.hidden) {
      if (animationId) {
        cancelAnimationFrame(animationId);
      }
    } else {
      autoScroll();
    }
  });

  // Handle window resize
  window.addEventListener("resize", () => {
    // Reset position and restart animation
    scrollPosition = 0;
    partnerSlider.style.transform = "translateX(0)";

    if (animationId) {
      cancelAnimationFrame(animationId);
    }

    setTimeout(() => {
      autoScroll();
    }, 100);
  });

  // Accessibility: Pause on focus for keyboard users
  partnerSlider.addEventListener("focusin", () => {
    if (animationId) {
      cancelAnimationFrame(animationId);
    }
  });

  partnerSlider.addEventListener("focusout", () => {
    autoScroll();
  });

  // Respect user's motion preferences
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    if (animationId) {
      cancelAnimationFrame(animationId);
    }
    partnerSlider.style.transform = "none";
  }
});
