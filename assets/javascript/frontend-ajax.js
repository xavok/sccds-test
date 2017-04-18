jQuery(document).ready(function ($) {
    var $content = $('.ajax_posts');
    var $loader = $('#more_posts button');
    // var cat = $loader.data('category');
    var $ppp = 10;
    var $offset = $('.ajax_posts').find('article').length;
    // console.log($offset);

    $loader.on('click', bs_load_ajax_posts);

    function bs_load_ajax_posts() {
        if (!($loader.hasClass('post_loading_loader') || $loader.hasClass('post_no_more_posts'))) {
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: frontend_ajax_object.ajaxurl,
                data: {
                    'name': $('#name').val(),
                    'location': $('#location').val(),
                    'specialty-cat': $('#specialty').val(),
                    'ppp': $ppp,
                    'offset': $offset,
                    'action': 'bs_more_post_ajax',
                },
                beforeSend: function () {
                    $loader.addClass('post_loading_loader').html('Loading...');
                },
                success: function (data) {
                    var $data = $(data);
                    console.log(data);
                    if ($data.length) {
                        //var $newElements = $data.css({ opacity: 0 });
                        var $newElements = $data;
                        $content.append($newElements);
                        $newElements.animate({opacity: 1});
                        $loader.removeClass('post_loading_loader').html(frontend_ajax_object.loadmore);
                    } else {
                        $loader.removeClass('post_loading_loader').addClass('post_no_more_posts').html(frontend_ajax_object.noposts);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $loader.html($.parseJSON(jqXHR.responseText) + ' :: ' + textStatus + ' :: ' + errorThrown);
                    console.log(jqXHR);
                },
            });
        }
        $offset += $ppp;
        // console.log('Offset ' + $offset);
        // console.log('PPP ' + $ppp);
        return false;
    }
});
