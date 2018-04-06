$(document).ready(function () {
 fnloaddata();
$(".btnmobile").click(function(){ 
$(".tableft,.careerleft").slideToggle("slow");		
});				 
if ($(window).width() < 767) { 
  $(".tableft").hide(); 
  $(".tableft ul li a").each(function () {    $(this).click(function () {   
  $(".tableft").slideToggle(0);  
  });  
  }); 
  } 
  else 
  {   $(".tableft").show();
  } 

/*  Contact Page address change */
  $('.contry ul li:first').addClass('active'); 
  $('.tab-content:not(:first)').hide(); 
  $('.contry ul li a').click(function(event) {    event.preventDefault();  
  var content = $(this).attr('href'); 
  $(this).parent().addClass('active');  
  $(this).parent().siblings().removeClass('active'); 
  $(content).show(); 
  $(content).siblings('.tab-content').hide(); 
  //SetMarker(this.value);
  }); 
/*  Contact Page address change */

 $('div[id^=tab]').hide();
 $('#tab1').show();

 //.usecase-framework-ul li.
 $('.tabs a').click(function (event) {
  event.preventDefault();
  $('.tabs').find('.active').removeClass('active');

  var tab_id = $(this).attr('href');
  $(this).addClass("active");

  $('div[id^=tab]').hide();
  $(tab_id).show();

 });

 /* Side Navigation*/
 $('#mySidbtn').click(function () {
  $(this).toggleClass('open');
   $("#mySidbtn").css("position", "fixed");
  if ($(this).hasClass('open')) {
   $("#mySidenav").css("width", "31.25rem");
  } else {
   $("#mySidenav").css("width", "0rem");;
  }
 });
 /* Side Navigation*/

 $(".requestademo").click(function(){
   $("#mySidenav").css("width", "0rem");
   $('#mySidbtn').removeClass('open');
    });

});

/* SCROLL LEFT RIGHT */

function fnloaddata() {
  // Show the first li
  $('#myList > li').first().show();
  $("#pagenoindicator").text("Viewing Page " + ($('#myList > li:visible').index() + 1) + " of " + $("#myList>li").size());

  $('.nextbtncard').click(function (e) {
    //$("#myList > li:visible").find('.inview').removeClass('captioncontent');
    if ($("#myList > li:visible").next().length != 0) {
      $("#myList > li:visible").next().fadeIn(1000).prev().hide();
      $("#myList > li:visible").find('.inview').addClass('captioncontent');
    } else {
      $("#myList > li:visible").hide();
      $("#myList > li:first").fadeIn(1000);
      $("#myList > li:visible").find('.inview').removeClass('captioncontent');
      //$("#myList > li:first").find('.inview').addClass('captioncontent');
    }
    $("#pagenoindicator").text("Viewing Page " + ($('#myList > li:visible').index() + 1) + " of " + $("#myList>li").size());
    return false;

  });
  $('.prevbtncard').click(function (e) {

    if ($("#myList > li:visible").prev().length != 0) {
      $("#myList > li:visible").prev().fadeIn(1000).next().hide();
    } else {
      $("#myList > li:visible").hide();
      $("#myList > li:last").fadeIn(1000);

    }
    $("#pagenoindicator").text("Viewing Page " + ($('#myList > li:visible').index() + 1) + " of " + $("#myList>li").size());
    return false;
  });
}

/* SCROLL LEFT RIGHT */

var a = 0;
$(window).scroll(function () {

 var oTop = $('#countsection').offset() - window.innerHeight;
 if (a == 0 && $(window).scrollTop() > oTop) {
  $('.count').each(function () {
   $(this).prop('Counter', 0).animate({
    Counter: $(this).text()
   }, {
    duration: 2500,
    easing: 'swing',
    step: function (now) {
     $(this).text(Math.ceil(now));
    }
   });
  });
  a = 1;
 }

});
 function fnhoveroverblock() {
$('.box').on('mouseover touchend', function (e) {

  $(this).css("cursor", "pointer");

  });
}







$('#btn').on('click', function () {
  $('#btn1').attr('disabled', 'disabled');
  var name = $.trim($("#name").val());
  var val_name = /([A-Za-z\s])+$/.test(name);
  var email = $.trim($("#email").val());
  var val_email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email);
  var phone = $.trim($("#phone").val());
  var val_phone = /^[0-9-+]+$/.test(phone);
  var company = $.trim($("#company").val());
  var val_company = /([A-Za-z\s])+$/.test(company);
  // var winwid = $(window).width();
  // //alert(winwid);
  // if(winwid > 768){
  // var captcha = validateForm();
  // }else{
  //   var captcha = true;
  // }
  var err = false;
  if (!val_name) {
    var msg = 'Enter valid name';
    if (name.length === 0) {
      msg = 'Enter name';
      $('#name_error').html(msg).show();
    }
    $('#name_error').html(msg).show();
    err = true;
  }
  if (!val_email) {
    var msg = 'Enter valid email address';
    if (email.length === 0) {
      msg = 'Enter email address';
    }
    $('#email_error').html(msg).show();
    err = true;
  }
  if (!val_phone) {
    var msg = 'Enter valid phone number';
    if (phone.length === 0) {
      msg = 'Enter phone number';
    }
    $('#phone_error').html(msg).show();
    err = true;
  }
  if (err === true) {
    $('#btn1').removeAttr('disabled');
    return false;
  } else {
	
    var postData = {
      'name': name,
      'email': email,
      'phone': phone,
      'company': company,
	  'path': window.location.href
    };

    $.ajax({
      type: "POST",
      url: "mail.php",
      data: postData,
      success: function (result)
      {
        $('#btn1').removeAttr('disabled');
        if (result == "1") {
          $('.getinresult').html("<p class='getinspan'>Thank you for contacting us. We will get back to you shortly.</p>");
          $('#name').val("");
          $('#email').val("");
          $('#phone').val("");
          $('#company').val("");
        } else {
          $('.getinresult').html("<p class='getinspan'>Sorry!! Something went wrong.</p>");
        }
      }
    });
  }
});

