$(function(){
'use strict'
    // Dashboard
    $('.toggle-info').click(function(){
        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(500);
        if($(this).hasClass('selected')){
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }
        else{
            $(this).html('<i class="fa fa-plus fa-lg"></i>')
        }
    });
    

	// Add Asterisk (*)on Required Fields
    /*
	$("input").each(function(){
		if ($(this).attr('required') == ('required') ) {
			$(this).after('<span class="asterisk">*</span>')
		}	
	});
		// Convert password field to tesxt field on Hover
	var passField = $('.password');
	$('.show-pass').hover(function(){
		passField.attr('type','text');
	}, function(){
		passField.attr('type','password');
	});
	*/


	// Full View Option in Manage CATEGORIES Page
	
   $('.cat h3').click(function(){
       $(this).next('.full-view').fadeToggle(300);
   });
    
    $('.option span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active');
          if($(this).data('view')==='full'){
            $('.cat .full-view').fadeIn(200);
        }else{
            $('.cat .full-view').fadeOut(200);
        } 
    });
    ////////////////////Current Project/////////////////
    // Edit Photo List

    $('.p-list').hover(function(){
      $(this).children().next().fadeToggle(400);
    });



  // Confirmation Message  

  $('.confirm').click(function () {

    return confirm("Are You Sure?");

  });

  // Focut Image in Item Page
  $('.item_image').click(function(){
    var imgsrc=$(this).attr('src');
    $('.focus_image').attr('src',imgsrc);

  });

  // Function to make new focus image selected 

  $('.focus_image').click(function(){
    var imgsrc=$(this).attr('src');

    $('#full-screen-img').attr('src',imgsrc);
     $('.full-screen-form').fadeIn(800);
     $('.full-screen-form span').fadeIn(800);
  });

/*  Functions to hide the full screen image in !-item  */
$('#full-screen-img').click(function(){
  $('.full-screen-form').fadeOut(400);
});

$('.full-screen-hide').click(function(){
  $('.full-screen-form').fadeOut(400);
});

  /* Function to change to Previos Full screen img */
  $('.next-img').click(function(){
    var imgsrc = [];
    $('.item_image').each(function(){
      imgsrc.push($(this).attr('src'));
    });
    
    var current = $('#full-screen-img').attr('src');// finde current img index
    var index = imgsrc.indexOf(current); // get the index of the current img's class 
       
    var len = imgsrc.length;
    if (index !== 0){
      $('#full-screen-img').attr('src',imgsrc[index-1]);
      }else {
        $('#full-screen-img').attr('src',imgsrc[len-1]); // Go to last one
      }
  });  
 /* Function to change to Next Full screen img */

  $('.previus-img').click(function(){
    var imgsrc = [];
    $('.item_image').each(function(){
      imgsrc.push($(this).attr('src'));
    });
    
    var current = $('#full-screen-img').attr('src');// finde current img index
    var index = imgsrc.indexOf(current); // get the index of the current img's class 
       
    var len = imgsrc.length;
    if (index < len-1){
      $('#full-screen-img').attr('src',imgsrc[index+1]);
      }else {
        $('#full-screen-img').attr('src',imgsrc[0]); // Go to first one
      }
  });  

// Visiplay the Buttun //

  $("#milage").on('change keyup',function() {
    $("#contenue-btn").removeClass().addClass( "control-btn-a",1000);
  });

    //  insert Model hiden & viwe ///
    $("#contenue-btn").click(function(){
      $(this).fadeOut(1000);
      $('.control-box-toggle').fadeIn(1000);
      $('#save-am').fadeIn(2000);
    });


   // TOP & DOWN errow hide & view  && Content Slide / / 
  $('.control-box .control-title').click(function(){
    $(this).parent().find('.top').fadeToggle(500);
    $(this).parent().find('.down').fadeToggle(500);
    $(this).parent().parent().find('.packet').slideToggle(1000);
  });

  // set Next insert Control AVAILABLE
  $('#maker-list').on('change keyup',function() {
    $('#mod-list').removeAttr('disabled');
  });

  $('#mod-list').on('change keyup',function() {
    $('#fuel-list').removeAttr('disabled');/////
  });

  $('#fuel-list').on('change keyup',function() {
    $('#body-list').removeAttr('disabled');/////
  });

  $('#body-list').on('change keyup',function() {
    $('#gear-list').removeAttr('disabled');/////
  });


  $('#gear-list').on('change keyup',function() {
    $('#prod-year').removeAttr('disabled');
    $('#first-regist').removeAttr('disabled');
    $('#passengers').removeAttr('disabled');
    $('#milage').removeAttr('disabled');
  });
/*
  $('#fuel-list').on('change keyup',function() {
    $('#prod-year').removeAttr('disabled');
  });

  $('#prod-year').on('change keyup',function() {
    $('#first-regist').removeAttr('disabled');
  });

  $('#first-regist').on('change keyup',function() {
    $('#body-list').removeAttr('disabled');
  });

  $('#body-list').on('change keyup',function() {
    $('#gear-list').removeAttr('disabled');
  });

  $('#gear-list').on('change keyup',function() {//////
    $('#passengers').removeAttr('disabled');
  });

  $('#passengers').on('change keyup',function() {
    $('#milage').removeAttr('disabled');
  });
*/  
//   Check Out side Cars Colors Function ///// 
$(function() {
    $("input[type='checkbox']").change(function() {
      $(this).next('span').fadeToggle();
    });
});

// Cars Details errow in AM_items
$('.details-packet-title').click(function(){
  $(this).next('.details-packet').slideToggle(1000);
  $(this).children('.det-top').fadeToggle(500);
  $(this).children('.det-down').fadeToggle(500);
});

