$(document).ready(function(){
    $('.catalog').dcAccordion({
        speed: 300,
    });

    // Слайлер на главной странице магазина
    $('.index__shop__slider').slick({
        // slidesToShow: 3,
        // slidesToScroll: 1,
        // vertical: true,
        autoplay: true,
        autoplaySpeed: 3000
    });
    // Функционал корзины
    function showCart(cart){
        $('#cart .modal-body').html(cart);
        $('#cart').modal();
    }

    $('#getCart').on('click', function(){
        $.ajax({
            url: '/cart/show',
            type: 'GET',
            success: function(res){
                if(!res) alert('Ошибка!');
                showCart(res);
            },
            error: function(){
                alert('Error!');
            }
        });
        return false;
    });

    // function getCart(){
    //     $.ajax({
    //         url: '/cart/show',
    //         type: 'GET',
    //         success: function(res){
    //             if(!res) alert('Ошибка!');
    //             showCart(res);
    //         },
    //         error: function(){
    //             alert('Error!');
    //         }
    //     });
    //     return false;
    // }

    $('#cart .modal-body').on('click', '.del-item', function(){
        var id = $(this).data('id');
        $.ajax({
            url: '/cart/del-item',
            data: {id: id},
            type: 'GET',
            success: function(res){
                if(!res) alert('Ошибка!');
                showCart(res);
            },
            error: function(){
                alert('Error!');
            }
        });
    });

    // function clearCart(){
    //     $.ajax({
    //         url: '/cart/clear',
    //         type: 'GET',
    //         success: function(res){
    //             if(!res) alert('Ошибка!');
    //             showCart(res);
    //         },
    //         error: function(){
    //             alert('Error!');
    //         }
    //     });
    // }

    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id'),
            qty = $('#qty').val();
        $.ajax({
            url: '/cart/add',
            data: {id: id, qty: qty},
            type: 'GET',
            success: function(res){
                if(!res) alert('Ошибка!');
                showCart(res);
            },
            error: function(){
                alert('Error!');
            }
        });
    });

    $('#clearCart').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/cart/clear',
            type: 'GET',
            success: function(res){
                if(!res) alert('Ошибка!');
                showCart(res);
            },
            error: function(){
                alert('Error!');
            }
        });
    });
});
