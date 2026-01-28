// JS FOR CUSTOM PRODUCT PAGE

(function ($) {
  "use strict";

  $(document).ready(function () {

    $(document).on("click", ".size-option", function (e) {
      e.preventDefault();
      $(".size-option").removeClass("active");
      $(this).addClass("active");
      var selectedSize = $(this).data("size");
      $("#product-size").val(selectedSize);
    });


    $(document).on("click", ".qty-btn.plus", function (e) {
      e.preventDefault();
      e.stopPropagation();
      var $input = $(this).siblings("input.qty");
      var currentVal = parseInt($input.val()) || 0;
      var max = parseInt($input.attr("max")) || 999;

      if (currentVal < max) {
        $input.val(currentVal + 1);
        $input.trigger("change");
      }
    });

    $(document).on("click", ".qty-btn.minus", function (e) {
      e.preventDefault();
      e.stopPropagation();
      var $input = $(this).siblings("input.qty");
      var currentVal = parseInt($input.val()) || 1;
      var min = parseInt($input.attr("min")) || 1; 

      if (currentVal > min) {
        $input.val(currentVal - 1);
        $input.trigger("change");
      }
    });

    $(document).on("click", ".product-wishlist-btn", function (e) {
      e.preventDefault();
      $(this).toggleClass("active");
      var $svg = $(this).find("svg path");
      if ($(this).hasClass("active")) {
        $svg.attr("fill", "currentColor");
        console.log("Added to wishlist");
      } else {
        $svg.attr("fill", "none");
        console.log("Removed from wishlist");
      }  
    });


    function createThumbnailNavigation() {
      var $thumbnailSection = $(".wc-block-product-gallery-thumbnails");

      if ($thumbnailSection.length === 0) {
        console.log("Thumbnail section not found");
        return;
      }

      console.log("Creating thumbnail navigation buttons");

      $(".thumbnail-nav-button").remove();

      $(".wc-block-next-previous-buttons").hide();

      var $upButton = $("<button>", {
        class: "thumbnail-nav-button thumbnail-nav-up",
        "aria-label": "Previous image",
        html: '<svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" fill="none"><path fill="currentColor" fill-rule="evenodd" d="M6.445 12.005.986 6 6.445-.005l1.11 1.01L3.014 6l4.54 4.995-1.109 1.01Z" clip-rule="evenodd"/></svg>',
      });

      var $downButton = $("<button>", {
        class: "thumbnail-nav-button thumbnail-nav-down",
        "aria-label": "Next image",
        html: '<svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" fill="none"><path fill="currentColor" fill-rule="evenodd" d="M1.555-.004 7.014 6l-5.459 6.005-1.11-1.01L4.986 6 .446 1.005l1.109-1.01Z" clip-rule="evenodd"/></svg>',
      });

      $upButton.on("click", function (e) {
        e.preventDefault();
        scrollThumbnails("up");
      });

      $downButton.on("click", function (e) {
        e.preventDefault();
        scrollThumbnails("down");
      });

      $upButton.add($downButton).hover(
        function () {
          $(this).css({
            backgroundColor: "#4a3b6b",
            borderColor: "#4a3b6b",
          });
          $(this).find("path").css("fill", "white");
        },
        function () {
          $(this).css({
            backgroundColor: "white",
            borderColor: "#e5e5e5",
          });
          $(this).find("path").css("fill", "currentColor");
        }
      );

      $thumbnailSection.css("position", "relative");

      $thumbnailSection.prepend($upButton);
      $thumbnailSection.append($downButton);

      console.log("Thumbnail navigation buttons created successfully");
    }


    function scrollThumbnails(direction) {
      var $scrollable = $(".wc-block-product-gallery-thumbnails__scrollable");
      var $thumbnails = $(".wc-block-product-gallery-thumbnails__thumbnail");

      if ($thumbnails.length === 0) {
        console.log("No thumbnails found");
        return;
      }

      var thumbnailHeight = $thumbnails.first().outerHeight(true);
      var currentScroll = $scrollable.scrollTop();

      if (direction === "up") {
        $scrollable.animate(
          { scrollTop: currentScroll - thumbnailHeight },
          300
        );
        triggerPreviousImage();
      } else {
        $scrollable.animate(
          { scrollTop: currentScroll + thumbnailHeight },
          300
        );
        triggerNextImage();
      }
    }

    function triggerPreviousImage() {
      var $active = $(
        ".wc-block-product-gallery-thumbnails__thumbnail__image--is-active"
      );
      var $prev = $active
        .closest(".wc-block-product-gallery-thumbnails__thumbnail")
        .prev();
      if ($prev.length) {
        $prev.find("img").click();
      }
    }


    function triggerNextImage() {
      var $active = $(
        ".wc-block-product-gallery-thumbnails__thumbnail__image--is-active"
      );
      var $next = $active
        .closest(".wc-block-product-gallery-thumbnails__thumbnail")
        .next();
      if ($next.length) {
        $next.find("img").click();
      }
    }

    function initThumbnailNav() {
      var attempts = 0;
      var maxAttempts = 10;

      var initInterval = setInterval(function () {
        attempts++;
        var $thumbnailSection = $(".wc-block-product-gallery-thumbnails");

        if ($thumbnailSection.length > 0) {
          console.log("Thumbnail section found, initializing navigation");
          createThumbnailNavigation();
          clearInterval(initInterval);
        } else if (attempts >= maxAttempts) {
          console.log("Max attempts reached, thumbnail section not found");
          clearInterval(initInterval);
        }
      }, 300);
    }


    initThumbnailNav();


    $(document.body).on("wc_gallery_init", function () {
      console.log("Gallery initialized, recreating navigation");
      setTimeout(createThumbnailNavigation, 100);
    });


    $(window).on("load", function () {
      setTimeout(createThumbnailNavigation, 500);
    });


    $(".woocommerce-tabs ul.tabs li a").on("click", function (e) {
      var target = $(this).attr("href");
      if (target && target.indexOf("#") === 0) {
        e.preventDefault();
        $("html, body").animate(
          { scrollTop: $(target).offset().top - 100 },
          500
        );
        $(".woocommerce-tabs ul.tabs li").removeClass("active");
        $(this).parent().addClass("active");
        $(".woocommerce-Tabs-panel").hide();
        $(target).show();
      }
    });


    $(".flex-control-thumbs li").on("click", function () {
      var $img = $(this).find("img");
      var imgSrc = $img.attr("src");
      var imgSrcSet = $img.attr("srcset");
      $(".woocommerce-product-gallery__image img").attr("src", imgSrc);
      if (imgSrcSet) {
        $(".woocommerce-product-gallery__image img").attr("srcset", imgSrcSet);
      }
      $(".flex-control-thumbs li").removeClass("flex-active");
      $(this).addClass("flex-active");
    });


    $("form.cart").on("submit", function (e) {
      var quantity = parseInt($(".qty").val());
      if (quantity < 1) {
        e.preventDefault();
        alert("Please select a valid quantity");
        return false;
      }
    });


    $(".star-rating").hover(
      function () {
        $(this).css("transform", "scale(1.05)");
      },
      function () {
        $(this).css("transform", "scale(1)");
      }
    );
  });
})(jQuery);
