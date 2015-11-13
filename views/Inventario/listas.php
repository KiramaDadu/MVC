<!DOCTYPE html>
<html>
    <head>
        <title>LISTADO DE INVENTARIO</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="Url tracker system"/>
        <meta name="author" content="author@gmail.com"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Fonts-->
        <link rel="stylesheet" type="text/css" href="css?family=Tangerine">

        <!-- Bootstrap -->
        <link href="<?php echo URL_BASE."/public/css/bootstrap.min.css";?>" rel="stylesheet" media="screen">
        <link href="<?php echo URL_BASE."/public/css/custom.css";?>" rel="stylesheet" media="screen">

        </head>
    <body>
   <div class="container">
    <h3 class="text-center">INVENTARIO DE PRODUCCION Y VENTAS DEL INGENIO MANTE</h3>
    <hr>
    <p>Inspired by this <a href="http://bootsnipp.com/snippets/featured/panel-tables-with-filter">snippet</a></p>
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Dia #" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Demanda" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Produccion" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Inv. Inicial" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Inv. Final" disabled></th>
                    </tr>
                </thead>
                <tbody>
                 <?php $datos = $this->getDatos(); foreach ($datos as $key => $inventario):?>
                <tr>
                    <td><?php echo $inventario->dia;?></td>
                    <td><?php echo $inventario->demanda;?></td>
                    <td><?php echo $inventario->produccion;?></td>
                    <td><?php echo $inventario->inventario_inicial;?></td>
                    <td><?php echo $inventario->inventario_final;?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" scr="<?php echo URL_BASE."/public/js/bootstrap.min.js";?>" ></script>
    <script type="text/javascript" scr="<?php echo URL_BASE."/public/js/tables.js";?>" ></script>

   
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   
   
      



    </body>
    </html>