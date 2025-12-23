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

    // Initialize header features (existing)
    initDateTime();
    initWeather();

    // Homepage features removed - simple homepage only

    // Auto-refresh weather every 15 minutes
    setInterval(function () {
      var useCurrentLocation =
        localStorage.getItem("useCurrentLocation") === "true";
      if (useCurrentLocation) {
        var coords = localStorage.getItem("currentLocationCoords");
        if (coords) {
          var latLon = coords.split(",");
          getWeatherData(parseFloat(latLon[0]), parseFloat(latLon[1]));
        } else {
          var savedLocation =
            localStorage.getItem("selectedLocation") || "hanoi";
          updateWeatherByLocation(savedLocation);
        }
      } else {
        var savedLocation = localStorage.getItem("selectedLocation") || "hanoi";
        updateWeatherByLocation(savedLocation);
      }
    }, 15 * 60 * 1000); // 15 minutes
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

  // DateTime Widget (header feature - keep original)
  function initDateTime() {
    updateDateTime();
    setInterval(updateDateTime, 1000);
  }

  function updateDateTime() {
    var now = new Date();
    var timeString = now.toLocaleTimeString("vi-VN", {
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit",
    });

    // Format: Thứ Tư, 16/07/2025
    var weekday = now.toLocaleDateString("vi-VN", { weekday: "long" });
    var day = String(now.getDate()).padStart(2, "0");
    var month = String(now.getMonth() + 1).padStart(2, "0");
    var year = now.getFullYear();
    var dateString = weekday + ", " + day + "/" + month + "/" + year;

    $("#current-time").text(timeString);
    $("#current-date").text(dateString);
  }

  // Weather Widget (header feature - keep original)
  function initWeather() {
    var useCurrentLocation =
      localStorage.getItem("useCurrentLocation") === "true";

    if (useCurrentLocation) {
      var coords = localStorage.getItem("currentLocationCoords");
      if (coords) {
        var latLon = coords.split(",");
        getWeatherData(parseFloat(latLon[0]), parseFloat(latLon[1]));
        // Try to get location name again
        getReverseGeocoding(parseFloat(latLon[0]), parseFloat(latLon[1]));
      } else {
        // Fallback to default location
        var savedLocation = localStorage.getItem("selectedLocation") || "hanoi";
        $("#location-select").val(savedLocation);
        updateWeatherByLocation(savedLocation);
      }
    } else {
      var savedLocation = localStorage.getItem("selectedLocation") || "hanoi";
      $("#location-select").val(savedLocation);
      updateWeatherByLocation(savedLocation);
    }

    // Location change handler
    $("#location-select").change(function () {
      var location = $(this).val();

      if (location === "current") {
        // Use saved current location coordinates
        var coords = localStorage.getItem("currentLocationCoords");
        if (coords) {
          var latLon = coords.split(",");
          getWeatherData(parseFloat(latLon[0]), parseFloat(latLon[1]));
          localStorage.setItem("useCurrentLocation", "true");
          localStorage.removeItem("selectedLocation");
        } else {
          // If no saved coords, get current location
          getCurrentLocation();
        }
      } else {
        // Use predefined location
        updateWeatherByLocation(location);
        localStorage.setItem("useCurrentLocation", "false");
        updateLocationSelector("", false); // Remove current location option
      }
    });

    // Get current location
    $("#get-location").click(function () {
      getCurrentLocation();
    });
  }

  function updateWeatherByLocation(location) {
    var coordinates = getCoordinatesByLocation(location);
    if (coordinates) {
      getWeatherData(coordinates.lat, coordinates.lon);
      localStorage.setItem("selectedLocation", location);
    }
  }

  function getCoordinatesByLocation(location) {
    var locations = {
      hanoi: { lat: 21.0285, lon: 105.8542 },
      hochiminh: { lat: 10.8231, lon: 106.6297 },
      danang: { lat: 16.0544, lon: 108.2022 },
      haiphong: { lat: 20.8449, lon: 106.6881 },
      cantho: { lat: 10.0452, lon: 105.7469 },
    };
    return locations[location];
  }

  function getCurrentLocation() {
    if (navigator.geolocation) {
      $("#get-location").addClass("location-loading");
      navigator.geolocation.getCurrentPosition(
        function (position) {
          var lat = position.coords.latitude;
          var lon = position.coords.longitude;

          // Update weather data
          getWeatherData(lat, lon);

          // Get location name using reverse geocoding
          getReverseGeocoding(lat, lon);

          // Save current location flag
          localStorage.setItem("useCurrentLocation", "true");
          localStorage.setItem("currentLocationCoords", lat + "," + lon);

          $("#get-location").removeClass("location-loading");
        },
        function (error) {
          console.error("Error getting location:", error);
          $("#get-location").removeClass("location-loading");
          alert(
            "Không thể lấy vị trí hiện tại. Vui lòng cho phép truy cập vị trí."
          );
        }
      );
    } else {
      alert("Trình duyệt không hỗ trợ geolocation.");
    }
  }

  function getReverseGeocoding(lat, lon) {
    // Try to get location name using reverse geocoding
    if (
      typeof tdWeatherConfig !== "undefined" &&
      tdWeatherConfig.apiKey &&
      tdWeatherConfig.apiKey.length > 0
    ) {
      var apiKey = tdWeatherConfig.apiKey;
      var url = `https://api.openweathermap.org/geo/1.0/reverse?lat=${lat}&lon=${lon}&limit=1&appid=${apiKey}`;

      $.ajax({
        url: url,
        method: "GET",
        success: function (data) {
          if (data && data.length > 0) {
            var locationName = data[0].name || "Vị trí hiện tại";
            updateLocationSelector(locationName, true);
          } else {
            updateLocationSelector("Vị trí hiện tại", true);
          }
        },
        error: function () {
          updateLocationSelector("Vị trí hiện tại", true);
        },
      });
    } else {
      updateLocationSelector("Vị trí hiện tại", true);
    }
  }

  function updateLocationSelector(locationName, isCurrentLocation) {
    var $select = $("#location-select");

    if (isCurrentLocation) {
      // Add or update current location option
      var currentLocationOption = $select.find('option[value="current"]');
      if (currentLocationOption.length === 0) {
        $select.prepend(
          '<option value="current">📍 ' + locationName + "</option>"
        );
      } else {
        currentLocationOption.text("📍 " + locationName);
      }
      $select.val("current");
    } else {
      // Remove current location option if exists
      $select.find('option[value="current"]').remove();
    }
  }

  function getWeatherData(lat, lon) {
    $("#weather-temp").text("--°C");
    $("#weather-desc").text("Đang tải...");

    // Try to get real weather data first
    getRealWeatherData(lat, lon);
  }

  function getRealWeatherData(lat, lon) {
    // Create cache key based on location
    var cacheKey =
      "weather_" + Math.round(lat * 1000) + "_" + Math.round(lon * 1000);
    var cached = localStorage.getItem(cacheKey);
    var now = new Date().getTime();

    // Check if we have cached data less than 10 minutes old
    if (cached) {
      var cachedData = JSON.parse(cached);
      if (now - cachedData.timestamp < 600000) {
        // 10 minutes
        updateWeatherDisplay(cachedData.data);
        return;
      }
    }

    // Check if we have API key configured
    if (
      typeof tdWeatherConfig !== "undefined" &&
      tdWeatherConfig.apiKey &&
      tdWeatherConfig.apiKey.length > 0
    ) {
      var apiKey = tdWeatherConfig.apiKey;
      var url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric&lang=vi`;

      $.ajax({
        url: url,
        method: "GET",
        success: function (data) {
          var weatherData = {
            temp: Math.round(data.main.temp),
            description: capitalizeFirstLetter(data.weather[0].description),
            iconCode: data.weather[0].icon,
          };

          // Cache the data
          localStorage.setItem(
            cacheKey,
            JSON.stringify({
              data: weatherData,
              timestamp: now,
            })
          );

          updateWeatherDisplay(weatherData);
        },
        error: function () {
          console.log("Weather API failed, using fallback data");
          getConsistentMockWeatherData(lat, lon);
        },
      });
    } else {
      // Fallback to consistent mock data
      getConsistentMockWeatherData(lat, lon);
    }
  }

  function updateWeatherDisplay(weatherData) {
    var weatherIcon = weatherData.iconCode;

    // If iconCode is an OpenWeatherMap icon code, convert it
    if (weatherData.iconCode && weatherData.iconCode.length === 3) {
      weatherIcon = getWeatherIcon(weatherData.iconCode);
    }

    $("#weather-temp").text(weatherData.temp + "°C");
    $("#weather-desc").text(weatherData.description);

    // Update weather icon
    var weatherIconElement = $(".weather-info .weather-icon");
    if (weatherIconElement.length > 0) {
      weatherIconElement
        .removeClass()
        .addClass(weatherIcon + " weather-icon me-1");
    }
  }

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  function getWeatherIcon(iconCode) {
    var iconMap = {
      "01d": "fas fa-sun",
      "01n": "fas fa-moon",
      "02d": "fas fa-cloud-sun",
      "02n": "fas fa-cloud-moon",
      "03d": "fas fa-cloud",
      "03n": "fas fa-cloud",
      "04d": "fas fa-cloud",
      "04n": "fas fa-cloud",
      "09d": "fas fa-cloud-rain",
      "09n": "fas fa-cloud-rain",
      "10d": "fas fa-cloud-sun-rain",
      "10n": "fas fa-cloud-moon-rain",
      "11d": "fas fa-bolt",
      "11n": "fas fa-bolt",
      "13d": "fas fa-snowflake",
      "13n": "fas fa-snowflake",
      "50d": "fas fa-smog",
      "50n": "fas fa-smog",
    };
    return iconMap[iconCode] || "fas fa-cloud-sun";
  }

  function getConsistentMockWeatherData(lat, lon) {
    // Consistent weather data based on location coordinates
    var weatherData = {
      // Hanoi
      "21.0285,105.8542": {
        temp: 28,
        description: "Nắng ít mây",
        icon: "fas fa-cloud-sun",
      },
      // Ho Chi Minh
      "10.8231,106.6297": {
        temp: 32,
        description: "Nắng nóng",
        icon: "fas fa-sun",
      },
      // Da Nang
      "16.0544,108.2022": {
        temp: 26,
        description: "Có mây",
        icon: "fas fa-cloud",
      },
      // Hai Phong
      "20.8449,106.6881": {
        temp: 25,
        description: "Mưa nhẹ",
        icon: "fas fa-cloud-rain",
      },
      // Can Tho
      "10.0452,105.7469": {
        temp: 30,
        description: "Nắng ít mây",
        icon: "fas fa-cloud-sun",
      },
    };

    // Create key from coordinates (rounded to 4 decimal places)
    var locationKey =
      Math.round(lat * 10000) / 10000 + "," + Math.round(lon * 10000) / 10000;

    // Get weather data for location, or default
    var weather = weatherData[locationKey] || {
      temp: 27,
      description: "Trời đẹp",
      icon: "fas fa-cloud-sun",
    };

    setTimeout(function () {
      var weatherData = {
        temp: weather.temp,
        description: weather.description,
        iconCode: weather.icon,
      };

      updateWeatherDisplay(weatherData);
    }, 500);
  }

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
