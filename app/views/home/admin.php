<?php $this->start('body'); ?>
<!-- Small boxes (Stat box) -->
<div class="row">
   <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
         <div class="inner">
            <h3><?=$this->pedidos->total?></h3>
            <p>Total de pedidos por aprobar</p>
         </div>
         <div class="icon">
            <i class="ion ion-bag"></i>
         </div>
         <a href="<?=PROOT?>pedidos/listarPedidos" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
   </div>
   <!-- ./col -->
   <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
         <div class="inner">
            <h3><?=$this->entregas->total?><sup style="font-size: 20px"></sup></h3>
            <p>Total de entregas realizadas</p>
         </div>
         <div class="icon">
            <i class="ion ion-stats-bars"></i>
         </div>
         <a href="<?=PROOT?>factura/listarFinalizadas" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
   </div>
   <!-- ./col -->
   <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
         <div class="inner">
            <h3><?=$this->calificaciones->total?></h3>

            <p>Calificaciones</p>
         </div>
         <div class="icon">
            <i class="ion ion-person-add"></i>
         </div>
         <a href="<?=PROOT?>calificacion/listar" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
   </div>
   <!-- ./col -->
   <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
         <div class="inner">
            <h3><?=$this->por_finalizar->total?></h3>

            <p>Facturas pendientes por finalizar</p>
         </div>
         <div class="icon">
            <i class="ion ion-pie-graph"></i>
         </div>
         <a href="<?=PROOT?>factura/listarFacturas" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
   </div>
   <!-- ./col -->
</div>
<hr>
<!-- 
<div class="row">
   <div class="col-md-12">
      <div class="card card-info">
         <div class="card-header">
            <h2 class="card-title">Usuarios registrados</h2>
         </div>
         <div class="card-body p-0">
            <ul class="users-list clearfix">
               <li>
                  <img src="<?=PROOT?>adminlte/dist/img/user8-128x128.jpg" alt="User Image">
                  <a class="users-list-name" href="#">Norman</a>
                  <span class="users-list-date">Yesterday</span>
               </li>
               <li>
                  <img src="<?=PROOT?>adminlte/dist/img/user7-128x128.jpg" alt="User Image">
                  <a class="users-list-name" href="#">Jane</a>
                  <span class="users-list-date"><?=strftime("%d de %B de %Y");?></span>
               </li>
               <li>
                  <img src="<?=PROOT?>adminlte/dist/img/user6-128x128.jpg" alt="User Image">
                  <a class="users-list-name" href="#">John</a>
                  <span class="users-list-date"><?=strftime("%d de %B de %Y");?></span>
               </li>
               <li>
                  <img src="<?=PROOT?>adminlte/dist/img/user2-160x160.jpg" alt="User Image">
                  <a class="users-list-name" href="#">Alexander</a>
                  <span class="users-list-date"><?=strftime("%d de %B de %Y");?></span>
               </li>
               <li>
                  <img src="<?=PROOT?>adminlte/dist/img/user5-128x128.jpg" alt="User Image">
                  <a class="users-list-name" href="#">Sarah</a>
                  <span class="users-list-date"><?=strftime("%d de %B de %Y");?></span>
               </li>
               <li>
                  <img src="<?=PROOT?>adminlte/dist/img/user4-128x128.jpg" alt="User Image">
                  <a class="users-list-name" href="#">Nora</a>
                  <span class="users-list-date"><?=strftime("%d de %B de %Y");?></span>
               </li>
               <li>
                  <img src="<?=PROOT?>adminlte/dist/img/user3-128x128.jpg" alt="User Image">
                  <a class="users-list-name" href="#">Nadia</a>
                  <span class="users-list-date"><?=strftime("%d de %B de %Y");?></span>
               </li>
            </ul>
         </div>
         <div class="card-footer text-center">
            <a href="#">Ver todos los usuarios</a>
         </div>
      </div>
   </div>
</div> -->
<?php $this->end(); ?>


