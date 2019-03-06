$(document).ready(function(){
  // $('#itemimage').on('change',function(){
  //   var reader = new FileReader();
  //   reader.onload = function(e) {
  //       $('#itemimagepre')
  //           .attr('src', e.target.result)
  //           .width(250)
  //           .height(250);
  //   };
  //   reader.readAsDataURL($('#itemimage').files[0]);
  //
  // })
})

//taken from stackoverflow
function readURL(input) {
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
