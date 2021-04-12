jQuery(function($){
  "use strict"; // Start of use strict
  /*$(window).on('load',function() {
    $(".se-pre-con").fadeOut("slow")
  });

  $(document).ready(function() {
    $(".se-pre-con").fadeOut("slow")
  });*/
  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });
  function resize(){
    if ($(window).width() < 768) {
      $("#page-top").attr("class","");
      $("#wrapper").find("nav").addClass("toggled");
      $(".sidebar").show()
      $(".customMenu").each(function(){
        $(this).hide()
      })
    }else{
      $("#page-top").attr("class","sidebar-toggled");
      $("#wrapper").find("nav").removeClass("toggled");
      $("#sidebarToggle").hide()
      $(".sidebar").hide()
      $(".customMenu").each(function(){
        $(this).show()
      })
    }
  }resize()
  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    resize()
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

}); // End of use strict
