@extends('layouts.Masters.Master')
@section('title', 'HealthGennie Labs')
@section('content')
<link href="{{ URL::asset('css/jquery.notify.css') }}" rel="stylesheet" type="text/css"/>
<?php
  if(Auth::user() != null){
    $LabCart = getLabCart();

  }
  else{
    $LabCart = Session::get("CartPackages");
  }

?>
<div class="lab-test lab-test-profile">
  <div class="container-fluid">
  	<div class="container">
      <div class="checkup-package labProfiles">
      	<h2>Lab Packages</h2>
      @if(count($items) > 0)
      <div class="LabDetailsDivLosh">
        @foreach($items as $item)
        <div class="checkup-detail LabProfiles">
            <a href="{{route('LabDetails', ['id'=> base64_encode($item->common_name), 'type' => base64_encode($item->type)]) }}">
          <img src="{{ URL::asset('img/thayrocare-logo-dashboard.jpg') }}" alt="banner"/>
          <h3>{{$item->common_name}}</h3></a>
            <!-- <p>Ideal for individuals aged 41-60 years</p> -->
            <div class="blog-wrapper-content">
            <div class="test-included">
              <a href="{{route('LabDetails', ['id'=> base64_encode($item->common_name), 'type' => base64_encode($item->type)]) }}" type="{{$item->type}}">({{$item->testCount}}) Tests Included</a>
            </div>
            <div class="price-offer">
             ₹ {{$item['rate']['payAmt']}}
            @if($item['rate']['b2C'] > $item['rate']['payAmt'])
                <div class="discount-price">
                  ₹ {{$item['rate']['b2C']}}
                </div>
                <div class="discount">
                  <?php
                      $main = $item['rate']['b2C'];
                      $payAmt = $item['rate']['payAmt'];
                      $diff = $main-$payAmt;
                      $percent = ($diff*100)/$item['rate']['b2C']
                  ?>
                  {{(floor($percent))}}%  off
                </div>
              @endif
                <!-- <p>+ 10% Health cashback <span class="mandatory">*</span></p> -->
            </div>
            <div class="book-now"> <input type="hidden" class="selectPackage" name="" value="{{json_encode($item)}}"><a href="javascript:void(0)" url="{{route('LabDetails', ['id'=> base64_encode($item->name), 'type' => base64_encode($item->type)]) }}" class="add_to_cart @if(!empty($LabCart) && array_search($item->name, array_column($LabCart, 'name')) !== false) removeCart @endif" data-name="{{$item->name}}" Pcode="{{$item->code}}" Pname="{{$item->name}}"  data-type="@if(!empty($LabCart) && array_search($item->name, array_column($LabCart, 'name')) !== false) 2 @else 1 @endif">@if(!empty($LabCart) && array_search($item->name, array_column($LabCart, 'name')) !== false) Remove @else Book Now @endif</a></div>
            </div>
        </div>
        @endforeach
        </div>
        @else
        <div class="blankDiv notFoundGroupPKG">
          <h2>Packages Not Available</h2>
        </div>
        @endif
      </div>
<?php /*
    <h2>Top Booked Packages</h2>
    <?php $offer = 0; ?>
    @foreach(getThyrocareData("PROFILE") as $offers)
    @if($offer<5)
    <div class="package-box">
      <h3>{{$offers->name}}</h3>
        <span class="total_count">Tests Included</span> <b>({{$offers->testCount}})</b>
        <div class="price">₹ {{$offers->rate->payAmt}}</div>
        <a href="#">View {{$offers->type}}</a>
    </div>
    @endif
    <?php $offer++; ?>
    @endforeach */ ?>
  </div>
  </div>
</div>
<script src='{{ URL::asset("js/jquery.notify.min.js") }}'></script>
<script>
function successMessage() {
  notify({
      type: "success", //alert | success | error | warning | info
      // title: "Cart Added",
      // message: "Product Added Successfully.",
        message: "Test package added successfully.",
      position: {
          x: "right", //right | left | center
          y: "top" //top | bottom | center
      },
        icon: '<img src="{{ URL::asset("img/paper_plane.png") }}" />',
      size: "normal", //normal | full | small
      overlay: false, //true | false
      closeBtn: true, //true | false
      overflowHide: false, //true | false
      spacing: 20, //number px
      theme: "default", //default | dark-theme
      autoHide: true, //true | false
      delay: 800, //number ms
      onShow: null, //function
      onClick: null, //function
      onHide: null, //function
      template: '<div class="notify"><div class="notify-text"></div></div>'
  });
}
function CartAnimate(current) {
	$("html, body").animate({
		   scrollTop: 0
	  }, 600);
  shake($(current).closest('.checkup-detail'));

  var cart = $('.cart-wrapper');
  var imgtodrag = $(current).closest('.checkup-detail').find("img").eq(0);
  if (imgtodrag) {
      var imgclone = imgtodrag.clone()
          .offset({
          top: imgtodrag.offset().top,
          left: imgtodrag.offset().left
      })
          .css({
          'opacity': '1',
              'position': 'absolute',
              'height': '150px',
              'width': '150px',
              'z-index': '100'
      })
          .appendTo($('body'))
          .animate({
          'top': cart.offset().top + 10,
              'left': cart.offset().left + 10,
              'width': 75,
              'height': 75
      }, 2000, 'easeInOutExpo');

      setTimeout(function () {
          cart.effect("shake", {
              times: 2
          }, 200);
      }, 1500);

      imgclone.animate({
          'width': 0,
              'height': 0
      }, function () {
          $(current).detach()
      });
  }
}


