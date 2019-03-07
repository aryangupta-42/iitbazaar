$(document).ready(function(){
  $('.headertitlecont').click(function(){
    window.location.href = "../home";
  })
  $('.navbtn').click(function(){
    loc = $(this).attr('id');
    window.location.href = "../"+loc;
  })
  $('.closebtn').click(function(){
    $('.listingdetcard').css('display','none');
    $('.listingdetdispoverlay').css('display','none');
    // $('.listingdetcarddet .error').css('display','none');
  })
  var lid;
  $('.listingcard').click(function(){
    var img = $(this).css('background-image');
    var name = $(this).find('.itemname').html();
    var desc = $(this).find('.itemdescfull').html();
    var price = $(this).find('.itemprice').find('span').html();
    var seller = $(this).find('.seller').find('span').html();
    var pick = $(this).find('.pickuplocation').html();
    lid = $(this).find('.lid').html();
    $('.listingdetcard').css('display','block');
    $('.listingdetdispoverlay').css('display','block');
    $('.listingdetcardimg').css('background-image',img);
    $('.listingdetcardname').html(name);
    $('.listingdetcarddesc').html(desc);
    $('.listingdetcardprice').find('span').html(price);
    $('.listingdetcardpickup').find('span').html(pick);
    $('.listingdetcardseller').find('span').html(seller);
  })
  $('#buynowbtn').click(function(){
    if(confirm("are you sure you want to purchase this item?")){
      var buyer = $('.userid').html();
      $.ajax({
        url:'../core/buy.php',
        type: 'POST',
        data:{
          lid:lid,
          buyer:buyer
        },
        success:function(d){
          if(d=="same"){
            // alert("You cant buy your own item");
            $('.listingdetcarddet .error').html("You Cannot purchase your own item.");
            $('.listingdetcarddet .error').css('display','block');
            setTimeout(function(){
              $('.listingdetcarddet .error').css('display','none');
            },5000);
          }else if(d == "done"){
            alert("item purchased successfully");
            location.reload();
          }else{
            // alert("error occ");
            $('.listingdetcarddet .error').html("Error occured. Please try again.");
            $('.listingdetcarddet .error').css('display','block');
            setTimeout(function(){
              $('.listingdetcarddet .error').css('display','none');
            },5000);

          }
        },
        error:function(d){
          console.log(d);
          alert("error occures");
        }
      })
    }else{
    }
  })
})
