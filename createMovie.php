<?php ?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Crear Pel·licules</title>
    <?php require_once("head.php"); ?>
</head>
<body>
    <div class="contenidor">
        <?php require("menu.php"); ?>
        <div>
            <div style="display: flex; justify-content: center; align-items: center"> INSEREIX NOVA PELI </div>
            <form>
                <ul>
                    <li>
                        <label for="titolPelicula">Titol Pel·licula</label>
                        <input type="text" id="titolPelicula" name="titolPelicula" />
                    </li>
                    <li>
                        <label for="nomDirector">Nom Director</label>
                        <input type="text" id="nomDirector" name="nomDirector" />
                    </li>
                    <li>
                        <label for="duradaPelicula">Titol Pel·licula</label>
                        <input type="text" id="duradaPelicula" name="duradaPelicula" />
                    </li>
                    <li>
                        <label for="PEGI">PEGI</label>
                        <input type="text" id="PEGI" name="PEGI" />
                    </li>
                    <li>
                        <label for="valoracioPelicula">Valoracio Pel·licula</label>
                        <input type="number" id="valoracioPelicula" name="valoracioPelicula" />
                    </li>
                    <li>
                        <label for="anyPelicula">Any Pel·licula</label>
                        <input type="number" id="anyPelicula" name="anyPelicula" />
                    </li>
                    <li>
                        <label for="descripcioPelicula">Descripcio Pel·licula</label>
                        <input type="text" id="descripcioPelicula" name="descripcioPelicula" />
                    </li>
                    <li>
                        <label for="imatgePelicula">Imatge Pel·licula</label>
                        <input type="file" id="imatgePelicula" name="imatgePelicula" />
                    </li>
                </ul>
            </form>
            <div class="botoCreateMovie">
                <button id="createMovie" onclick="createMovie()">Inserir pel·licula</button>
            </div>
        </div>
    </div>
</body>
<script>
    function createMovie(){
        let FD = new FormData();
        let titol, nomDirector, duradaPelicula, PEGI, valoracioPelicula, anyPelicula, descripcioPelicula, imatgePelicula;
        titol = document.getElementById("titolPelicula").value;
        nomDirector = document.getElementById("nomDirector").value;
        duradaPelicula = document.getElementById("duradaPelicula").value;
        PEGI = document.getElementById("PEGI").value;
        valoracioPelicula = document.getElementById("valoracioPelicula").value;
        anyPelicula = document.getElementById("anyPelicula").value;
        descripcioPelicula = document.getElementById("descripcioPelicula").value;
        imatgePelicula = document.getElementById("imatgePelicula").value;
        FD.append("titol", titol);
        FD.append("nomDirector", nomDirector);
        FD.append("duradaPelicula", duradaPelicula);
        FD.append("PEGI", PEGI);
        FD.append("valoracioPelicula", valoracioPelicula);
        FD.append("anyPelicula", anyPelicula);
        FD.append("descripcioPelicula", descripcioPelicula);
        FD.append("imatgePelicula", imatgePelicula);
        console.log('HOLA ' + nomDirector);
        $.ajax({
            type: "POST",
            url: "ajaxCreateMovie.php",
            data: FD,
            processData: false,
            contentType: false,
            success: function (data) {
                window.location.href = "pelicules.php"
            }
        })
    }
</script>