// adaptable SHAKE function, from
// https://bradleyhamilton.com/projects/shake/index.html
function shake(thing) {
  var interval = 100;
  var distance = 10;
  var times = 6;

  for (var i = 0; i < (times + 1); i++) {
    $(thing).animate({
      left:
        (i % 2 == 0 ? distance : distance * -1)
    }, interval);
  }
  $(thing).animate({
    left: 0,
    top: 0
  }, interval);
}
function LabCart(product_array, action_type) {
  jQuery.ajax({
  type: "POST",
  url: "{!! route('CartUpdate') !!}",
  data: {'product_array':product_array,'action_type':action_type},
  success: function(data){
      if(data==1)
      {
        // alert("Package Added into Cart Successfully ");
      }
      else if(data==2)
      {
        // alert("Package Remove Successfully");
      }
      else
      {
        alert("Problem into Cart");
      }
    }
  });
}
$(".cart-wrapper").hover(function(){
  if ($(".cart-wrapper").hasClass("cart-open") == true) {
      $(".cart-wrapper").removeClass('cart-open');
  }
});
jQuery(document).on("click", ".add_to_cart", function () {
  // var product_id = jQuery(this).prev("input").val();
  // var btn = this;
  var cartTotal = jQuery('#cartTotal').text();
  var type = jQuery(this).attr("data-type");
  var selectPackage = jQuery(this).parent().find('.selectPackage').val();
  var pkg = JSON.parse(selectPackage);
var url = $(this).attr('url');
  if (type == 1) {
    CartAnimate(this);
    LabCart(selectPackage, 'add_item');
    if ($(".cart-wrapper").hasClass("cart-open") == false) {
        $(".cart-wrapper").addClass('cart-open');
    }

    $(this).replaceWith('<a href="javascript:void(0)" class="add_to_cart removeCart" data-name="'+pkg.name+'" Pcode="'+pkg.code+'" Pname="'+pkg.name+'" data-type="2"> Remove</a>');
    var cartTotal = jQuery('#cartTotal').text();
      successMessage();

    if (parseFloat(cartTotal) == 0) {
      jQuery('#cartTotal').text(1);
      jQuery('.totalTest').text(1);
    }
    else{
      jQuery('#cartTotal').text(parseFloat(cartTotal)+1);
      jQuery('.totalTest').text(parseFloat(cartTotal)+1);
    }
    if (pkg.rate.offerRate != 'null') {
      var price = pkg.rate.offerRate;
    }
    else {
      var price = pkg.rate.b2C;
    }
    var Div = '<div class="list" title="'+pkg.name+'" data-name="'+pkg.name+'"><img src="{{asset("img/OurStore-icon.png")}}"><h5><a href="'+url+'">'+pkg.name+'</a></h5> <span><strong>1 x ₹'+price+'</strong></span><a class="close deleteFromMiniCart" href="javascript:void(0);"  Pcode="'+pkg.code+'" Pname="'+pkg.name+'"><i class="fa fa-times-circle" aria-hidden="true"></i></a> </div>';
    $("#miniCartList").append(Div);
    setTimeout(function(){ $("#miniCart").css("display", "");   $(".cart-wrapper").attr('title','Cart');  }, 1000);
  }
  else if (type == 2) {
    var selectPackage = [];
    var pname = $(this).attr('Pname');
    var pcode = $(this).attr('Pcode');
    selectPackage.push({pname:pname,pcode:pcode});

    LabCart(selectPackage, 'remove_item');
    $(this).replaceWith('<a href="javascript:void(0)" class="add_to_cart" data-name="'+pkg.name+'" Pcode="'+pkg.code+'" Pname="'+pkg.name+'" data-type="1"> Book Now</a>');
    jQuery('#cartTotal').text(parseFloat(cartTotal)-1);
    jQuery('.totalTest').text(parseFloat(cartTotal)-1);

    var data_name = $(this).attr("data-name");
    $("#miniCartList .list").each(function(){
      if ($(this).attr("data-name") == data_name) {
        $(this).remove();
      }
    });
    if ($("#miniCartList .list").length == '0') {
      $("#miniCart").css("display", "none");
      $(".cart-wrapper").removeClass('cart-open');
      $(".cart-wrapper").attr('title','Cart is Empty!');

    }

  }
});
  jQuery(document).on("click", ".deleteFromMiniCart", function () {
      $(this).parent().slideUp("slow");
      var selectPackage = $(this).parent().find('.selectPackage').val();
      LabCart(selectPackage, 'remove_item');
      // setTimeout(function(){ $(this).parent().remove(); }, 3000);
  });

</script>
@endsection
