<?php
    require_once("connect_data.php");
    $directors = [];
    $sql_directors = [];
    $actors = [];
    $sql_actors = [];
    $categories = [];
    $sql_categories = [];
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
    if ($categoriesdb->count()>0) {
        $sql_categories = $categoriesdb->find();
        foreach ($sql_categories as $c) {
            $aux = [];
            array_push($aux, $c["_id"],$c["acronim"],$c["nom"],$c["pelicules"]);
            $categories[] = $aux;
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
                                    echo "<option value='" .$d[0]. "'>" .$d[1]."</option>";
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
                                    <option>Selecciona els Actors de la Pel·licula</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes">
                                <?php foreach ($actors as $a) {
                                    echo "<label> 
                                        <input type='checkbox' class='actorsPelicula' onchange='getValue(this.value)' value='$a[0]'>
                                        " . $a[1] . "</label>";
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i aria-hidden="true" title="Actor/s Pel·licula"></i>
                        <label> Actor/s de la Pel·licula </label>
                        <div class="multiSelect">
                            <div class="selectBox" onclick="showCheckboxesCategories()">
                                <select>
                                    <option>Selecciona les Categories de la Pel·licula</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxesCategories">
                                <?php foreach ($categories as $c) {
                                    echo "<label> 
                                        <input type='checkbox' class='actorsPelicula' onchange='getValueCategories(this.value)' value='$c[0]'>
                                        " . $c[2] . "</label>";
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <label for="duradaPelicula">Durada Pel·licula</label>
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
    let expandedCategories = false;
    let actors = [];
    let categories = [];
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
    function showCheckboxesCategories() {
        var checkboxes = document.getElementById("checkboxesCategories");
        if (!expandedCategories) {
            checkboxes.style.display = "block";
            expandedCategories = true;
        } else {
            checkboxes.style.display = "none";
            expandedCategories = false;
        }
    }
    function getValue(value){
        let found = false;
        for( var i = 0; i < actors.length; i++){

            if ( actors[i] === value) {

                actors.splice(i, 1);
                found = true;
                break;
            }
        }
        if (!found)
            actors.push(value);
    }
    function getValueCategories(value){
        let found = false;
        for( var i = 0; i < categories.length; i++){

            if ( categories[i] === value) {

                categories.splice(i, 1);
                found = true;
                break;
            }
        }
        if (!found)
            categories.push(value);
    }
    function createMovie(){
        let FD = new FormData();
        let titol, nomDirector, duradaPelicula, PEGI, valoracioPelicula, anyPelicula, descripcioPelicula, imatgePelicula, a;
        titol = document.getElementById("titolPelicula").value;
        nomDirector = document.getElementById("directorPelicula").value;
        duradaPelicula = document.getElementById("duradaPelicula").value;
        PEGI = document.getElementById("PEGI").value;
        valoracioPelicula = document.getElementById("valoracioPelicula").value;
        anyPelicula = document.getElementById("anyPelicula").value;
        descripcioPelicula = document.getElementById("descripcioPelicula").value;
        imatgePelicula = document.getElementById("imatgePelicula").value;
        FD.append("titol", titol)
        FD.append("nomDirector", nomDirector);
        FD.append("duradaPelicula", duradaPelicula);
        FD.append("PEGI", PEGI);
        FD.append("valoracioPelicula", valoracioPelicula);
        FD.append("anyPelicula", anyPelicula);
        FD.append("descripcioPelicula", descripcioPelicula);
        FD.append("imatgePelicula", imatgePelicula);
        for (const actor in actors){
            FD.append("actors[]", actors[actor]);
        }
        for (const categoria in categories){
            FD.append("categories[]", categories[categoria]);
        }
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
</style>