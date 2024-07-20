jQuery(function($) {
  // $('input.timepicker').timepicker({});
  $('body').on('keyup input paste', '.phone_number, .mask_us_phone', function() {
      $(this).mask('+1 (999) 999-9999')
  })

  $('body').on('keyup input paste', '.month', function() {
      let val = $(this).val();
      if ( val == '' ){
          return;
      }

      if (/^(0?[1-9]$)|(^1[0-2])$/i.test(val)){
          $(this).mask('00')
      }else{
          $(this).val(12);
      }
  })

  $('body').on('keyup input paste', '.year', function() {
      let val = $(this).val();
      if ( val =='' ){
          return;
      }
      
      $(this).mask('0000')
  })

  $('body').on('keyup input paste', '.card_number, .mask_us_credit_card', function() {
      let val = $(this).val();
      val = val.replace(/-/g, "");
      if (/^3$|^3[47][0-9]{0,13}$/i.test(val)) {
          $(this).mask('0000-000000-00000')
      } else {
          $(this).mask('0000-0000-0000-0000')
      }
  })

  $('.phone_number, .mask_us_phone').trigger('input');
  $('.card_number, .mask_us_credit_card').trigger('input');

  
});

$(document).ready(function () {
  $("#header-search").on("click", function () {
    $("#search-show").removeClass("d-none");
  });
  $("#hide-search").on("click", function () {
    $("#search-show").addClass("d-none");
  });
  $(".get-form .form-control").click(function () {
    $(".get-form").removeClass("field-focus"),
      $(this).parent().addClass("field-focus");
  }),
  $(".blocks-slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    focusOnSelect: !1,
    arrows: !0,
    dots: !1,
    infinite: false,
    responsive: [
      {
        breakpoint: 1150,
        settings: {
          arrows: !0,
          dots: !1,
          slidesToScroll: 1,
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 992,
        settings: {
          arrows: !0,
          dots: !1,
          slidesToScroll: 1,
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 768,
        settings: {
          arrows: !0,
          dots: !1,
          slidesToScroll: 1,
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 576,
        settings: {
          arrows: !0,
          dots: !1,
          slidesToScroll: 1,
          slidesToShow: 1,
        },
      },
    ],
  }),

  $(".near-you-slider").slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    focusOnSelect: !1,
    arrows: !0,
    dots: !1,
    infinite: false,
    responsive: [
      {
        breakpoint: 1280,
        settings: {
          arrows: !0,
          dots: !1,
          slidesToScroll: 1,
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 1130,
        settings: {
          arrows: !0,
          dots: !1,
          slidesToScroll: 1,
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 850,
        settings: {
          slidesToScroll: 1,
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 650,
        settings: {
          slidesToScroll: 1,
          slidesToShow: 1,
        },
      },
    ],
  }),
  $(".loyal-suppliers-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    focusOnSelect: !1,
    arrows: !0,
    dots: !1,
  }),
  $(".shop-aisle-main").slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 15e3,
        settings: "unslick",
      },
      {
        breakpoint: 1200,
        settings: {
          slidesToScroll: 1,
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 992,
        settings: {
          arrows: !0,
          dots: !1,
          slidesToScroll: 1,
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToScroll: 1,
          slidesToShow: 2,
          arrows: !0,
        },
      },
      {
        breakpoint: 500,
        settings: {
          slidesToScroll: 1,
          slidesToShow: 1,
          arrows: !0,
          autoplay: !0,
        },
      },
    ],
  });
});

$('.product-detail-img-upper-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.product-detail-img-lower-slider'
});
$('.product-detail-img-lower-slider').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  asNavFor: '.product-detail-img-upper-slider',
  dots: false,
  focusOnSelect: true
});

$('a[data-slide]').click(function(e) {
  e.preventDefault();
  var slideno = $(this).data('slide');
  $('.slider-nav').slick('slickGoTo', slideno - 1);
});

// for vendor product management add/edit quantity box

(function () {
  "use strict";
  var jQueryPlugin = (window.jQueryPlugin = function (ident, func) {
    return function (arg) {
      if (this.length > 1) {
        this.each(function () {
          var $this = $(this);

          if (!$this.data(ident)) {
            $this.data(ident, func($this, arg));
          }
        });

        return this;
      } else if (this.length === 1) {
        if (!this.data(ident)) {
          this.data(ident, func(this, arg));
        }

        return this.data(ident);
      }
    };
  });
})();

(function () {
  "use strict";
  function Guantity($root) {
    const element = $root;
    const quantity = $root.first("data-quantity");
    const quantity_target = $root.find("[data-quantity-target]");
    const quantity_minus = $root.find("[data-quantity-minus]");
    const quantity_plus = $root.find("[data-quantity-plus]");
    var quantity_ = quantity_target.val();
    $(quantity_minus).click(function () {
      quantity_target.val(--quantity_);
    });
    $(quantity_plus).click(function () {
      quantity_target.val(++quantity_);
    });
  }
  $.fn.Guantity = jQueryPlugin("Guantity", Guantity);
  $("[data-quantity]").Guantity();
})();


/* Active State of vendor-menu */
// $('.vender-menu a').removeClass("active");
// if(typeof tabName !== 'undefined' && tabName.length){
//     $('.vender-menu a'+'.'+tabName).addClass("active");
// }
/* Active State of vendor-menu */

// show hide password
$(".toggle-password").click(function () {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("d-toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
 
$('#hide-search-2').on('click', function(){
  $(this).addClass('d-none');
    $("#aisle-show").addClass('d-none');
    $('#aisle-dd').removeClass('shown');
})