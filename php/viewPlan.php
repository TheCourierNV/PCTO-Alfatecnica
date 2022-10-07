<?php
require_once('connessione.php');

$idAnag = isset($_POST['idAnag']) ? $_POST['idAnag'] : 0;
if(!$idAnag == 0){
  $select = "SELECT Sold_Products.sold_product_id, Product_Category.name, Sold_Products.x, Sold_Products.y, Product_Category.icon_image_path AS pathProd, planimetrie.path_img AS pathSfondo, planimetrie.width, planimetrie.height
             FROM app JOIN planimetrie JOIN Sold_Products JOIN Companies
             ON planimetrie.id = app.idPlanimetria
             AND app.idAnagrafica = anagrafica.id # Incompleta
             AND app.idProdotto = Sold_Products.sold_product_id
             AND prodotti.idProdImg = prodotti_img.id
             WHERE app.idAnagrafica = " . $idAnag;
  $result = $pdo->query($select);
  $arr = array();
  $i = 0;
  if($result){
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      $arr[$i] = array(
        'id_prod' => $row['id'],
        'nome_prod' => $row['nome_prodotto'],
        'posX' => $row['pos_x'],
        'posY' => $row['pos_y'],
        'pathProd' => $row['pathProd'],
        'pathSfondo' => $row['pathSfondo'],
        'w' => $row['width'],
        'h' => $row['height']
      );
      $i++;
    }
  } else {
    $arr = [
      'dati' => 'Nessun dato trovato',
      'msg' => 'Planimetria ancora da configurare'
    ];
  }
  $json = json_encode($arr);
  echo $json;
}
 ?>
