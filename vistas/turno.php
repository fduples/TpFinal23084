<!DOCTYPE html>
<html>
<head>
    <title>Sistema de turnos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de turnos</h1>
        <form action="guardar_turno.php" method="POST">
            <div class="form-group">
                <label for="documento">Documento:</label>
                <input type="text" class="form-control" id="documento" name="documento" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="medico">Médico:</label>
                <select class="form-control" id="medico" name="medico" required>
                    <?php
                    // Obtener la lista de médicos
                    $sql = "SELECT id_med, nombre FROM medicos";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_med'] . '">' . $row['nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="hora">Hora:</label>
                <input type="time" class="form-control" id="hora" name="hora" required>
            </div>
            <div class="form-group">
                <label for="tiempo">Duración (minutos):</label>
                <input type="number" class="form-control" id="tiempo" name="tiempo" min="15" step="15" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar turno</button>
        </form>
    </div>
</body>
</html>
