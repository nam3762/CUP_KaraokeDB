$(document).ready(function(){
    $('.year_label').click(function(e){
        $(this).children().toggle();
        $(this).siblings().children().hide();
    });

    $('.search').click(function(e){
        let height = $('.navbar').outerHeight();
        let width = $('.navbar').outerWidth();

        $('#karaoke_list').hide();
        $('#searchbox').show();
    });

    $('.searchoff').click(function(e){
        

        $('#searchbox').hide();
        $('#karaoke_list').show();
    })

    $('.searchbtn').hover(function(){
        console.log(5);
        $(this).animate({
            "backgroundColor":"#ffc0cb"
        },100)
    }, function(){
        $(this).animate({
            "backgroundColor":"black"
        },100)
    })
});

