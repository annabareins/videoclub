<?php
    require_once("connect_data.php");

    $sql_actors = [];
    $actors = [];
    if($actorsdb->count()>0){
        $sql_actors = $actorsdb->find();
        foreach ($sql_actors as $a){
            $aux = [];
            array_push($aux, $a["id"], $a["nom"], $a["imatge"]);
            array_push($actors, $aux);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="estils.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="main">
    <div>
        <?php foreach ($actors as $a){?>
            <img src="<?php echo $a[2]; ?>" height="180px" width="100%">
        <?php } ?>
    </div>
</div>
</body>
</html>
