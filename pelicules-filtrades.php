<?php

require_once("connect_data.php");

 $pelicules = [];
 $any = 0;
 $rating ='';


foreach($_REQUEST as $key => $val){
    switch($key){
        case 'any':
            $any=$val;
            break;

        case 'val':
            $rating=$val;
            break;

        default:
            $categoria = "";
            if($categoriesdb->count()>0){
                $categoria = $categoriesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($val)]);
            }

            $peliculesids = [];
            foreach ($categoria["pelicules"] as $p){
                $peliculesids[] = new MongoDB\BSON\ObjectId($p);
            }

            $sql_pelicules='';
            if($peliculesdb->count()>0){
                if($any > 0 ){
                    $sql_pelicules = $peliculesdb->find([
                        '_id' => ['$in' => $peliculesids],
                        'valoracio' => ['$gt' => new MongoDB\BSON\Decimal128($rating)],
                        'any' => ['$eq' => new MongoDB\BSON\Decimal128($any)],
                    ]);
                }
                else{
                    $sql_pelicules = $peliculesdb->find([
                        '_id' => ['$in' => $peliculesids],
                        'valoracio' => ['$gte' => new MongoDB\BSON\Decimal128($rating)]
                    ]);
                }
                foreach ($sql_pelicules as $p){
                    $aux = [];
                    array_push($aux, $p["_id"], $p["titol"], $p["imatge"], $p["valoracio"], $p["pegi"], $p["any"]);
                    array_push($pelicules, $aux);
                }
            }
            break;
    }
}
// no es selecciona cap cat per tan es mostren totes
if(count($_REQUEST) < 3){
    $sql_pelicules = [];
    if($peliculesdb->count()>0){
        if($any > 0 ){
            $sql_pelicules = $peliculesdb->find([
                'valoracio' => ['$gte' => new MongoDB\BSON\Decimal128($rating)],
                'any' => ['$eq' => new MongoDB\BSON\Decimal128($any)],
            ]);
        }
        else{
            $sql_pelicules = $peliculesdb->find(['valoracio' =>['$gt' => new MongoDB\BSON\Decimal128($rating)]]);
        }
        foreach ($sql_pelicules as $p){
            $aux = [];
            array_push($aux, $p["_id"], $p["titol"], $p["imatge"], $p["valoracio"], $p["pegi"], $p["any"]);
            array_push($pelicules, $aux);
        }
    }
}

?>

<?php foreach ($pelicules as $p){?>
    <div class="pelicula" data-id="<?php echo $p[0];?>">
        <img src="<?php echo $p[2]; ?>" height="100%" width="180px">
        <div><?php if (strlen($p[1])>22) {echo substr($p[1], 0, 20)."...";} else{echo $p[1];}?></div>
        <div><?php echo $p[5]; ?> - <?php echo $p[3]; ?> <i class="fa fa-star" aria-hidden="true" style="color: #F1C40F"></i></div>
    </div>
<?php } ?>