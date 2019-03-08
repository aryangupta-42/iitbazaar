$(document).ready(function(){
  var dt = 0;
  $('.dropdown').click(function(){
    if(dt == 0){
      $('.dropdown-opt').css({
        'display':'block'
      })
      setTimeout(function(){
        $('.dropdown-opt').css('transform','scaleY(1)');
      },10)
      dt = 1;
    }else{
      $('.dropdown-opt').css('transform','scaleY(0)');
      setTimeout(function(){
        $('.dropdown-opt').css({
          'display':'none'
        })
      },110)
      dt = 0;
    }
  })
  $('.di').click(function(){
    var dopt = $(this).html();
    $('.dtitle').val(dopt);
    $('.dtitle').css('color','black');
    $('.dropdown-opt').css('transform','scaleY(0)');
    setTimeout(function(){
      $('.dropdown-opt').css({
        'display':'none'
      })
    },110)
    dt = 0;
  })

  $('.btn').click(function(){
    window.location.href = "../settings";
  })
})

function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#itemimagepre')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
            };

            reader.readAsDataURL(input.files[0]);
        }
  }
