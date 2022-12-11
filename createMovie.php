<?php
    require_once("connect_data.php");
    $directors = [];
    $sql_directors = [];
    $actors = [];
    $sql_actors = [];
    if ($directorsdb->count()>0) {
        $sql_directors = $directorsdb->find();
        foreach ($sql_directors as $d) {
            $aux = [];
            array_push($aux, $d["_id"],$d["nom"],$d["imatge"],$d["pelicules"]);
            $directors[] = $aux;
        }
        /*echo '<pre>'; print_r($directors); echo '</pre>';*/
    }
    if ($actorsdb->count()>0) {
        $sql_actors = $actorsdb->find();
        foreach ($sql_actors as $a) {
            $aux = [];
            array_push($aux, $a["_id"],$a["nom"],$a["imatge"],$a["pelicules"]);
            $actors[] = $aux;
        }
    }

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
        <div>
            <div style="display: flex; justify-content: center; align-items: center"> INSEREIX NOVA PELI </div>
            <form>
                <ul>
                    <li>
                        <label for="titolPelicula">Titol Pel·licula</label>
                        <input type="text" id="titolPelicula" name="titolPelicula" />
                    </li>
                    <li>
                        <i aria-hidden="true" title="Director Pel·licula"></i>
                        <label> Director de la Pel·licula </label>
                        <div class="desp_cat">
                            <select id="directorPelicula">
                                <?php foreach ($directors as $d)
                                    echo "<option value='" .$d[1]. "'>" .$d[1]."</option>";
                                ?>
                            </select>
                        </div>
                    </li>
                    <li>
                        <i aria-hidden="true" title="Actor/s Pel·licula"></i>
                        <label> Actor/s de la Pel·licula </label>
                        <div class="multiSelect">
                            <div class="selectBox" onclick="showCheckboxes()">
                                <select>
                                    <option>Select an option</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes">
                                <?php foreach ($actors as $a) {
                                    echo "<label> 
                                        <input type='checkbox' id='directorPelicula' value='.$a[0].'> 
                                        " . $a[1] . "</label>";
                                }
                                ?>
                            </div>
                        </div>
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
    let expanded = false;

    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
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
<style>
    .multiselect {
        width: 200px;
    }

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 100%;
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
</style>