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
  $('.listingcard').click(function(){
    var img = $(this).css('background-image');
    var name = $(this).find('.itemname').html();
    var desc = $(this).find('.itemdescfull').html();
    var price = $(this).find('.itemprice').find('span').html();
    var seller = $(this).find('.seller').find('span').html();
    var pick = $(this).find('.pickuplocation').html();
    var lid = $(this).find('.lid').html();
    $('.listingdetcard').css('display','block');
    $('.listingdetdispoverlay').css('display','block');
    $('.listingdetcardimg').css('background-image',img);
    $('#listingdetcardname').val(name);
    $('#listingdetcarddesc').val(desc);
    $('#listingdetcardprice').val(price);
    $('#listingdetcardpickup').val(pick);
    $('#listingdetcardlid').val(lid);
    // $('.listingdetcardseller').find('span').html(seller);
  })
})
