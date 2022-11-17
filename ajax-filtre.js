$('#filtrar-btn').click(function(e){
    e.preventDefault();

    var esperar=1500;
    console.log($('#form-filtre').serialize());
    $.ajax({
        url: "pelicules-filtrades.php",
        data: $('#form-filtre').serialize(),
        beforeSend : function(){
            $('.loader').css('display','inline-block');
            $('.llista_pelicules').text('');
        },
        success : function(data){
            setTimeout(function(){
                $('.loader').css('display','none');
                $('.llista_pelicules').html(data);
            },esperar
            );
        }
    })
});