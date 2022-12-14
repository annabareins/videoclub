<?php
require_once("connect_data.php");


?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Crear Pel·licules</title>
    <?php require_once("head.php"); ?>
</head>
<body>
<div class="contenidor">
    <?php require("menu.php"); ?>
    <div class="send" style="margin: auto; overflow-x: hidden; overflow-y: scroll; height: 90%">
        <form>
            <ul>
                <li>
                    <label class="label" for="nomActor">Nom Actor</label>
                    <br>
                    <input class="rounded-input" type="text" id="nomActor" name="nomActor" value=""/>
                </li>
                <li>
                    <label for="imatgePelicula">Imatge Actor</label>
                    <br>
                    <input type="text" class="rounded-input" id="imatgeActor" name="imatgePelicula" value="" />
                </li>
            </ul>
            <div class="botoCreateMovie" style="margin: 20px">
                <button id="createMovie" style="margin-left:30px; padding: 10px 50px 10px 50px;background-color: green; color: #FFFFFF;" onclick="insertActor()">Inserir Actor</button>
            </div>
            <ul>
                <li>
                    <label class="label" for="nomActor">Nom Director</label>
                    <br>
                    <input class="rounded-input" type="text" id="nomDirector" name="nomActor" value=""/>
                </li>
                <li>
                    <label for="imatgePelicula">Imatge Director</label>
                    <br>
                    <input type="text" class="rounded-input" id="imatgeDirector" name="imatgePelicula" value="" />
                </li>
            </ul>
            <div class="botoCreateMovie" style="margin: 20px">
                <button id="createMovie" style="margin-left:30px; padding: 10px 50px 10px 50px;background-color: green; color: #FFFFFF;" onclick="insertDirector()">Inserir Director</button>
            </div>
        </form>
    </div>
</div>
</body>
<script>
    function insertActor(){
        let FD = new FormData();
        const nom = document.getElementById("nomActor").value;
        const imatge = document.getElementById("imatgeActor").value;
        if(nom === "" || imatge === ""){
            Swal.fire({
                icon: 'warning',
                title: 'Ups!',
                text: 'Emplena tots els camps',
                confirmButtonText: 'Okay',
            })
            return;
        }
        FD.append("nom", nom);
        FD.append("foto", imatge);
        $.ajax({
            type: "POST",
            url: "ajaxInsertActor.php",
            data: FD,
            processData: false,
            contentType: false,
            success: function (data) {
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
    function insertDirector() {
        let FD = new FormData();
        const nom = document.getElementById("nomDirector").value;
        const imatge = document.getElementById("imatgeDirector").value;
        if(nom === "" || imatge === ""){
            Swal.fire({
                icon: 'warning',
                title: 'Ups!',
                text: 'Emplena tots els camps',
                confirmButtonText: 'Okay',
            })
            return;
        }
        FD.append("nom", nom);
        FD.append("foto", imatge);
        $.ajax({
            type: "POST",
            url: "ajaxInsertDirector.php",
            data: FD,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data !== "1"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Director Creat!',
                        confirmButtonText: 'Okay',
                    });//.then((result) => {window.location.href = "pelicules.php";})
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ups!',
                        text: 'Ja existeix un director amb aquest nom',
                        confirmButtonText: 'Okay',
                    })
                }
            }
        })
    }
</script>
<style>
    .multiselect {
        width: 200px;
    }

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 50%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    #checkboxes {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxes label {
        display: block;
    }

    #checkboxes label:hover {
        background-color: #1e90ff;
    }
    #checkboxesCategories {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxesCategories label {
        display: block;
    }

    #checkboxesCategories label:hover {
        background-color: #1e90ff;
    }

    .rounded-input {
        padding:10px;
        border-radius:10px;
    }
    label {
        font-size: 1.5em;
    }
    .send {
        width: 750px;
        padding: 10px;
        border: 1px solid black;
        margin: 0;
    }

</style>