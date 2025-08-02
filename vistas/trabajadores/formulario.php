<?php include 'vistas/layout/header.php'; ?>

<div class="row">
    <div class="col-md-8">
        <h1><?php echo isset($trabajador) ? 'Editar' : 'Nuevo'; ?> Trabajador</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="index.php?accion=trabajador_guardar" id="formTrabajador">
                    <?php if (isset($trabajador)): ?>
                        <input type="hidden" name="id" value="<?php echo $trabajador['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                               value="<?php echo isset($trabajador) ? htmlspecialchars($trabajador['nombre']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="identificacion" class="form-label">Identificación *</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion" 
                               value="<?php echo isset($trabajador) ? htmlspecialchars($trabajador['identificacion']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" 
                               value="<?php echo isset($trabajador) ? htmlspecialchars($trabajador['telefono']) : ''; ?>">
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="index.php?accion=trabajadores" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'vistas/layout/footer.php'; ?>
