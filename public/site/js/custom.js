// Aos
AOS.init();

setTimeout(() => {
    $(".loading").fadeOut(1000);
}, 4000);

window.onload = function () {
    setTimeout(() => {
        $(".header-pages").addClass("active");
    }, 300);
};

lightGallery(document.getElementById("lightgallery"), {
    thumbnail: true,
    selector: ".image-item",
});

$(".click-dropdown-mune").click(function (e1) {
    e1.preventDefault();
    $(".dropdowm-language-mune").slideToggle();
});

$(".language > a").click(function (e1) {
    e1.preventDefault();
    $(".dropdowm-language").slideToggle();
});

$(".click-element").click(function (e) {
    e.preventDefault();
    $(this).next().slideToggle();
    $(".click-element1").next().slideUp();
});

$(".click-element1").click(function (e) {
    e.preventDefault();
    $(this).next().slideToggle();
    $(".click-element").next().slideUp();
});

$(".click-element-mune").click(function (e) {
    e.preventDefault();
    $(this).next().slideToggle();
    $(".click-element1").next().slideUp();
});

$(".click-element1-mune").click(function (e) {
    e.preventDefault();
    $(this).next().slideToggle();
    $(".click-element").next().slideUp();
});
//silder-index
if ($("#slider-1").length) {
    $("#slider-1").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        rtl: true,
        autoplay: true,
        dots: true,
        dotsData: true,
        smartSpeed: 2000,
        responsiveClass: true,
        responsive: {
            1400: {
                item: 1,
            },
        },
    });
}
//silder-index
if ($("#slider-administration").length) {
    $("#slider-administration").owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        items: 1,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        rtl: true,
        autoplay: true,
        dots: true,
        smartSpeed: 2000,
        responsiveClass: true,
        responsive: {
            1400: {
                item: 1,
            },
        },
    });
}

//silder-departments
if ($("#slider-news").length) {
    $("#slider-news").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        items: 3,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        rtl: true,
        autoplay: true,
        dots: false,
        smartSpeed: 2000,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
    });
}
//silder-values
if ($("#slider-values").length) {
    $("#slider-values").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        items: 3,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        rtl: true,
        autoplay: true,
        dots: false,
        smartSpeed: 2000,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
    });
}

//silder-departments
if ($("#slider-clinet").length) {
    $("#slider-clinet").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        items: 6,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        rtl: true,
        autoplay: true,
        dots: false,
        smartSpeed: 2500,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 4,
            },
            1000: {
                items: 6,
            },
        },
    });
}

$(".remove_mune").click(function () {
    $("#menu-div").removeClass("active");
    $(".bg_menu").removeClass("active");
});

function open() {
    $(".navicon").addClass("is-active");
    $("#menu-div").addClass("active");
    $("#times-ican").addClass("active");
    $(".bg_menu").addClass("active");
}

function close() {
    $(".navicon").removeClass("is-active");
    $("#menu-div").removeClass("active");
    $("#times-ican").removeClass("active");
    $(".bg_menu").removeClass("active");
    $(".dropdowm-language").slideUp();
    $(".dropdowm-language-mune").slideUp();
    $(".dropdowm-element").slideUp();
    $(".dropdowm-element-mune").slideUp();

    $(".remove-mune").click(function () {
        $("#menu-div").removeClass("active");
        $(".bg_menu").removeClass("active");
        $(".times-ican").removeClass("active");
    });
}

$("#times-ican").click(function () {
    if ($(this).hasClass("active")) {
        close();
    } else {
        open();
    }
});

$(".remove-mune").click(function () {
    $("#menu-div").removeClass("active");
    $(".bg_menu").removeClass("active");
    $(".times-ican").removeClass("active");
    $(".navicon").removeClass("is-active");
});

$("#menu-div a").click(function () {
    e.preventDefault();
});

var $winl = $(window); // or $box parent container
var $boxl = $(
    "#menu-div, #times-ican , .click-dropdown , .dropdowm-language ,.click-element , .language > a ,.dropdowm-element , .click-element1  , .click-element1-mune , .click-element-mune , .dropdowm-element-mune"
);
$winl.on("click.Bst", function (event) {
    if (
        $boxl.has(event.target).length === 0 && //checks if descendants of $box was clicked
        !$boxl.is(event.target) //checks if the $box itself was clicked
    ) {
        close();
    }
});

// upload file ==============

$("#upload-1").change(function (e) {
    $(".upload-form p").text(e.target.files[0].name);
});


$(".click-dropdown").click(function (e) {
    e.preventDefault();
    $(".dropdowm-language").slideToggle();
});

// counter

if ($(".counter").length) {
    var a = 0;
    $(window).scroll(function () {
        var oTop = $(".counter-box").offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
            $(".counter").each(function () {
                var $this = $(this),
                    countTo = $this.attr("data-number");
                $({
                    countNum: $this.text(),
                }).animate(
                    {
                        countNum: countTo,
                    },

                    {
                        duration: 2550,
                        easing: "swing",
                        step: function () {
                            //$this.text(Math.ceil(this.countNum));
                            $this.text(Math.ceil(this.countNum).toLocaleString("en"));
                        },
                        complete: function () {
                            $this.text(Math.ceil(this.countNum).toLocaleString("en"));
                            //alert('finished');
                        },
                    }
                );
            });
            a = 1;
        }
    });

    const animationDuration = 4000;

    const frameDuration = 1000 / 60;

    const totalFrames = Math.round(animationDuration / frameDuration);

    const easeOutQuad = (t) => t * (2 - t);

    const animateCountUp = (el) => {
        let frame = 0;
        const countTo = parseInt(el.innerHTML, 10);

        const counter = setInterval(() => {
            frame++;

            const progress = easeOutQuad(frame / totalFrames);

            const currentCount = Math.round(countTo * progress);

            if (parseInt(el.innerHTML, 10) !== currentCount) {
                el.innerHTML = currentCount;
            }

            if (frame === totalFrames) {
                clearInterval(counter);
            }
        }, frameDuration);
    };

    const countupEls = document.querySelectorAll(".timer");
    countupEls.forEach(animateCountUp);

    $(".animated-progress span").each(function () {
        $(this).animate(
            {
                width: $(this).attr("data-progress") + "%",
            },
            2100
        );
        $(this).text($(this).attr("data-progress") + "%");
    });
}
// ----------------------



document.querySelector(".click-media-icons").addEventListener("click", function (e) {
    e.preventDefault();
    let ulMedia = e.target.parentElement.nextElementSibling;
    e.target.parentElement.classList.toggle("active");
    ulMedia.classList.toggle("active");
})





var darkMode = false;

// default to system setting
if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    darkMode = true;
}

// preference from localStorage should overwrite
if (localStorage.getItem('theme') === 'dark') {
    darkMode = true;
} else if (localStorage.getItem('theme') === 'light') {
    darkMode = false;
}

if (darkMode) {
    document.body.classList.toggle('dark');
}

document.addEventListener('DOMContentLoaded', () => {

    document.getElementById('theme-toggle').addEventListener('click', () => {
        document.body.classList.toggle('dark');

        localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
    });

});


if ($("#slider-news-details").length) {
    $("#slider-news-details").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        rtl: true,
        autoplay: true,
        dots: true,
        smartSpeed: 2000,
        responsiveClass: true,
        responsive: {
            1400: {
                item: 1,
            },
        },
    });
}
