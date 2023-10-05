const swiper = new Swiper('.swiper-container', {
    autoplay: {
        delay: 5000
    },
    loop: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

function toggleClassSearch() {
    document.getElementById("form-search-header").classList.toggle("active");
    document.getElementsByClassName("overlay")[0].classList.toggle("active");
    document.getElementById("SiteNavSearch").focus();
}

function myFunction(x) {
    x.classList.toggle("change");
}


$(document).on('change', '#quantity', function() {
  var selectedIndex = $(this).find('option:selected').index();
  if( selectedIndex == 0 ){

    $('#current-price').html("199");
    $('#old-price').html("250");

  }else if( selectedIndex == 1 ){

    $('#current-price').html("397");
    $('#old-price').html("597");
    
  }else if( selectedIndex == 2 ){

    $('#current-price').html("596");
    $('#old-price').html("995");

  }
});


$('#contact_form').submit(function(e) {

  e.preventDefault();
  e.stopPropagation();

  var formData = $(this).serialize();

  $.ajax({
    type: 'POST',
    url: '/php/index.php',
    dataType: "json",
    data: formData,
    success: function(data) {
      if (data.success) {
        $('.form-status').addClass('alert alert-success');
        $('.form-status').text('Your Message Has been Sent Successfully');
        $('.form-status').slideDown().delay(3000).slideUp();        
        window.location.href = '/thank-you.html';
      } else {
        $('.form-status').addClass('alert alert-danger');
        $('.form-status').text('Error Occurred, Please Try Again');
        $('.form-status').slideDown().delay(3000).slideUp();
      }
    },
    error: function(xhr, status, error) {
      $('.form-status').addClass('alert alert-danger');
      $('.form-status').text('Something Went Wrong');
      $('.form-status').slideDown().delay(3000).slideUp();
    }
  });

  return false;
});
      