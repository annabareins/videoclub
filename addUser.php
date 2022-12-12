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
            <h1>Afegir Usuari</h1>
            <label for="dni">Dni:</label><br>
            <input type="text" id="dni" name="dni"><br>
            <label for="nom">Nom:</label><br>
            <input type="text" id="nom" name="nom"><br>
            <label for="telefon">Telèfon:</label><br>
            <input type="number" id="telefon" name="telefon"><br>
            <label for="email">E-mail:</label><br>
            <input type="text" id="email" name="email"><br>
            <button class="botoAfegirUsuari" type="button">Afegir Usuari</button>
        </form>

    </div>

</div>


</body>

<script>
    $(document).on("click", ".botoAfegirUsuari", function () {
        var FD = new FormData();
        var dni = document.getElementById("dni").value
        var nom = document.getElementById("nom").value
        var telefon = document.getElementById("telefon").value
        var email = document.getElementById("email").value

        FD.append("dni", dni);
        FD.append("nom", nom);
        FD.append("telefon", telefon);
        FD.append("email", email);
        if(dni === "" || nom === "" || telefon === "" || email === ""){
            Swal.fire({
                icon: 'warning',
                title: 'Ups!',
                text: 'Emplena tots els camps',
                confirmButtonText: 'Okay',
            })
        } else if (dni.length != 9) {
            Swal.fire({
                icon: 'warning',
                title: 'Ups!',
                text: 'El format del DNI no és correcte',
                confirmButtonText: 'Okay',
            })
        }
        else{
            $.ajax({
                type: "POST",
                url: "ajaxInsertUser.php",
                data: FD,
                processData: false,
                contentType: false,
                success : function(data){
                    if(data != "1"){
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuari Creat!',
                            confirmButtonText: 'Okay',
                        }).then((result) => {window.location.href = "pelicules.php";})
                    }
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups!',
                            text: 'Ja existeix un usuari amb aquest DNI',
                            confirmButtonText: 'Okay',
                        })
                    }
                }
            })
        }
    });
</script>
</html>