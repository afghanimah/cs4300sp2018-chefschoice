$(document).ready(function(){

  var down = false;
  $("#adv-panel").click(function(){
    $("#slide").slideToggle("slow");
    down = !down;

    if(down){
      $("#adv-panel").css("color", "#B81A2E");
    } else {
      $("#adv-panel").css("color", "black");
    };
  });


  $('.md-select').on('click', function(){
  $(this).toggleClass('active')
})

$('.md-select ul li').on('click', function() {
  var v = $(this).text();
  $('.md-select ul li').not($(this)).removeClass('active');
  $(this).addClass('active');
  $('.md-select label button').text(v)
})


});
