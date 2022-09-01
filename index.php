<?php include "section/db.php" ?>

<?php 

if (isset($_POST['resimyukle'])) {

$resim_ad = $_POST['resim_adi'];

$yukleklasor = "uploads/"; // Yüklenecek klasör
$tmp_name = $_FILES['yukle_resim']['tmp_name'];
$name = $_FILES['yukle_resim']['name'];
$boyut = $_FILES['yukle_resim']['size'];
$tip = $_FILES['yukle_resim']['type'];
$uznati = substr($name,-4,4);
$rastgelesayi1 = rand(10000,50000);
$rastgelesayi2 = rand(10000,50000);
$resimad = $rastgelesayi1.$rastgelesayi2.$uznati;

// Dosya varmı kontrol
if(strlen( $name) == 0 ) {
    echo "bir soya giriniz !";
    exit();
}

// Boyut kontrol
if ($boyut > (1024*1024*3)){
    echo "dosya boyutu çok fazla";
    exit();
}

// Tip kontrol
if ($tip != 'image/jpeg' && $tip != 'image/png' && $uzanti != '.jpg' ) {
    echo "Yalnızca jpeg veya png formatında olabilir" ;
}

move_uploaded_file($tmp_name, "$yukleklasor/$resimad");

$resimsor = $db->prepare('INSERT INTO imgs set 
images=:resim,
resim_ad=:resimad
');

$resimyukle = $resimsor->execute(array('
resim' => $resimad,
'resimad' => $resim_ad
));

    
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO IMG</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Görsel Ekleme</h2>

        <form action="" method="POST" enctype="multipart/form-data">

            <input type="text" name="resim_adi" >

            <input type="file" name="yukle_resim">
            <input type="submit" value="YÜKLE" name="resimyukle">

        </form>
        <hr style="margin-top:1rem">

<?php

$resimsor = $db->prepare('SELECT * FROM imgs');
$resimsor->execute(array());

while ($resimyaz = $resimsor->fetch(PDO::FETCH_ASSOC)) {

?>

    <img src="uploads/<?php echo $resimyaz['images'] ?>" alt="" class="w-50" style="margin-top:1rem;">

    <?php } ?>

    </div>




</body>

</html>