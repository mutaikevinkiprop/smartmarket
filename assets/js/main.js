(function ($) {
    "use strict";

    $(document).ready(function($){
        
        // testimonial sliders
        $(".testimonial-sliders").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:1,
                    nav:false
                },
                1000:{
                    items:1,
                    nav:false,
                    loop:true
                }
            }
        });

        // homepage slider
        $(".homepage-slider").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            nav: true,
            dots: false,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            responsive:{
                0:{
                    items:1,
                    nav:false,
                    loop:true
                },
                600:{
                    items:1,
                    nav:true,
                    loop:true
                },
                1000:{
                    items:1,
                    nav:true,
                    loop:true
                }
            }
        });

        // logo carousel
        $(".logo-carousel-inner").owlCarousel({
            items: 4,
            loop: true,
            autoplay: true,
            margin: 30,
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:4,
                    nav:false,
                    loop:true
                }
            }
        });

        // count down
        if($('.time-countdown').length){  
            $('.time-countdown').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                var $this = $(this).html(event.strftime('' + '<div class="counter-column"><div class="inner"><span class="count">%D</span>Days</div></div> ' + '<div class="counter-column"><div class="inner"><span class="count">%H</span>Hours</div></div>  ' + '<div class="counter-column"><div class="inner"><span class="count">%M</span>Mins</div></div>  ' + '<div class="counter-column"><div class="inner"><span class="count">%S</span>Secs</div></div>'));
            });
         });
        }

        // projects filters isotop
        $(".market-filters li").on('click', function () {
            
            $(".market-filters li").removeClass("active");
            $(this).addClass("active");

            var selector = $(this).attr('data-filter');

            $(".market-lists").isotope({
                filter: selector,
            });
            
        });
        
        // isotop inner
        $(".market-lists").isotope();

        // magnific popup
        $('.popup-youtube').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });

        // light box
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            }
        });

        // homepage slides animations
        $(".homepage-slider").on("translate.owl.carousel", function(){
            $(".hero-text-tablecell .subtitle").removeClass("animated fadeInUp").css({'opacity': '0'});
            $(".hero-text-tablecell h1").removeClass("animated fadeInUp").css({'opacity': '0', 'animation-delay' : '0.3s'});
            $(".hero-btns").removeClass("animated fadeInUp").css({'opacity': '0', 'animation-delay' : '0.5s'});
        });

        $(".homepage-slider").on("translated.owl.carousel", function(){
            $(".hero-text-tablecell .subtitle").addClass("animated fadeInUp").css({'opacity': '0'});
            $(".hero-text-tablecell h1").addClass("animated fadeInUp").css({'opacity': '0', 'animation-delay' : '0.3s'});
            $(".hero-btns").addClass("animated fadeInUp").css({'opacity': '0', 'animation-delay' : '0.5s'});
        });

       

        // stikcy js
        $("#sticker").sticky({
            topSpacing: 0
        });

        //mean menu
        $('.main-menu').meanmenu({
            meanMenuContainer: '.mobile-menu',
            meanScreenWidth: "992"
        });
        
         // search form
        $(".search-bar-icon").on("click", function(){
            $(".search-area").addClass("search-active");
        });

        $(".close-btn").on("click", function() {
            $(".search-area").removeClass("search-active");
        });
    
    });


    jQuery(window).on("load",function(){
        jQuery(".loader").fadeOut(1000);
    });


}(jQuery));
// Display the signup modal
document.getElementById("signup-btn").onclick = function() {
    document.getElementById("signup-modal").style.display = "block";
}

// Close the signup modal
document.getElementById("close-signup-modal").onclick = function() {
    document.getElementById("signup-modal").style.display = "none";
}

// Close the signup modal if the user clicks outside of it
window.onclick = function(event) {
    if (event.target == document.getElementById("signup-modal")) {
        document.getElementById("signup-modal").style.display = "none";
    }
}
// Display the login modal
document.getElementById("login-btn").onclick = function() {
    document.getElementById("login-modal").style.display = "block";
}

// Close the login modal
document.getElementById("close-login-modal").onclick = function() {
    document.getElementById("login-modal").style.display = "none";
}

// Close the login modal if the user clicks outside of it
window.onclick = function(event) {
    if (event.target == document.getElementById("login-modal")) {
        document.getElementById("login-modal").style.display = "none";
    }
}
// Display the profile modal
document.getElementById("profile-btn").onclick = function() {
    document.getElementById("profile-modal").style.display = "block";
}

// Close the profile modal
document.getElementById("close-profile-modal").onclick = function() {
    document.getElementById("profile-modal").style.display = "none";
}

// Close the profile modal if the user clicks outside of it
window.onclick = function(event) {
    if (event.target == document.getElementById("profile-modal")) {
        document.getElementById("profile-modal").style.display = "none";
    }
}
function logout() {
    document.getElementById('logoutForm').submit();
}
        // Function to validate repeat password
        function validatePassword() {
            var password = document.getElementById("signup-password").value;
            var repeatPassword = document.getElementById("signup-repeat-password").value;
            var errorElement = document.getElementById("password-error");

            if (password !== repeatPassword) {
                errorElement.innerHTML = "Passwords do not match";
                return false;
            } else {
                errorElement.innerHTML = "";
                return true;
            }
        }
            function openAvatarModal() {
                var avatarModal = document.getElementById('avatar-modal');
                avatarModal.style.display = 'block';
            }
        
// Close the profile modal
document.getElementById("close-avatar-modal").onclick = function() {
    document.getElementById("avatar-modal").style.display = "none";
} 
function openLoginModal() {
    document.getElementById('login-modal').style.display = 'block';
}