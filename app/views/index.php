<?php
    include_once __DIR__ . '/layouts/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Registro de Labores</h2>

    <!-- Formulario -->
    <form id="laborForm"
          action="<?php echo isset($registroEdit) ? '/update' : '/store'; ?>"
          method="<?php echo isset($registroEdit) ? 'PUT' : 'POST'; ?>"
          class="mb-4"
    >
        <?php if ($registroEdit): ?>
            <input type="hidden" name="id" value="<?= $registroEdit['id'] ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label for="labor_id" class="form-label">Labor realizada</label>
            <select name="labor_id" id="labor_id" class="form-select" required>
                <?php foreach ($labores as $labor): ?>
                    <option value="<?= $labor['id'] ?>" <?= isset($registroEdit) && $registroEdit['labor_id'] == $labor['id'] ? 'selected' : '' ?>>
                        <?= $labor['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control flatpickr" value="<?= $registroEdit['fecha'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" step="0.01" name="cantidad" id="cantidad" class="form-control" value="<?= $registroEdit['cantidad'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="tarifa" class="form-label">Tarifa</label>
            <input type="number" step="0.01" name="tarifa" id="tarifa" class="form-control" value="<?= $registroEdit['tarifa'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="empleado" class="form-label">Empleado</label>
            <input type="text" name="empleado" id="empleado" class="form-control" value="<?= $registroEdit['empleado'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="lote_id" class="form-label">Lote</label>
            <select name="lote_id" id="lote_id" class="form-select" required>
                <?php foreach ($lotes as $lote): ?>
                    <option value="<?= $lote['id'] ?>" <?= isset($registroEdit) && $registroEdit['lote_id'] == $lote['id'] ? 'selected' : '' ?>>
                        <?= $lote['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn <?= $registroEdit ? 'btn-primary' : 'btn-success' ?>">
            <?= $registroEdit ? 'Actualizar' : 'Registrar' ?>
        </button>
    </form>

    <!-- Lista de Registros -->
    <h3>Lista de Registros</h3>

    <!-- Campo de Búsqueda -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por empleado, labor o lote...">
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Labor</th>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Tarifa</th>
            <th>Empleado</th>
            <th>Lote</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody id="registrosTableBody">
        <?php foreach ($registros as $registro): ?>
            <tr>
                <td><?= $registro['labor'] ?></td>
                <td><?= $registro['fecha'] ?></td>
                <td><?= $registro['cantidad'] ?></td>
                <td><?= $registro['tarifa'] ?></td>
                <td><?= $registro['empleado'] ?></td>
                <td><?= $registro['lote'] ?></td>
                <td>
                    <a href="/prueba_gremca/?edit=<?= $registro['id'] ?>" class="btn btn-warning btn-sm">Actualizar</a>
                    <a href="/delete/<?= $registro['id'] ?>" class="btn btn-danger btn-sm btn-delete">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
    include_once __DIR__ . '/layouts/footer.php';
?>