<?php include_once dirname(__DIR__) . ROOT . 'header.php'?>
    <div class="card p-4 bg-light">
        <div class="card-header">
            <h1 class="text-center"><?= $data['subtitle'] ?></h1>
        </div>
        <div class="card-body">
            <?php foreach ($data['data'] as $key => $value): ?>  <!--recibira el valor de cada objeto vlue=product, $key es un numero del array-->
                <?php  if($key%4 ==0): ?>     <!--SI es un multiplo de 4 hace un salto de linea generadno un div-->
                    <div class="row">  <!---Cada producto debe ocupar tres column, inicio una nueva fila---->
                        <?php endif;?>
                     <div class="card pt-2 col-sm-3">
                         <img src="img/<?= $value->image?>" class="img-responsive"
                              style="width:100% " alt="<?=$value->name?>">            <!------saca la imagen de la carpeta public donde value guarda el nombre de la imagen------>
                         <a href="<?= ROOT ?>shop/show/<?= $value->id?>">           <!--EL nombre actua como enlace-->
                            <p> <?= $value->name ?></p>
                         </a>
                     </div>
                        <?php  if($key%4 ==3): ?>     <!--SI es tres lo cierra-->
                          </div>
                            <?php endif;?>          <!---cierra la fila cuando es distinto de 3---->
                </div>
            <?php endforeach; ?> <!----cierra aqui porque debe a ver hasta 4 filas--->
        </div>
        <div class="card-footer">

        </div>
    </div>
<?php include_once dirname(__DIR__) . ROOT . 'footer.php'?>