// Display item after remove from Favorite 
$('.remove-favorite').click(function(){
  $(this).closest('.each-item').fadeOut();
});

// Display item after remove from Compare 
$('.remove-compare').click(function(){
  $(this).closest('.each-c-item').fadeOut();
});

// Add Photos from photo ICON (Add photo to im manage)
$("#upfile1").click(function() {
    $("#file1").trigger('click');
});

// Function to disable nexct select model (Select model)
$('.add-model').click(function(){
  $(this).fadeOut(1000);
  $(this).parent().next('.select-model').slideToggle(1000);
});

// Function to copy distance Value from range to text input
$('#dis-range').change(function(){
    $('#dis-text').val($('#dis-range').val());

});



      
});
//////////////// AJAX Functions//////////////////

  //Function to Select model_AM as maker_AM (List)
  function getModel(val){
  $.ajax({
  type: "POST",
  url: 'am_items_dinamic.php?do=Model-List',
  data:"makid="+val,
  success: function(data){
    $("#mod-list").html(data);
  }
  });
}



  //Function to Select model_AM as maker_AM (List) X 2
  function getModel2(val){
  $.ajax({
  type: "POST",
  url: 'am_items_dinamic.php?do=Model-List',
  data:"makid="+val,
  success: function(data){
    $("#mod-list2").html(data);
  }
  });
}

  //Function to Select model_AM as maker_AM (List) X 3
  function getModel3(val){
  $.ajax({
  type: "POST",
  url: 'am_items_dinamic.php?do=Model-List',
  data:"makid="+val,
  success: function(data){
    $("#mod-list3").html(data);
  }
  });
}

  //Function to Select Make_AM as maker_AM (Text)
function getMakerText(val){
  $.ajax({
  type: "POST",
  url: 'am_items_dinamic.php?do=Maker-Text',
  data:"maker="+val,
  success: function(data){
    $("#maker-text").html(data);
  }
  });
}

  //Function to Select model_AM as maker_AM (Text)
function getModelText(val){
  $.ajax({
  type: "POST",
  url: 'am_items_dinamic.php?do=Model-Text',
  data:"model="+val,
  success: function(data){
    $("#model-text").html(data);
  }
  });
}

//Function to Select fuel_AM as fuel_AM (Text)
function getFuelText(val){
  $.ajax({
  type: "POST",
  url: 'am_items_dinamic.php?do=Fuel-Text',
  data:"fuel="+val,
  success: function(data){
    $("#fuel-text").html(data);
  }
  });
}

  //Function to Select Main SP Items (List)
  function getSPitems(val){
  $.ajax({
  type: "POST",
  url: 'dinamic_data.php?do=main-SP',
  data:"groupid="+val,
  success: function(data){
    $("#main-sp").html(data);
  }
  });
}


//Function to Add Favorite 
function addFavorite(val){
  $.ajax({
  type: "POST",
  url: 'dinamic_data.php?do=add-favourite',
  data:"itemid="+val,
  success: function(data){
    $("#favourite").html(data);
  }
  });
}

//Function to Remove Favorite 
function removeFavorite(val){
  $.ajax({
  type: "POST",
  url: 'dinamic_data.php?do=remove-favourite',
  data:"itemid="+val,
  success: function(data){
    $("#favourite").html(data);
  }
  });
}

//Function to Add Favorite 
function addCompare(val){
  $.ajax({
  type: "POST",
  url: 'dinamic_data.php?do=add-compare',
  data:"itemid="+val,
  success: function(data){
    $("#compare").html(data);
  }
  });
}

//Function to Remove Favorite 
function removeCompare(val){
  $.ajax({
  type: "POST",
  url: 'dinamic_data.php?do=remove-compare',
  data:"itemid="+val,
  success: function(data){
    $("#compare").html(data);
  }
  });
}




//Function to Get lomatrix *************TTTTTEEEESSSSTTTTT
function locMatrix(val){
  $.ajax({
  type: "POST",
  url: 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=düsseldorf,40210&destinations=düsseldorf,40472&key=AIzaSyBE1AygHnfN5li-B32BjjcD5-hua4dN9j4',
  data:"itemid="+val,
  success: function(data){
    $("#test").html(data);
  }
  });
}


// Function To Get Location Service from Google API (distanceMatrix)
function getAjax(page) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("test").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET",page,true);
  xhttp.send();
}

// Top Scrool function
function scrollT() {
  document.getElementById("photo-list").scrollBy(0, -150);
}

// Down Scrool function
function scrollD() {
  document.getElementById("photo-list").scrollBy(0, 150);
}

// Left Scrool function
function scrollL() {
  document.getElementById("photo-list").scrollBy(-200, 0);
}

// Right Scrool function
function scrollR() {
  document.getElementById("photo-list").scrollBy(200, 0);
}

// Left Scrool function
function scrollPL() {
  document.getElementById("pro-list").scrollBy(-200, 0);
}
// Left Scrool function
function scrollPR() {
  document.getElementById("pro-list").scrollBy(200, 0);
}


// Right Scrool RE Items
function scrollReR() {
  document.getElementById("re-list").scrollBy(200, 0);
}

// Left Scrool RE Items
function scrollReL() {
  document.getElementById("re-list").scrollBy(-200, 0);
}


// Left Scrool function WS Items
function scrollWL() {
  document.getElementById("ws-list").scrollBy(-200, 0);
}

// Left Scrool function WS Items
function scrollWR() {
  document.getElementById("ws-list").scrollBy(200, 0);
}