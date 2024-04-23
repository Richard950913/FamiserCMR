<?php
include ("../conexion.php");
include ("../sesion.php");
include ("../validar_rol.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style3.css">
    <title>Dashboard</title>

</head>

<body>
    <div class="dashboard-container">
        <img class="logo" src="../images/LOGO.png" alt="Logo">
        <div class="user-info">
            <p>Bienvenido,
                <?php echo $username; ?>
            </p>
            <p>&nbsp;&nbsp;</p>
            <form action="" method="POST">
                <input type="hidden" name="logout" value="true">
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
        </div>
    </div>
    <div class="dashboard-container">
    </div>
    <div class="menu-bar">
        <a href="../dashboard.php">INICIO</a>
        <div class="dropdown">
            <button class="dropbtn">MENU</button>
            <div class="dropdown-content">
                <a href="../regcliente/registro_cliente_form.php">Registrar cliente</a>
                <a href="../reglentes/registro_lentes_form.php">Compra de lente</a>
                <a href="#">Compra de Credencial</a>
                <a href="#">Abonos</a>
                <a href="#">Garantias</a>
                <a href="#">Incidentes</a>
                <a href="#">Proceso de Lentes</a>
            </div>
        </div>
        <a href="#">SOPORTE</a>
    </div>
    <div class="container">
        <h2>COMPRA DE LENTES</h2>
        <form method="post" action="busqopto.php" id=registro-form>
            <label for="cupolente"># de cupo:</label>
            <input type="number" id="cupolente" name="cupolente" required>
            <label for="estado">Estado:</label>
            <select class="form-select" name="estado" id="estado" required>
                <option value="PENDIENTE">Pendiente</option>
                <option value="CANCELADO">Cancelado</option>
                <option value="DEVOLUCION">Devolución</option>
            </select>
            <label for="idcliente">Id cliente:</label>
            <input type="number" id="idcliente" name="idcliente" required>
            <label for="fec_compra">Fecha de compra:</label>
            <input type="date" id="fec_compra" name="fec_compra">
            <label for="tipo_lente">Tipo de lente:</label>
            <select class="form-select" name="tipo_lente" id="tipo_lente" required>
                <option value=""></option>
                <option value="M + ">M</option>
                <option value="B + ">B</option>
                <option value="P + ">P</option>
            </select>
            <label for="filtro">Filtro:</label>
            <select class="form-select" name="filtro" id="filtro" required>
                <option value=""></option>
                <option value="AR ">AR</option>
                <option value="BLUE ">BLUE</option>
                <option value="FOTO + BLUE ">FOTO + BLUE</option>
                <option value="FOTO ">FOTO</option>
                <option value="TRANSITION ">TRANSITION</option>
            </select>
            <label for="graduacion">Graduacióm:</label>
            <select class="form-select" name="filtro" id="filtro" required>
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <label for="comp_adic">Compras adicionales:</label>
            <select class="form-select" name="comp_adic" id="comp_adic" required>
                <option value=""></option>
                <option value="GOTAS">GOTAS</option>
                <option value="MONTURA">MONTURA</option>
                <option value="LENTES DE CONTACTO">LENTES DE CONTACTO</option>
                <option value="OTROS">OTROS</option>
            </select>
            <label for="valor_total">Valor total:</label>
            <input type="number" id="valor_total" name="valor_total">
            <label for="sist_pago">Sistema de pago:</label>
            <select class="form-select" name="sist_pago" id="sist_pago" required>
                <option value="SISTECREDITO">Sistecredito</option>
                <option value="CONTADO">Contado</option>
                <option value="CREDITO">Crédito</option>
            </select>
            <label for="formula">FÓRMULA:</label>
            <input type="text" id="formula" name="formula">
            <label for="optometra"> Optómetra</label>
            <select name="opcion">
                <?php echo $options; ?>
            </select>
            <label for="comentarios">Comentarios:</label>
            <input type="text" id="comentarios" name="comentarios">

            <input type="submit" value="Registrar">
            <div id="mensaje-container" class="anuncio"></div>
        </form>
    </div>