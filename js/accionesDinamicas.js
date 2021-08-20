$( document ).ready(function() {
    
    $('.leftmenutrigger').on('click', function(e) {
        $('.side-nav').toggleClass("open");
        $('.goma').animate({
            left: '+=600'
        }, 458, 'swing', function () {

        });
        //$(".side-nav").width(75);
        e.preventDefault();
    });


    
    
    
});

$(function () {
    $('[data-toggle="popover"]').popover()
})

