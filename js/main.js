window.addEventListener('load', (event) => {
    document.body.classList.remove("loading");
});

(function ($) { //document ready
    //GLOBAL ANIMATIONS


    gsap.registerPlugin(ScrollTrigger);

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
        type: "lines, words, chars",
        wordsClass: "word word++",
        linesClass: "line line++",
        charsClass: "char char++",
    });

    gsap.utils.toArray(".letter_wrap").forEach((section) => {
  
        gsap.from(section.querySelectorAll("div.char"), {
          scrollTrigger: {
            trigger: section,
          },
  
          y: 1000,
          opacity: 0,
          duration: 0.5,
          stagger: 0.007,
          ease: "Power1.easeOut",
        });
    });
    //GLOBAL ANIMATIONS END

    //Template Home

    // var interval;
    // var accordionTimer = function(){
    //     interval = setInterval(function(){
    //         var activeSlider = $('.single-accordion.active');
    //         var nextAccordion = activeSlider.data('next');
    //         $('#' + nextAccordion).trigger('click');
    //     }, 5000)
    // };
    // accordionTimer();

    let $singleAccordion = $('.single-accordion');
    $singleAccordion.on('click', function(e){
        // clearInterval(interval);
        // accordionTimer();

        if( !$(this).hasClass('active') ) {
            let currentImage = $(this).attr('id');
            $( ".faq-section .right img" ).each(function( index ) {
                if($(this).data('id') == currentImage){
                    $( ".faq-section .right img" ).removeClass('active');
                    $(this).addClass('active');
                }
            });

            $singleAccordion.removeClass('active');
            $('.accordion-description').slideUp();

            $(this).addClass('active');
            $(this).find('.accordion-description').slideDown();
        } else {
            $(this).removeClass('active');
            $('.accordion-description').slideUp();
        }
    });

    if($('body').hasClass('home')){

        setTimeout(function(){
            video = document.querySelector('video');
            gsap.to(".bound", {
                scrollTrigger: {
                    trigger: ".bound",
                    start: "top top",
                    end: "bottom bottom",
                    onUpdate: self => video.currentTime = video.duration * self.progress
                },
            });
        }, 500)
    }
    //Template Home END

    //Template About
    jQuery('.history-slider').slick({
        arrows: false,
        slidesToShow: 1,
        centerMode: true,
        rtl: true,
        draggable: false,
        touchMove: false,
    });

    ScrollTrigger.matchMedia({
        // desktop
        "(min-width: 800px)": function () {
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
                            $('.history-slider').slick('slickGoTo', slideIndex);
                            $(trigger).find('.year').addClass('active');
                        },
                        onLeaveBack: function () {
                            $('.history-slider').slick('slickGoTo', slideIndex);
                            $(trigger).find('.year').removeClass('active');
                        },
                        onUpdate: self => $(this).find('.white-line').css('height', self.progress * 100+'%' )
                    },
                });
            });
        },
    });
    //Template About END

    var postsSlider2 = new Swiper(".posts-slider-2", {
        slidesPerView: 3,
        spaceBetween: 60,
        watchOverflow: true,
        speed: 1000,
    });

    var postsSlider = new Swiper(".posts-slider", {
        slidesPerView: 1.54,
        spaceBetween: 100,
        watchOverflow: true,
        speed: 1000,
        pagination: {
            el: ".posts-slider-pagination",
            // type: 'fraction',
            type: 'custom',
            renderCustom: function (swiper, current, total) {
                return current + ' of ' + total;
            }
        },
        navigation: {
            nextEl: '.posts-slider-btn-next',
            prevEl: '.posts-slider-btn-prev',
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
              spaceBetween: 50
            },
            // when window width is >= 640px
            1500: {
              spaceBetween: 100
            }
        }
    });

    //Template Contact
    let $formFilterItems = $('.form-selector li');
    let $formsHolder = $('.forms');
    let $forms = $('.form-container');

    $formFilterItems.on('click', function(){
       if( !$(this).hasClass('active') ) {
           $formsHolder.addClass('loading');

           $formFilterItems.removeClass('active');
           $(this).addClass('active');
           let target = $(this).data('form');

           setTimeout(function() {
               $forms.removeClass('active');
               $(target).addClass('active');
               $formsHolder.removeClass('loading');
           }, 300);
       }
    });
    //Template Contact END

    //Blog page
    const $checkSiteNameInput = $('#search-posts');
    let timer;
    const waitTime = 500;
    const $postsForm = $('#posts-form')
    const $postsResponse = $('#posts-response');
    const $postsPageInput = $('#posts-page-input')

    function filterPosts() {
        $postsResponse.addClass('loading');

        setTimeout(function () {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: $postsForm.serialize(),
                type: 'GET',
                beforeSend: function (xhr) {
                },
                success: function (data) {
                    document.getElementById('posts-response').innerHTML = data;
                },
                complete: function (data) {
                    $postsResponse.removeClass('loading');
                }
            });
        }, 300);
    }

    $checkSiteNameInput.keyup(function(){
        $postsPageInput.val(1);

        // Clear timer
        clearTimeout(timer);

        // Wait for X ms and then process the request
        timer = setTimeout(function() {
            filterPosts()
        }, waitTime);
    });

    $postsResponse.on('click','.pagination-page', function(){
        $postsPageInput.val($(this).data('page'));
        filterPosts();
    });
    //Blog page END

    //get started and contact page templates
    if( $('.page-template-get-started-container').length || $('.page-template-contact-container').length ) {
        $('.acf-basic-uploader').on('click','.clear-input', function(event){
            event.preventDefault();
            let $inputWrapper = $(this).parent();
            $inputWrapper.find('input').val('').change();
        });

        $("input[type=file]").on('change',function(){
            let file = $(this)[0].files[0];
            let $inputWrapper = $(this).parent();

            if( file ) {
                $inputWrapper.addClass('file-is-selected').append('<p class="file-name">' + file.name + '</p>');
                $inputWrapper.append('<p class="clear-input"> Clear </p>');
            } else {
                $inputWrapper.removeClass('file-is-selected').find('.clear-input').remove();
                $inputWrapper.find('.file-name').remove();
            }
        });
    }
    //get started and contact page templates END

    $(window).load(function(){});

    $(window).scroll(function(){});

    $(window).resize(function(){});
}(jQuery));