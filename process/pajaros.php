<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pájaros</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        audio {
            width: 200px;
        }
    </style>
</head>
<body>
    <h1>Lista de Pájaros</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Nombre Científico</th>
            <th>Grupo</th>
            <th>Imagen</th>
            <th>Cómo Identificar</th>
            <th>Canto</th>
        </tr>
        <?php foreach ($pajaros as $pajaro): ?>
            <tr>
                <td><?php echo $pajaro['id_pajaro']; ?></td>
                <td><?php echo $pajaro['nombre']; ?></td>
                <td><i><?php echo $pajaro['nombre_cientifico']; ?></i></td>
                <td><?php echo $pajaro['grupo'] ?: 'N/A'; ?></td>
                <td>
                    <?php if (!empty($pajaro['imagen'])): ?>
                        <img src="<?php echo $pajaro['imagen']; ?>" alt="Imagen de <?php echo $pajaro['nombre']; ?>">
                    <?php else: ?>
                        Sin imagen
                    <?php endif; ?>
                </td>
                <td><?php echo nl2br($pajaro['como_identificar']); ?></td>
                <td>
                    <?php if (!empty($pajaro['canto_audio'])): ?>
                        <audio controls>
                            <source src="<?php echo $pajaro['canto_audio']; ?>" type="audio/mpeg">
                            Tu navegador no soporta el elemento de audio.
                        </audio>
                    <?php else: ?>
                        Sin audio
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
