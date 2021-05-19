
// Close the message dialog
$(document).ready(function(){
  $('#Ok_Button').on('click', function(){
    $('#Message_Container_id').hide();
    console.log('#someButton was clicked');
  });
});


$(document).ready(function() {
  $('#autoWidth').lightSlider({
      autoWidth:true,
      loop:true,
      onSliderLoad: function() {
          $('#autoWidth').removeClass('cs-hidden');
      }
  });
});
