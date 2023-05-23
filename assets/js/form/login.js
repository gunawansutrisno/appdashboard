$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    
     $(window).on('load', function() { // makes sure the whole site is loaded 
        $('#status').fadeOut(); // will first fade out the loading animation 
        $('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website. 
        $('body').delay(600).css({'overflow':'visible'});
      })
});