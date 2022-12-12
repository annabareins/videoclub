<?php
require_once("connect_data.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clients</title>
    <link rel="stylesheet" href="estils.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<body>
<div class="contenidor">
    <?php require("menu.php"); ?>
    <div class="header">
        <div class="logo"><img src="logo1.png"></div>
    </div>
    <div class="llista_clients">
        <form class= "form_add_client">
            <h1>Afegir Actor</h1>
            <label for="nom">Nom:</label><br>
            <input type="text" id="nom" name="nom"><br>
            <label for="foto">Link Foto:</label><br>
            <input type="text" id="foto" name="foto"><br>
            <button class="botoAfegirUsuari" type="button">Afegir Actor</button>
        </form>

    </div>

</div>


</body>

<script>
    $(document).on("click", ".botoAfegirUsuari", function () {
        var FD = new FormData();
        var nom = document.getElementById("nom").value
        var foto = document.getElementById("foto").value


        FD.append("nom", nom);
        FD.append("foto", foto);
        if(nom === "" || foto === ""){
            Swal.fire({
                icon: 'warning',
                title: 'Ups!',
                text: 'Emplena tots els camps',
                confirmButtonText: 'Okay',
            })
        } else {
            $.ajax({
                type: "POST",
                url: "ajaxInsertActor.php",
                data: FD,
                processData: false,
                contentType: false,
                success : function(data){
                    console.log(data)
                    if(data !== "1"){
                        Swal.fire({
                            icon: 'success',
                            title: 'Actor Creat!',
                            confirmButtonText: 'Okay',
                        });//.then((result) => {window.location.href = "pelicules.php";})
                    }
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups!',
                            text: 'Ja existeix un actor amb aquest nom',
                            confirmButtonText: 'Okay',
                        })
                    }
                }
            })
        }
    });
</script>
</html>