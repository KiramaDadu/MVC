<!DOCTYPE html>
<html>
    <head>
        <title>Listado de inventario</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="Url tracker system"/>
        <meta name="author" content="author@gmail.com"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Fonts-->
        <link rel="stylesheet" type="text/css" href="css?family=Tangerine">

        <!-- Bootstrap -->
        <link href="<?php echo URL_BASE."/public/css/bootstrap.min.css";?>" rel="stylesheet" media="screen">

        </head>
    <body>
        <div class="container">
        <div class="alert alert-danger" role="alert"><?php echo $this->errores['global']?></div>
        
            <div class="row">
                <form role="form" class="form" id="form1" method="POST" action="">                
                <div class="form-group <?php if (isset($this->errores['dia'])) echo 'has-error' ; ?>">
                    <label for="dia">D&iacute;a:</label>
                    <input type="number" required autofocus class="form-control" name="dia" id="dia" value="1" placeholder="1" min="1" max="10000000" step="1">
                    <?php if(isset($this->errores['dia'])) :?> <span id="helpBlock" class="help-block"><?php echo $this->errores['dia'];?></span><?php endif;?>
                </div>                
                <div class="form-group <?php if (isset($this->errores['demanda'])) echo 'has-error' ; ?>">
                    <label for="demanda">Demanda:</label>
                    <input type="number" required class="form-control"  value="1" name="demanda" id="demanda" placeholder="1" min="1" max="10000000" step="1">
                    <?php if(isset($this->errores['demanda'])) :?> <span id="helpBlock" class="help-block"><?php echo $this->errores['demanda'];?></span><?php endif;?>
                </div>                

                <div class="form-group <?php if (isset($this->errores['produccion'])) echo 'has-error' ; ?>">
                    <label for="produccion">Producci&oacute;n:</label>
                    <input type="number" required class="form-control"  value="1" name="produccion" id="produccion" placeholder="1" min="1" max="10000000" step="1">
                    <?php if(isset($this->errores['produccion'])) :?> <span id="helpBlock" class="help-block"><?php echo $this->errores['produccion'];?></span><?php endif;?>
                </div>
                                            
                <button name="enviarDatos" id="sendBtn" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Enviar</button>
                    
                </form>
            </div>
        </div>

   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo URL_BASE;?>/public/js/bootstrap.min.js"></script>
    </body>
    </html>