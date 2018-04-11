$(document).ready(function(){
    $('.slider_recomend').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 5,
        speed: 800,
        prevArrow:"<div class=\"btn_left slick-arrow\" style=\"display: block;\"><img src=\"/new_img/btn_left_news.png\"></div>",
        nextArrow:"<div class=\"btn_right slick-arrow\" style=\"display: block;\"><img src=\"/new_img/btn_right_news.png\"></div>"
    });
});