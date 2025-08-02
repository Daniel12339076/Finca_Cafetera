<?php include 'vistas/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Trabajadores</h1>
    <a href="index.php?accion=trabajador_formulario" class="btn btn-primary">Nuevo Trabajador</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Identificación</th>
                        <th>Teléfono</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trabajadores as $trabajador): ?>
                    <tr>
                        <td><?php echo $trabajador['id']; ?></td>
                        <td><?php echo htmlspecialchars($trabajador['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['identificacion']); ?></td>
                        <td><?php echo htmlspecialchars($trabajador['telefono']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($trabajador['fecha_creacion'])); ?></td>
                        <td>
                            <a href="index.php?accion=trabajador_formulario&id=<?php echo $trabajador['id']; ?>" 
                               class="btn btn-sm btn-outline-primary">Editar</a>
                            <a href="index.php?accion=trabajador_eliminar&id=<?php echo $trabajador['id']; ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Está seguro de eliminar este trabajador?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'vistas/layout/footer.php'; ?>
