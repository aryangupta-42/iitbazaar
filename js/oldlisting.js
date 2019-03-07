$(document).ready(function(){
  $('.listingcard').click(function(){
    var buyerusername = $(this).find('.buyerusername').html();
    var buyername = $(this).find('.buyername').html();
    var buyercont = $(this).find('.buyercon').html();
    $('.listingdetcardbuyer').find('span').html(buyerusername);
    $('.listingdetcardbuyername').find('span').html(buyername);
    $('.listingdetcardbuyercontact').find('span').html(buyercont);
  })
})
