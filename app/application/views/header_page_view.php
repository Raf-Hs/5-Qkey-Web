<?php


$tipo_usuario = $this->session->userdata("tipo_usuario");
//$tipo_usuario = 1;
//$this->session->set_userdata("tipo_usuario", $tipo_usuario);

// Definir los títulos y enlaces para las opciones de menú
$opciones_menu = array(
    1 => array(
        array('titulo' => 'H-Clases', 'enlace' => base_url('Completadas')),
	array('titulo' => 'G-Clases', 'enlace' => base_url('Clases')),
	array('titulo' => 'G-Maestros', 'enlace' => base_url('Usuarios')),
	array('titulo' => 'G-Alumnos', 'enlace' => base_url('Usuarios1')),
	array('titulo' => 'A-Maestros', 'enlace' => base_url('alta')
)

    ),
    2 => array(
        array('titulo' => 'H-Maestros', 'enlace' => base_url('maestros'))
    ),
    3 => array(
        array('titulo' => 'H-Alumnos', 'enlace' => base_url('alumnos'))
    )
);

// Verificar si el tipo de usuario tiene opciones de menú definidas
$usuario_puede_ver = isset($opciones_menu[$tipo_usuario]) ? $opciones_menu[$tipo_usuario] : array();
?>



<?php
$recarga = $recarga ?? false;
?>
<!DOCTYPE html>
<html>
<head>
<?php
if ( $recarga ) :
?>	
	<meta http-equiv="refresh" content="5">
<?php
endif;
?>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $titulo ?></title>

	<link rel="shortcut icon" href="<?= base_url() ?>static/images/logo_uteq.ico">
	<link href="<?= base_url() ?>static/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?= base_url() ?>static/fontawesome/css/all.min.css" rel="stylesheet" />

<?php
// CICLO PARA PONER LOS CSS
if ( isset( $css ) ) :
	foreach( $css as $link ) :
?>
	<link href="<?= base_url() ?>static/css/<?= $link ?>.css" rel="stylesheet" />
<?php
	endforeach;
endif;
?>

	<script src="<?= base_url() ?>static/js/jquery-3.6.3.min.js"></script>
	<script src="<?= base_url() ?>static/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php
// CICLO PARA PONER LOS JS
if ( isset( $js ) ) :
	foreach( $js as $script ) :
?>
	<script src="<?= base_url() ?>static/js/<?= $script ?>.js"></script>
<?php
	endforeach;
endif;
?>

	<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>

</head>
<body>

	<div id="cargando">
    <h1>
        <i class="fas fa-spinner fa-pulse fa-3x"></i>
        Cargando...
    </h1>
</div>

<div class="container mt-3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Mostrar opciones de menú según el tipo de usuario -->
                    <?php foreach ($usuario_puede_ver as $opcion) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $opcion['enlace'] ?>"><?= $opcion['titulo'] ?></a>
                        </li>
                    <?php endforeach; ?>

                    <!-- Mostrar botón de iniciar sesión o cerrar sesión según el estado del usuario -->
                    <?php if ($this->session->has_userdata("tipo_usuario")) : ?>
                        <li class="nav-item" id="menu-deseos">
                            <a class="nav-link" href="<?= base_url('Login/logout') ?>">Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="container mt-3">
    <h3><?= $titulo ?></h3>