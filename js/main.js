window.addEventListener("load", (event) => {
  document.body.classList.remove("loading");
});

(function ($) {
  //document ready
  //GLOBAL ANIMATIONS
  $("#search-posts").keypress(function (e) {
    if (e.which == 13) return false;
    //or...
    if (e.which == 13) e.preventDefault();
  });

  $(".mobile_opener").on("click", function () {
    $(this).toggleClass("active white");
    $(".site-header").toggleClass("white dark-header");
    $(".mobile_navigation").fadeToggle().css("display", "flex");
    $("body").toggleClass("no_scroll");

    if ($(".site-header").hasClass("dark-logo")) {
      setTimeout(function () {
        if (!$(".site-header").hasClass("dark-header")) {
          $(".site-header .bottom .logo img").attr(
            "src",
            site_data.theme_url + "/images/logo.svg"
          );
        } else {
          $(".site-header .bottom .logo img").attr(
            "src",
            site_data.theme_url + "/images/logo-dark.svg"
          );
        }
      }, 200);
    }
  });

  $(window).on("load", function () {
    let animationTrigger = $(".fadein_wrap");
    animationTrigger.each(function () {
      let trigger = $(this);
      gsap.to(animationTrigger, {
        scrollTrigger: {
          trigger: trigger,
          start: "top 80%",

          onEnter: function () {
            $(trigger).addClass("in_view");
          },
        },
      });
    });

    var mySplitText = new SplitText($(".letter_wrap, .letter_wrap_scroll"), {
      type: "lines",
      linesClass: "line line++",
    });

    gsap.utils.toArray(".letter_wrap").forEach((section) => {
      gsap.from(section.querySelectorAll("div.char"), {
        scrollTrigger: {
          trigger: section,
          onEnter: function () {
            $(section).addClass("active");
          },
        },
        //   y: 1000,
        //   opacity: 0,
        //   duration: 0.5,
        //   stagger: 0.007,
        ease: "Power1.easeOut",
      });
    });
  });

  gsap.registerPlugin(ScrollTrigger);

  //GLOBAL ANIMATIONS END

  //Template Home

  let faqTrigger = $(".faq-section");
  var interval;
  var accordionTimer = function () {
    interval = setInterval(function () {
      var activeSlider = $(".single-accordion.active");
      var nextAccordion = activeSlider.data("next");
      $("#" + nextAccordion).trigger("click");
    }, 5000);
  };

  faqTrigger.each(function () {
    let trigger = $(this);
    gsap.to(faqTrigger, {
      scrollTrigger: {
        trigger: trigger,
        start: "top 80%",

        onEnter: function () {
          accordionTimer();
        },
      },
    });
  });

  let $singleAccordion = $(".single-accordion");
  $singleAccordion.on("click", function (e) {
    clearInterval(interval);
    accordionTimer();

    if (!$(this).hasClass("active")) {
      let currentImage = $(this).attr("id");
      $(".faq-section .right img").each(function (index) {
        if ($(this).data("id") == currentImage) {
          $(".faq-section .right img").removeClass("active");
          $(this).addClass("active");
        }
      });

      $singleAccordion.removeClass("active");
      $(".accordion-description").slideUp();

      $(this).addClass("active");
      $(this).find(".accordion-description").slideDown();
    } else {
      $(this).removeClass("active");
      $(".accordion-description").slideUp();
    }
  });

  $(window).on("load", function () {
    if ($("body").hasClass("home")) {
      var sections = document.querySelectorAll(
        ".features-section .left > .single-feature"
      );

      var images = document.querySelectorAll(
        ".features-section .image-holder > img:not(:first-of-type)"
      );

      setTimeout(() => {
        images.forEach((img) => {
          img.style.display = "none";
        });
      }, 500);

      sections.forEach((section, i) => {
        var end = section.clientHeight;
        gsap.to(section, 1, {
          scrollTrigger: {
            trigger: section,
            start: "top 50%",
            end: "+=" + end,
            onToggle: function ({ isActive, direction }) {
              if (isActive) {
                if (direction > 0) {
                  if (i == 0) {
                    gsap.to(".messaging", { display: "block", stagger: 0.1 });
                  } else if (i == 1) {
                    gsap.to(".real-numbers", {
                      display: "block",
                      stagger: 0.1,
                    });
                  } else if (i == 2) {
                    gsap.to(".throughput", { display: "block", stagger: 0.1 });
                  }
                } else {
                  if (i == 0) {
                    gsap.to(".throughput, .messaging, .real-numbers", {
                      display: "none",
                    });
                    gsap.to(".messaging", { display: "block", stagger: 0.1 });
                  } else if (i == 1) {
                    gsap.to(".throughput, .messaging, .real-numbers", {
                      display: "none",
                    });
                    gsap.to(".real-numbers", {
                      display: "block",
                      stagger: 0.1,
                    });
                  } else if (i == 2) {
                    gsap.to(".throughput, .messaging, .real-numbers", {
                      display: "none",
                    });
                    gsap.to(".throughput", { display: "block", stagger: 0.1 });
                  }
                }
              }
            },
          },
        });
      });
    }
  });
  //Template Home END

  //Template About
  jQuery(".history-slider").slick({
    arrows: false,
    slidesToShow: 1,
    centerMode: true,
    rtl: true,
    draggable: false,
    touchMove: false,
  });

  if ($(window).width() < 750) {
    ScrollTrigger.matchMedia({
      // desktop
      "(min-width: 100px)": function () {
        let sections = $(".page-template-about-container .single_box");
        let container = $(".history-slider");

        sections.each(function () {
          let trigger = $(this);
          let slideIndex = trigger.index();

          gsap.to(container, {
            scrollTrigger: {
              trigger: trigger,
              start: "top 0%",
              end: "bottom 50%",
              onEnter: function () {
                $(".history-slider").slick("slickGoTo", slideIndex);
                $(trigger).find(".year").addClass("active");
              },
              onLeaveBack: function () {
                $(".history-slider").slick("slickGoTo", slideIndex);
                $(trigger).find(".year").removeClass("active");
              },
              onUpdate: (self) =>
                $(this)
                  .find(".white-line")
                  .css("height", self.progress * 100 + "%"),
            },
          });
        });
      },
    });
  } else {
    ScrollTrigger.matchMedia({
      "(min-width: 100px)": function () {
        let sections = $(".page-template-about-container .single_box");
        let container = $(".history-slider");

        sections.each(function () {
          let trigger = $(this);
          let slideIndex = trigger.index();

          gsap.to(container, {
            scrollTrigger: {
              trigger: trigger,
              start: "top 50%",
              end: "bottom 50%",
              onEnter: function () {
                $(".history-slider").slick("slickGoTo", slideIndex);
                $(trigger).find(".year").addClass("active");
              },
              onLeaveBack: function () {
                $(".history-slider").slick("slickGoTo", slideIndex);
                $(trigger).find(".year").removeClass("active");
              },
              onUpdate: (self) =>
                $(this)
                  .find(".white-line")
                  .css("height", self.progress * 100 + "%"),
            },
          });
        });
      },
    });
  }

  //Template About END

  var postsSlider2 = new Swiper(".posts-slider-2", {
    slidesPerView: 1.15,
    spaceBetween: 30,
    watchOverflow: true,
    speed: 1000,
    autoHeight: true,
    breakpoints: {
      // when window width is >= 320px
      768: {
        slidesPerView: 2.2,
      },
      // when window width is >= 640px
      1024: {
        slidesPerView: 3,
      },
      1400: {
        spaceBetween: 60,
        slidesPerView: 3,
      },
    },
  });

  var postsSlider = new Swiper(".posts-slider", {
    slidesPerView: 1.54,
    spaceBetween: 100,
    watchOverflow: true,
    speed: 1000,
    pagination: {
      el: ".posts-slider-pagination",
      // type: 'fraction',
      type: "custom",
      renderCustom: function (swiper, current, total) {
        return current + " of " + total;
      },
    },
    navigation: {
      nextEl: ".posts-slider-btn-next",
      prevEl: ".posts-slider-btn-prev",
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        spaceBetween: 30,
        slidesPerView: 1.1,
      },
      // when window width is >= 640px
      750: {
        slidesPerView: 1.54,
        spaceBetween: 50,
      },
      // when window width is >= 640px
      1500: {
        spaceBetween: 100,
      },
    },
  });

  //Template Contact
  let $formFilterItems = $(".form-selector li");
  let $formsHolder = $(".forms");
  let $forms = $(".form-container");

  if (window.location.href.indexOf("join") > -1) {
    console.log("radi");
    setTimeout(function () {
      $('.form-selector li[data-form=".form-1"]').trigger("click");
    }, 500);
  }

  $formFilterItems.on("click", function () {
    if (!$(this).hasClass("active")) {
      $formsHolder.addClass("loading");

      $formFilterItems.removeClass("active");
      $(this).addClass("active");
      let target = $(this).data("form");

      setTimeout(function () {
        $forms.removeClass("active");
        $(target).addClass("active");
        $formsHolder.removeClass("loading");
      }, 300);
    }
  });
  //Template Contact END

  //Blog page
  const $checkSiteNameInput = $("#search-posts");
  let timer;
  const waitTime = 500;
  const $postsForm = $("#posts-form");
  const $postsResponse = $("#posts-response");
  const $postsPageInput = $("#posts-page-input");

  function filterPosts() {
    $postsResponse.addClass("loading");

    setTimeout(function () {
      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        data: $postsForm.serialize(),
        type: "GET",
        beforeSend: function (xhr) {},
        success: function (data) {
          document.getElementById("posts-response").innerHTML = data;
        },
        complete: function (data) {
          $postsResponse.removeClass("loading");
        },
      });
    }, 300);
  }

  $checkSiteNameInput.keyup(function () {
    $postsPageInput.val(1);

    // Clear timer
    clearTimeout(timer);

    // Wait for X ms and then process the request
    timer = setTimeout(function () {
      filterPosts();
    }, waitTime);
  });

  $postsResponse.on("click", ".pagination-page", function () {
    $postsPageInput.val($(this).data("page"));
    filterPosts();
  });
  //Blog page END

  //get started and contact page templates
  if (
    $(".page-template-get-started-container").length ||
    $(".page-template-contact-container").length
  ) {
    $(".acf-basic-uploader").on("click", ".clear-input", function (event) {
      event.preventDefault();
      let $inputWrapper = $(this).parent();
      $inputWrapper.find("input").val("").change();
    });

    $("input[type=file]").on("change", function () {
      let file = $(this)[0].files[0];
      let $inputWrapper = $(this).parent();

      if (file) {
        $inputWrapper
          .addClass("file-is-selected")
          .append('<p class="file-name">' + file.name + "</p>");
        $inputWrapper.append('<p class="clear-input"> Clear </p>');
      } else {
        $inputWrapper
          .removeClass("file-is-selected")
          .find(".clear-input")
          .remove();
        $inputWrapper.find(".file-name").remove();
      }
    });
  }
  //get started and contact page templates END

  $(window).load(function () {});

  $(window).scroll(function () {});

  $(window).resize(function () {});
})(jQuery);
