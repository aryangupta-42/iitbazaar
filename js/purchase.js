$(document).ready(function(){
  $('.listingcard').click(function(){
    var sellername = $(this).find('.sellername').html();
    var sellercont = $(this).find('.sellercon').html();
    $('.listingdetcardsellername').find('span').html(sellername);
    $('.listingdetcardsellercontact').find('span').html(sellercont);

  })
})