$('#btn1').on('click', function () {
  $('#btn1').attr('disabled', 'disabled');
  var name = $.trim($("#name1").val());
  var val_name = /([A-Za-z\s])+$/.test(name);
  var email = $.trim($("#email1").val());
  var val_email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email);
  var phone = $.trim($("#phone1").val());
  var val_phone = /^[0-9-+]+$/.test(phone);
  var company = $.trim($("#company1").val());
  var val_company = /([A-Za-z\s])+$/.test(company);
  // var winwid = $(window).width();
  // //alert(winwid);
  // if(winwid > 768){
  // var captcha = validateForm1();
  // }else{
  //   var captcha = true;
  // }
  var err = false;
  if (!val_name) {
    var msg = 'Enter valid name';
    if (name.length === 0) {
      msg = 'Enter name';
    }
    $('#name_error1').html(msg).show();
    err = true;
  }
  if (!val_email) {
    var msg = 'Enter valid email address';
    if (email.length === 0) {
      msg = 'Enter email address';
    }
    $('#email_error1').html(msg).show();
    err = true;
  }
  if (!val_phone) {
    var msg = 'Enter valid phone number';
    if (phone.length === 0) {
      msg = 'Enter phone number';
    }
    $('#phone_error1').html(msg).show();
    err = true;
  }
  if (err === true) {
    $('#btn1').removeAttr('disabled');
    return false;
  } else {
    var postData = {
      'name': name,
      'email': email,
      'phone': phone,
      'company': company,
	  'path' : window.location.href
    };

    $.ajax({
      type: "POST",
      url: "mail.php",
      data: postData,
      success: function (result)
      {
        $('#btn1').removeAttr('disabled');
        $('#contact_form2').hide();
        if (result == "1") {
          $('#reqdemoresult').html("<p class='reqdemospan'>Thank you for contacting us. We will get back to you shortly.</p>");
          $('#name1').val("");
          $('#email1').val("");
          $('#phone1').val("");
          $('#company1').val("");
        } else {
          $('#reqdemoresult').html("<p class='reqdemospan'>Sorry!! Something went wrong.</p>");
        }
      }
    });
  }
});

$('#name').on('blur', function () {
  val_name = /([A-Za-z\s])+$/.test(this.value);
  if (val_name == true) {
    $('#name_error').hide();
  }
});

$('#email').on('blur', function () {
  val_email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(this.value);
  if (val_email == true) {
    $('#email_error').hide();
  }
});
$('#phone').on('blur', function () {
  val_phone = /^[0-9-+]+$/.test(this.value);
  if (val_phone == true) {
    $('#phone_error').hide();
  }
});
// $('#company').on('blur', function() {
//   val_company = /([A-Za-z\s])+$/.test(this.value);
//   if(val_company == true){
//     $('#company_error').hide();
//   }
// });

$('#name1').on('blur', function () {
  val_name = /([A-Za-z\s])+$/.test(this.value);
  if (val_name == true) {
    $('#name_error1').hide();
  }
});

$('#email1').on('blur', function () {
  val_email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(this.value);
  if (val_email == true) {
    $('#email_error1').hide();
  }
});
$('#phone1').on('blur', function () {
  val_phone = /^[0-9-+]+$/.test(this.value);
  if (val_phone == true) {
    $('#phone_error1').hide();
  }
});
// $('#company1').on('blur', function() {
//   val_company = /([A-Za-z\s])+$/.test(this.value);
//   if(val_company == true){
//     $('#company_error1').hide();
//   }
// });



      var modal = document.getElementById('myModal');

      var btn3 = document.getElementById("myBtn3");
      var btn = document.getElementById("myBtn");
      var btn1 = document.getElementById("myBtn1");
      var btn2 = document.getElementById("myBtn2");
      var btn5 = document.getElementById("myBtn5");
      var span = document.getElementsByClassName("close")[0];
	  if(btn){
		  btn.onclick = function () {
			document.getElementById("reqdemoresult").innerHTML = "";
			modal.style.display = "block";
			document.getElementById("contact_form2").style.display = "block";
			//grecaptcha.reset();
		  }
	  }
	  if(btn1){
		  btn1.onclick = function () {
			document.getElementById("reqdemoresult").innerHTML = "";
			modal.style.display = "block";
			document.getElementById("contact_form2").style.display = "block";
			//grecaptcha.reset();
		  }
	  }
	  if(btn2){
		  btn2.onclick = function () {
			document.getElementById("reqdemoresult").innerHTML = "";
			modal.style.display = "block";
			document.getElementById("contact_form2").style.display = "block";
			//grecaptcha.reset();
		  }
	  }
	  
	  if(btn3){
		  btn3.onclick = function () {
			document.getElementById("reqdemoresult").innerHTML = "";
			modal.style.display = "block";
			document.getElementById("contact_form2").style.display = "block";
			//grecaptcha.reset();
		  }
	  }


