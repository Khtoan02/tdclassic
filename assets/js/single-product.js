/**
 * Single Product Page JavaScript
 * Enhanced interactions for product hero section
 */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize all product page features
  initProductGallery();
  initModalGallery();
  initOverlayActions();
  initConsultationForm();
  initSocialActions();
  initAnimations();

  /**
   * Product Gallery Functionality
   */
  function initProductGallery() {
    const thumbnails = document.querySelectorAll(".thumbnail-item");
    const mainImage = document.getElementById("mainProductImage");
    const prevBtn = document.getElementById("prevImage");
    const nextBtn = document.getElementById("nextImage");

    if (!mainImage || thumbnails.length === 0) return;

    let currentIndex = 0;
    const images = Array.from(thumbnails).map((thumb) => thumb.dataset.image);

    // Thumbnail click handler
    thumbnails.forEach((thumb, index) => {
      thumb.addEventListener("click", () => {
        setActiveImage(index);
      });
    });

    // Navigation buttons
    if (prevBtn) {
      prevBtn.addEventListener("click", () => {
        currentIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
        setActiveImage(currentIndex);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", () => {
        currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
        setActiveImage(currentIndex);
      });
    }

    // Keyboard navigation
    document.addEventListener("keydown", (e) => {
      if (e.key === "ArrowLeft") {
        prevBtn?.click();
      } else if (e.key === "ArrowRight") {
        nextBtn?.click();
      }
    });

    function setActiveImage(index) {
      currentIndex = index;

      // Update main image with fade effect
      mainImage.style.opacity = "0.5";
      setTimeout(() => {
        mainImage.src = images[index];
        mainImage.style.opacity = "1";
      }, 150);

      // Update active thumbnail
      thumbnails.forEach((thumb) => thumb.classList.remove("active"));
      thumbnails[index].classList.add("active");
    }

    // Auto-play slideshow (optional)
    let autoPlayInterval;

    function startAutoPlay() {
      autoPlayInterval = setInterval(() => {
        nextBtn?.click();
      }, 5000);
    }

    function stopAutoPlay() {
      clearInterval(autoPlayInterval);
    }

    // Start autoplay, pause on hover
    const galleryWrapper = document.querySelector(".product-gallery-wrapper");
    if (galleryWrapper) {
      galleryWrapper.addEventListener("mouseenter", stopAutoPlay);
      galleryWrapper.addEventListener("mouseleave", startAutoPlay);
      startAutoPlay();
    }
  }

  /**
   * Modal Gallery Functionality
   */
  function initModalGallery() {
    const modalThumbnails = document.querySelectorAll(
      "#imageModal .thumbnail-item"
    );
    const modalMainImage = document.getElementById("modalMainImage");
    const modalPrevBtn = document.getElementById("modalPrevBtn");
    const modalNextBtn = document.getElementById("modalNextBtn");

    if (!modalMainImage || modalThumbnails.length === 0) return;

    let modalCurrentIndex = 0;
    const modalImages = Array.from(modalThumbnails).map(
      (thumb) => thumb.dataset.fullImage
    );

    // Modal thumbnail clicks
    modalThumbnails.forEach((thumb, index) => {
      thumb.addEventListener("click", () => {
        setModalActiveImage(index);
      });
    });

    // Modal navigation
    if (modalPrevBtn) {
      modalPrevBtn.addEventListener("click", () => {
        modalCurrentIndex =
          modalCurrentIndex > 0
            ? modalCurrentIndex - 1
            : modalImages.length - 1;
        setModalActiveImage(modalCurrentIndex);
      });
    }

    if (modalNextBtn) {
      modalNextBtn.addEventListener("click", () => {
        modalCurrentIndex =
          modalCurrentIndex < modalImages.length - 1
            ? modalCurrentIndex + 1
            : 0;
        setModalActiveImage(modalCurrentIndex);
      });
    }

    function setModalActiveImage(index) {
      modalCurrentIndex = index;
      modalMainImage.src = modalImages[index];

      modalThumbnails.forEach((thumb) => thumb.classList.remove("active"));
      modalThumbnails[index].classList.add("active");
    }

    // Sync with main gallery
    const imageModal = document.getElementById("imageModal");
    if (imageModal) {
      imageModal.addEventListener("show.bs.modal", () => {
        const activeThumb = document.querySelector(".thumbnail-item.active");
        if (activeThumb) {
          const activeIndex = Array.from(
            document.querySelectorAll(".thumbnail-item")
          ).indexOf(activeThumb);
          setModalActiveImage(activeIndex);
        }
      });
    }
  }

  /**
   * Overlay Actions Handler
   */
  function initOverlayActions() {
    console.log("Initializing overlay actions...");

    const zoomBtn = document.querySelector(".zoom-btn");
    const fullscreenBtn = document.querySelector(".fullscreen-btn");
    const shareBtn = document.querySelector(".share-btn");

    console.log("Found buttons:", { zoomBtn, fullscreenBtn, shareBtn });

    // Zoom button - opens image modal
    if (zoomBtn) {
      zoomBtn.addEventListener("click", (e) => {
        console.log("Zoom button clicked");
        e.preventDefault();
        e.stopPropagation();
        const imageModal = new bootstrap.Modal(
          document.getElementById("imageModal")
        );
        imageModal.show();
      });

      // Add visual feedback
      zoomBtn.addEventListener("mousedown", () => {
        zoomBtn.style.transform = "scale(0.95)";
      });

      zoomBtn.addEventListener("mouseup", () => {
        zoomBtn.style.transform = "";
      });
    }

    // Fullscreen button
    if (fullscreenBtn) {
      fullscreenBtn.addEventListener("click", (e) => {
        console.log("Fullscreen button clicked");
        e.preventDefault();
        e.stopPropagation();
        openFullscreen();
      });

      // Add visual feedback
      fullscreenBtn.addEventListener("mousedown", () => {
        fullscreenBtn.style.transform = "scale(0.95)";
      });

      fullscreenBtn.addEventListener("mouseup", () => {
        fullscreenBtn.style.transform = "";
      });
    }

    // Share button
    if (shareBtn) {
      shareBtn.addEventListener("click", (e) => {
        console.log("Share button clicked");
        e.preventDefault();
        e.stopPropagation();
        handleImageShare();
      });

      // Add visual feedback
      shareBtn.addEventListener("mousedown", () => {
        shareBtn.style.transform = "scale(0.95)";
      });

      shareBtn.addEventListener("mouseup", () => {
        shareBtn.style.transform = "";
      });
    }

    // Also add touch events for mobile
    [zoomBtn, fullscreenBtn, shareBtn].forEach((btn) => {
      if (btn) {
        btn.addEventListener("touchstart", (e) => {
          e.stopPropagation();
          btn.style.transform = "scale(0.95)";
        });

        btn.addEventListener("touchend", (e) => {
          e.stopPropagation();
          btn.style.transform = "";
        });
      }
    });

    // Add mobile touch support for showing overlay
    const mainImageWrapper = document.querySelector(".main-image-wrapper");
    if (mainImageWrapper) {
      let touchTimer;

      mainImageWrapper.addEventListener("touchstart", (e) => {
        touchTimer = setTimeout(() => {
          mainImageWrapper.classList.add("show-overlay");
        }, 300);
      });

      mainImageWrapper.addEventListener("touchend", () => {
        clearTimeout(touchTimer);
        // Keep overlay visible for a moment on mobile
        setTimeout(() => {
          mainImageWrapper.classList.remove("show-overlay");
        }, 3000);
      });

      mainImageWrapper.addEventListener("touchmove", () => {
        clearTimeout(touchTimer);
      });
    }

    // Mobile floating button
    const mobileZoomBtn = document.querySelector(".mobile-zoom-btn");
    if (mobileZoomBtn) {
      mobileZoomBtn.addEventListener("click", (e) => {
        console.log("Mobile zoom button clicked");
        e.preventDefault();
        e.stopPropagation();
        const imageModal = new bootstrap.Modal(
          document.getElementById("imageModal")
        );
        imageModal.show();
      });
    }

    // Debug: Add click event to image wrapper
    if (mainImageWrapper) {
      mainImageWrapper.addEventListener("click", (e) => {
        console.log("Image wrapper clicked", e.target);
        if (
          e.target === mainImageWrapper ||
          e.target.classList.contains("product-main-image")
        ) {
          // On desktop, show overlay
          if (window.innerWidth > 768) {
            mainImageWrapper.classList.toggle("show-overlay");
            setTimeout(() => {
              mainImageWrapper.classList.remove("show-overlay");
            }, 3000);
          } else {
            // On mobile, open modal directly
            const imageModal = new bootstrap.Modal(
              document.getElementById("imageModal")
            );
            imageModal.show();
          }
        }
      });
    }

    function openFullscreen() {
      const mainImage = document.getElementById("mainProductImage");
      if (!mainImage) return;

      // Create fullscreen overlay
      const fullscreenOverlay = document.createElement("div");
      fullscreenOverlay.className = "fullscreen-overlay";
      fullscreenOverlay.innerHTML = `
        <div class="fullscreen-container">
          <img src="${mainImage.src}" alt="${mainImage.alt}" class="fullscreen-image">
          <button class="fullscreen-close">
            <i class="fas fa-times"></i>
          </button>
          <div class="fullscreen-controls">
            <button class="fullscreen-zoom-in"><i class="fas fa-search-plus"></i></button>
            <button class="fullscreen-zoom-out"><i class="fas fa-search-minus"></i></button>
            <button class="fullscreen-reset"><i class="fas fa-undo"></i></button>
          </div>
        </div>
      `;

      document.body.appendChild(fullscreenOverlay);
      document.body.style.overflow = "hidden";

      // Add event listeners
      const closeBtn = fullscreenOverlay.querySelector(".fullscreen-close");
      const zoomInBtn = fullscreenOverlay.querySelector(".fullscreen-zoom-in");
      const zoomOutBtn = fullscreenOverlay.querySelector(
        ".fullscreen-zoom-out"
      );
      const resetBtn = fullscreenOverlay.querySelector(".fullscreen-reset");
      const fullscreenImage =
        fullscreenOverlay.querySelector(".fullscreen-image");

      let scale = 1;

      closeBtn.addEventListener("click", closeFullscreen);
      fullscreenOverlay.addEventListener("click", (e) => {
        if (e.target === fullscreenOverlay) closeFullscreen();
      });

      zoomInBtn.addEventListener("click", () => {
        scale = Math.min(scale * 1.2, 3);
        fullscreenImage.style.transform = `scale(${scale})`;
      });

      zoomOutBtn.addEventListener("click", () => {
        scale = Math.max(scale / 1.2, 0.5);
        fullscreenImage.style.transform = `scale(${scale})`;
      });

      resetBtn.addEventListener("click", () => {
        scale = 1;
        fullscreenImage.style.transform = `scale(${scale})`;
      });

      // Keyboard controls
      document.addEventListener("keydown", handleFullscreenKeys);

      function handleFullscreenKeys(e) {
        switch (e.key) {
          case "Escape":
            closeFullscreen();
            break;
          case "+":
          case "=":
            zoomInBtn.click();
            break;
          case "-":
            zoomOutBtn.click();
            break;
          case "0":
            resetBtn.click();
            break;
        }
      }

      function closeFullscreen() {
        document.body.removeChild(fullscreenOverlay);
        document.body.style.overflow = "";
        document.removeEventListener("keydown", handleFullscreenKeys);
      }
    }

    function handleImageShare() {
      const mainImage = document.getElementById("mainProductImage");
      const productTitle = document.querySelector(".product-title").textContent;

      if (navigator.share) {
        navigator
          .share({
            title: productTitle,
            text: `Xem sản phẩm: ${productTitle}`,
            url: window.location.href,
          })
          .catch(console.error);
      } else {
        // Fallback: copy image URL
        navigator.clipboard
          .writeText(mainImage.src)
          .then(() => {
            showNotification("Đã sao chép link hình ảnh", "success");
          })
          .catch(() => {
            showNotification("Không thể sao chép link", "error");
          });
      }
    }
  }

  /**
   * Consultation Form Handler
   */
  function initConsultationForm() {
    const consultationBtn = document.querySelector(".contact-consultation-btn");
    const submitConsultationBtn = document.getElementById("submitConsultation");
    const consultationForm = document.getElementById("consultationForm");

    // Prevent multiple initializations
    if (window.consultationFormInitialized) {
      return;
    }
    window.consultationFormInitialized = true;

    if (consultationBtn) {
      consultationBtn.addEventListener("click", showConsultationModal);
    }

    if (submitConsultationBtn && consultationForm) {
      submitConsultationBtn.addEventListener("click", handleConsultationSubmit);
    }

    // Reset form when modal is closed
    const modalElement = document.getElementById("consultationModal");
    if (modalElement) {
      modalElement.addEventListener("hidden.bs.modal", function () {
        // Clear form
        if (consultationForm) {
          consultationForm.reset();
        }
      });
    }

    function showConsultationModal() {
      const consultationModalElement =
        document.getElementById("consultationModal");
      let consultationModal = bootstrap.Modal.getInstance(
        consultationModalElement
      );

      if (!consultationModal) {
        consultationModal = new bootstrap.Modal(consultationModalElement);

        // Add event listener for modal hidden event
        consultationModalElement.addEventListener(
          "hidden.bs.modal",
          function () {
            // Ensure backdrop is completely removed
            const backdrop = document.querySelector(".modal-backdrop");
            if (backdrop) {
              backdrop.remove();
            }
            // Clean up body classes and styles
            document.body.classList.remove("modal-open");
            document.body.style.overflow = "";
            document.body.style.paddingRight = "";
          }
        );
      }

      consultationModal.show();
    }

    function handleConsultationSubmit(e) {
      e.preventDefault();

      const formData = new FormData(consultationForm);
      const data = Object.fromEntries(formData);

      // Validate required fields
      if (!data.customer_name || !data.customer_phone) {
        showNotification("Vui lòng điền đầy đủ thông tin bắt buộc", "error");
        return;
      }

      // Disable submit button to prevent double submission
      if (submitConsultationBtn.disabled) {
        return; // Already processing
      }

      submitConsultationBtn.disabled = true;
      submitConsultationBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi yêu cầu...';

      // Prepare AJAX data
      const ajaxData = {
        action: "submit_consultation",
        nonce: window.consultationNonce || "",
        ...data,
      };

      // Get checked needs
      const checkedNeeds = Array.from(
        consultationForm.querySelectorAll('input[name="needs[]"]:checked')
      ).map((checkbox) => checkbox.value);
      ajaxData.needs = checkedNeeds;

      // Send AJAX request
      fetch(window.location.origin + "/wp-admin/admin-ajax.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: new URLSearchParams(ajaxData),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then((result) => {
          console.log("Server response:", result); // Debug log
          if (result.success) {
            showNotification(result.data.message, "success");

            // Reset form
            consultationForm.reset();

            // Reset checkboxes
            const checkboxes = consultationForm.querySelectorAll(
              'input[type="checkbox"]'
            );
            checkboxes.forEach((checkbox) => (checkbox.checked = false));

            // Close modal properly
            const consultationModalElement =
              document.getElementById("consultationModal");
            const consultationModal = bootstrap.Modal.getInstance(
              consultationModalElement
            );
            if (consultationModal) {
              consultationModal.hide();
            }

            // Đảm bảo backdrop bị xóa hoàn toàn
            setTimeout(() => {
              document
                .querySelectorAll(".modal-backdrop")
                .forEach((el) => el.remove());
              document.body.classList.remove("modal-open");
              document.body.style.overflow = "";
              document.body.style.paddingRight = "";
            }, 300);
          } else {
            // Ensure we always show Vietnamese error message
            const errorMessage =
              result.data && result.data.message
                ? result.data.message
                : "Có lỗi xảy ra, vui lòng thử lại sau.";
            showNotification(errorMessage, "error");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          showNotification(
            "Có lỗi xảy ra khi gửi yêu cầu. Vui lòng kiểm tra kết nối internet và thử lại.",
            "error"
          );
        })
        .finally(() => {
          // Reset button
          submitConsultationBtn.disabled = false;
          submitConsultationBtn.innerHTML =
            '<i class="fas fa-paper-plane me-2"></i>Gửi yêu cầu tư vấn';
        });
    }
  }

  /**
   * Social Actions
   */
  function initSocialActions() {
    const wishlistBtn = document.querySelector(".wishlist-btn");
    const shareBtn = document.querySelector(".share-btn");
    const compareBtn = document.querySelector(".compare-btn");

    if (wishlistBtn) {
      wishlistBtn.addEventListener("click", handleWishlist);
    }

    if (shareBtn) {
      shareBtn.addEventListener("click", handleShare);
    }

    if (compareBtn) {
      compareBtn.addEventListener("click", handleCompare);
    }

    function handleWishlist() {
      const icon = wishlistBtn.querySelector("i");
      const isActive = icon.classList.contains("fas");

      if (isActive) {
        icon.classList.remove("fas");
        icon.classList.add("far");
        wishlistBtn.classList.remove("btn-danger");
        wishlistBtn.classList.add("btn-outline-secondary");
        showNotification("Đã xóa khỏi danh sách yêu thích", "info");
      } else {
        icon.classList.remove("far");
        icon.classList.add("fas");
        wishlistBtn.classList.remove("btn-outline-secondary");
        wishlistBtn.classList.add("btn-danger");
        showNotification("Đã thêm vào danh sách yêu thích", "success");
      }
    }

    function handleShare() {
      if (navigator.share) {
        navigator.share({
          title: document.title,
          text: document.querySelector(".product-title").textContent,
          url: window.location.href,
        });
      } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
          showNotification("Đã sao chép link sản phẩm", "success");
        });
      }
    }

    function handleCompare() {
      const productId = document.querySelector(
        'input[name="product_id"]'
      )?.value;
      let compareList = JSON.parse(localStorage.getItem("compareList") || "[]");

      if (compareList.includes(productId)) {
        compareList = compareList.filter((id) => id !== productId);
        compareBtn.classList.remove("btn-warning");
        compareBtn.classList.add("btn-outline-secondary");
        showNotification("Đã xóa khỏi danh sách so sánh", "info");
      } else {
        if (compareList.length >= 3) {
          showNotification("Chỉ có thể so sánh tối đa 3 sản phẩm", "warning");
          return;
        }
        compareList.push(productId);
        compareBtn.classList.remove("btn-outline-secondary");
        compareBtn.classList.add("btn-warning");
        showNotification("Đã thêm vào danh sách so sánh", "success");
      }

      localStorage.setItem("compareList", JSON.stringify(compareList));
    }
  }

  /**
   * Animations and Effects
   */
  function initAnimations() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate-fade-in");
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    // Observe elements
    const animatedElements = document.querySelectorAll(
      ".trust-indicators, .key-features, .social-proof, .contact-info-enhanced"
    );
    animatedElements.forEach((el) => observer.observe(el));

    // Counter animation for social proof
    const counters = document.querySelectorAll(".proof-item strong");
    counters.forEach((counter) => {
      const target = parseInt(counter.textContent.replace(/,/g, ""));
      if (target) {
        animateCounter(counter, target);
      }
    });

    function animateCounter(element, target) {
      let current = 0;
      const increment = target / 100;
      const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
          current = target;
          clearInterval(timer);
        }
        element.textContent = Math.floor(current).toLocaleString();
      }, 20);
    }

    // Parallax effect for hero background (only within hero section)
    window.addEventListener("scroll", () => {
      const scrolled = window.pageYOffset;
      const parallax = document.querySelector(".hero-background-pattern");
      const heroSection = document.querySelector(".product-hero-section");

      if (parallax && heroSection) {
        const heroRect = heroSection.getBoundingClientRect();
        const heroBottom = heroRect.bottom + scrolled;

        // Only apply parallax when within hero section bounds
        if (scrolled < heroBottom && heroRect.top <= 0) {
          const parallaxOffset = Math.min(scrolled * 0.3, heroBottom * 0.3);
          parallax.style.transform = `translateY(${parallaxOffset}px)`;
        } else if (scrolled >= heroBottom) {
          // Fix position when scrolled past hero section
          parallax.style.transform = `translateY(${heroBottom * 0.3}px)`;
        } else {
          // Reset when above hero section
          parallax.style.transform = `translateY(0px)`;
        }
      }
    });
  }

  /**
   * Utility Functions
   */
  function showNotification(message, type = "info") {
    // Create notification element
    const notification = document.createElement("div");
    notification.className = `alert alert-${type} notification-toast`;
    notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${getIconForType(type)} me-2"></i>
                <span>${message}</span>
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;

    // Style notification
    notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideInRight 0.3s ease;
        `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
      if (notification.parentElement) {
        notification.style.animation = "slideOutRight 0.3s ease";
        setTimeout(() => notification.remove(), 300);
      }
    }, 5000);
  }

  function getIconForType(type) {
    const icons = {
      success: "check-circle",
      error: "exclamation-circle",
      warning: "exclamation-triangle",
      info: "info-circle",
    };
    return icons[type] || "info-circle";
  }

  // NOTE: CSS animations and styles moved to single-product.css for better architecture
});
