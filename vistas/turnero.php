<!DOCTYPE html>
<html>
<head>
    <title>Sistema de turnos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de turnos</h1>
        <h2>Tomar turno</h2>
        <form action="tomar_turno.php" method="POST">
            <!-- Campos del formulario -->
            <button type="submit" class="btn btn-primary">Tomar turno</button>
        </form>

        <h2>Ver mis turnos</h2>
        <a href="mis_turnos.php" class="btn btn-primary">Ver mis turnos</a>

        <h2>Ver agenda del médico</h2>
        <a href="agenda_medico.php" class="btn btn-primary">Ver agenda del médico</a>

        <h2>Ver historial de pacientes</h2>
        <a href="historial_pacientes.php" class="btn btn-primary">Ver historial de pacientes</a>
    </div>
</body>
</html>
