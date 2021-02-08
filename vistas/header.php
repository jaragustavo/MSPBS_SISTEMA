
<?php
    if(strlen(session_id())<1)
    session_start();
?>
<html>
 
    <style>
    .btn-imprimir,
    .btn-imprimir:hover,
    .btn-imprimir:active,
    .btn-imprimir:visited,
    .btn-imprimir:focus {
        background-color: #8064A2;
        border-color: #8064A2;
        color: #FFF;
    }
    input[type=checkbox] {
          /* Double-sized Checkboxes
             width: 100%; */
         
            -moz-transform: scale(1.4); /* FF */
            -webkit-transform: scale(1.4); /* Safari and Chrome */
           
            transform: scale(1.4);
          
      }
      
      
          /* mPopup box style */
        .mpopup {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            align-content: center;
        }
        .mpopup-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            width: 60%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }
         .formulario-buscar {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            width: 100%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }


        .mpopup-head {
            padding: 2px 16px;
            background-color: #77a8a8;
            color: white;
            
        }
        .mpopup-main {padding: 30px 16px;}
        .mpopup-main input[type="text"]{
            width: 50%;
            height: 25px;
            font-size: 15px;
            transition: .8s;
        background-color: white;
        color: black;
        border-color:#006;
        border-bottom-color:white;
        border-bottom-style:groove;
        border-left:none;
        border-right:none;
        border-top:none;
        border-width: 4px;
        }
       .mpopup-main input[type="button"]{
            padding: 5px;
            font-size: 15px;
            font-weight: 300;
            background-color: darkcyan;
            outline: none;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        .mpopup-foot {
            padding: 1px 16px;
            background-color:  	#77a8a8;
            color: #ffffff;
        }

        /* add animation effects */
        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

       

        /* close button style */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover, .close:focus {
            color: white;
            text-decoration: none;
            cursor: pointer;
        }
   
      
      
       /* The switch - the box around the slider */
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  /* Hide default HTML checkbox */
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "NO";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    content: "SI";
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
        
        
</style>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SICIAP-PEDIDO</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
   -->
    <!-- Bootstrap 3.3.5 -->
    <script type="text/css" src="../public/css/bootstrap-datepicker.min.css"></script>
        
    
    
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/escudo.png">

    <!-- DATATABLES -->
    <link rel="stylesheet" type = "text/css" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" type = "text/css" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" type = "text/css" href="../public/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" type = "text/css" href="../public/css/bootstrap-select.min.css">
    <link rel="stylesheet" type = "text/css" href="../public/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type = "text/css" href="../public/css/bootstrap-datepicker3.min.css">
   
  </head>
  <body class="hold-transition  skin-blue-light sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SIRH</b>CONTRATO</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SIRH-CONTRATO</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" style="color: gray;" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="../public/img/escudo.png" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                      <img src="../public/img/escudo.png" class="img-circle" alt="User Image">
                      <p style="color: white;">
                      DGGIES-Sección Informática
                      <small style="color: white;">Desarrollando Software </small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <?php
            if ($_SESSION['escritorio']==1)
            {
                echo '<li>
                        <a href="#">
                          <i class="fa fa-tasks" aria-hidden="true"></i> 
                          <span>Escritorio</span>
                           <i class="fa fa-angle-left pull-right"></i>
                        </a>
                      </li>';
            } 
            ?>
            <?php 
       
            
         if ($_SESSION['reactivo']==1) //COVID COMPRAS
            {
            echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-folder fa-fw" aria-hidden="true"></i> 
                <span>Resoluciones</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              
              <ul class="treeview-menu"> ';
                         
                           if ($_SESSION['reactivoPedido']==1)
                           { 
                             echo '<li><a href="contrato.php"><i class="fa fa-circle-o"></i>Datos Contrato</a></li>';
                           } 
                           if ($_SESSION['reactivoLlamado']==1)
                           { 
                                echo '<li><a href="llamado.php"><i class="fa fa-circle-o"></i>Resoluciones</a></li>';
                           } 
                         
                      
               echo '</ul>
                       
            </li>';
            } 
            ?> 
            
         
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
