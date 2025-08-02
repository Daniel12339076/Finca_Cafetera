<?php include 'vistas/layout/header.php'; ?>

<h1>Reportes de Recolección</h1>

<div class="card mb-4">
    <div class="card-header">
        <h5>Filtros de Búsqueda</h5>
    </div>
    <div class="card-body">
        <form id="formFiltros">
            <div class="row">
                <div class="col-md-3">
                    <label for="trabajador_filtro" class="form-label">Trabajador</label>
                    <select class="form-select" id="trabajador_filtro" name="trabajador_id">
                        <option value="">Todos los trabajadores</option>
                        <?php foreach ($trabajadores as $trabajador): ?>
                            <option value="<?php echo $trabajador['id']; ?>">
                                <?php echo htmlspecialchars($trabajador['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                </div>
                <div class="col-md-3">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="button" class="btn btn-primary" onclick="cargarReporte()">Buscar</button>
                        <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">Limpiar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Resultados</h5>
    </div>
    <div class="card-body">
        <div id="loading" class="text-center" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped" id="tablaReporte">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Trabajador</th>
                        <th>Calidad</th>
                        <th>Kilos</th>
                        <th>Valor Pagado</th>
                    </tr>
                </thead>
                <tbody id="cuerpoTabla">
                    <!-- Los datos se cargarán aquí -->
                </tbody>
                <tfoot id="pieTabla" style="display: none;">
                    <tr class="table-info">
                        <th colspan="3">TOTALES</th>
                        <th id="totalKilos">0</th>
                        <th id="totalValor">$0</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php include 'vistas/layout/footer.php'; ?>
