function refresh()
{
    $.get('index.php?ajax&page=listeMessage', function(html)
    {
        $('.js_list').html(html);
    });
}
$('document').ready(function(){ 
 
    $('.js_form').submit(function(info)
    {
        info.preventDefault();
        var message = $('.js_in').val();
        $.post('message', {content:message,action:"create_message"}, function()
        {
            $('.js_in').val('').focus();
            refresh();
        });
        return false;
    });
    
    setInterval(function()
    {
        refresh();
    },1000);

    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    }); 

    $('.scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
 
});