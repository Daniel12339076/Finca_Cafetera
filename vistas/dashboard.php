<?php include 'vistas/layout/header.php'; ?>

<div class="row">
    <div class="col-12">
        <h1>Dashboard</h1>
        <p class="lead">Bienvenido al Sistema de Gestión de Recolección de Café</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Trabajadores</div>
            <div class="card-body">
                <h4 class="card-title">Gestionar</h4>
                <p class="card-text">Administra los trabajadores recolectores</p>
                <a href="index.php?accion=trabajadores" class="btn btn-light">Ver Trabajadores</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Recolección</div>
            <div class="card-body">
                <h4 class="card-title">Registrar</h4>
                <p class="card-text">Registra la recolección diaria</p>
                <a href="index.php?accion=recolecciones_formulario" class="btn btn-light">Registrar</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Reportes</div>
            <div class="card-body">
                <h4 class="card-title">Consultar</h4>
                <p class="card-text">Ve reportes y estadísticas</p>
                <a href="index.php?accion=reportes" class="btn btn-light">Ver Reportes</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Configuración</div>
            <div class="card-body">
                <h4 class="card-title">Precios</h4>
                <p class="card-text">Configura precios por calidad</p>
                <a href="#" class="btn btn-light">Configurar</a>
            </div>
        </div>
    </div>
</div>

<?php include 'vistas/layout/footer.php'; ?>
