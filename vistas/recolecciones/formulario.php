<?php include 'vistas/layout/header.php'; ?>

<div class="row">
    <div class="col-md-8">
        <h1>Registrar Recolección</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Recolección registrada exitosamente</div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="index.php?accion=recoleccion_registrar" id="formRecoleccion">
                    <div class="mb-3">
                        <label for="trabajador_id" class="form-label">Trabajador *</label>
                        <select class="form-select" id="trabajador_id" name="trabajador_id" required>
                            <option value="">Seleccione un trabajador</option>
                            <?php foreach ($trabajadores as $trabajador): ?>
                                <option value="<?php echo $trabajador['id']; ?>">
                                    <?php echo htmlspecialchars($trabajador['nombre']) . ' - ' . $trabajador['identificacion']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha *</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" 
                               value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="calidad" class="form-label">Calidad *</label>
                        <select class="form-select" id="calidad" name="calidad" required>
                            <option value="">Seleccione la calidad</option>
                            <option value="bueno">Bueno</option>
                            <option value="regular">Regular</option>
                            <option value="malo">Malo</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kilos" class="form-label">Kilos *</label>
                        <input type="number" class="form-control" id="kilos" name="kilos" 
                               step="0.01" min="0" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Precios por Calidad:</label>
                        <div class="row">
                            <?php foreach ($precios as $precio): ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-capitalize"><?php echo $precio['calidad']; ?></h6>
                                            <p class="card-text">$<?php echo number_format($precio['precio_kg'], 2); ?>/kg</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Registrar Recolección</button>
                        <button type="reset" class="btn btn-secondary">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'vistas/layout/footer.php'; ?>
