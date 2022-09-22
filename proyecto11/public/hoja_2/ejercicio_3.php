<?php include('../header.php' );?>
    <h3>Resolucion del ejercicio 3 de la hoja 1</h3>
    <?php
    $a=1;
    $b=2;
    $c=3;

    $discriminante=$b * $b -4 * $a * $c;

    if($discriminante>0){
        $solucion =(-$b + sqrt($discriminante))/(2 * $a);
        $solucion2=(-$b - sqrt($discriminante))/(2 * $a);

        echo "x1 = " .$solucion . '<br>';
        echo "x2 = " .$solucion2 . '<br>';

    }else if($discriminante == 0){

        $solucion= -$b/(2 * $a);
        echo "x =  " . $solucion . '<br>';

    }else{
        $solucionREal=-$b/(2 * $a);
        $solucionImaginaria= sqrt(-$discriminante) / (2 * $a);

        echo 'x1= ' . $solucionREal . ' + ' . $solucionImaginaria . 'i';
        echo 'x1= ' . $solucionREal . ' - ' . $solucionImaginaria . 'i';
    }

    ?>
<?php include('../footer.php') ?>