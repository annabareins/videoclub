$('#filtrar-btn').click(function(e){
    e.preventDefault();

    var esperar=1000;
    $.ajax({
        type: "POST",
        url: "clients-cerca.php",
        data: $('#form-cerca').serialize(),
        beforeSend : function(){
            $('.loader').css('display','inline-block');
            $('.taula_clnts').text('');
            console.log($('#form-cerca').serialize());
        },
        success : function(data){
            setTimeout(function(){
                $('.loader').css('display','none');
                $('.taula_clnts').html(data);
            },esperar
            );
        }
    })
});