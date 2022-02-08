(function ($) { //document ready
    gsap.registerPlugin(ScrollTrigger);
    //Template Home

    var interval;
    var accordionTimer = function(){
        interval = setInterval(function(){
            var activeSlider = $('.single-accordion.active');
            var nextAccordion = activeSlider.data('next');
            $('#' + nextAccordion).trigger('click');
        }, 5000)
    };

    accordionTimer();

    let $singleAccordion = $('.single-accordion');
    $singleAccordion.on('click', function(e){
        clearInterval(interval);
        accordionTimer();
        $('.accordion-description').slideUp();
        $('.single-accordion').removeClass('active disabled');
        $(this).addClass('active');
        $(this).addClass('disabled');
        $(this).find('.accordion-description').slideDown();
    });
    //Template Home END

    //Template About
    jQuery('.history-slider').slick({
        arrows: false,
        slidesToShow: 1,
        // infinite: true,
        centerMode: true,
        rtl: true,
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

    $(window).load(function(){});

    $(window).scroll(function(){});

    $(window).resize(function(){});
}(jQuery));