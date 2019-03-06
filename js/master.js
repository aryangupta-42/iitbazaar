$(document).ready(function(){
  $('.headertitlecont').click(function(){
    window.location.href = "../home";
  })
  $('.navbtn').click(function(){
    var loc = $(this).attr('id');
    window.location.href = "../"+loc;
  })
})
