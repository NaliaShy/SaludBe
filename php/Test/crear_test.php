<?php
// Acepta el nombre del test por URL como `test` o `tipo`
if (isset($_GET['test'])) {
    $test = $_GET['test'];
} elseif (isset($_GET['tipo'])) {
    $test = $_GET['tipo'];
} else {
    echo "Error: No se especificó qué test abrir.";
    exit;
}

// Información de cada test
$tests = [
    "ansiedad" => [
        "titulo" => "Test de Ansiedad Social",
        "descripcion" => "Evalúa niveles de ansiedad e incomodidad al interactuar con otras personas."
    ],
    "adiccion" => [
        "titulo" => "Test de Adicción al Internet",
        "descripcion" => "Mide el nivel de uso problemático, dependencia y abuso del internet."
    ],
    "depresion" => [
        "titulo" => "Test de Depresión",
        "descripcion" => "Evalúa indicadores relacionados con síntomas depresivos y estado emocional."
    ],
    "burnout" => [
        "titulo" => "Test de Burnout",
        "descripcion" => "Mide agotamiento físico, mental y emocional relacionado al trabajo."
    ]
];

// Verificar que exista
if (!isset($tests[$test])) {
    echo "Test no encontrado.";
    exit;
}

$data = $tests[$test];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $data['titulo']; ?></title>
    <link rel="stylesheet" href="/Saludbe/Css/Psicologo/crear_test.css">
    <link rel="stylesheet" href="/Saludbe/Css/Repetivos/root.css">
</head>

<body>

    <div class="form-container">
        <h2 class="form-title"><?php echo $data['titulo']; ?></h2>

        <p class="descripcion">
            <?php echo $data['descripcion']; ?>
        </p>

        <form action="guardar_test.php" method="POST">

            <input type="hidden" name="tipo_test" value="<?php echo $test; ?>">

            <label>Nombre del test</label>
            <input type="text" name="nombre" value="<?php echo $data['titulo']; ?>" required>

            <label>Descripción del test</label>
            <textarea name="descripcion" required><?php echo $data['descripcion']; ?></textarea>

            <label>Número de preguntas</label>
            <input id="cantidad" type="number" name="cantidad" min="1" max="100" required>

            <div id="questions-container"></div>

            <p class="nota">Cada pregunta tendrá 4 opciones por defecto (puedes editar las etiquetas).</p>

            <button class="btn-guardar" type="submit">Guardar test</button>
        </form>
    </div>
</body>

<script>
// Genera campos de preguntas según el número indicado
const cantidadInput = document.getElementById('cantidad');
const questionsContainer = document.getElementById('questions-container');

function crearPregunta(index) {
    const wrapper = document.createElement('div');
    wrapper.className = 'pregunta';
    wrapper.innerHTML = `
        <h4>Pregunta ${index+1}</h4>
        <textarea name="questions[${index}][texto]" rows="2" required placeholder="Texto de la pregunta"></textarea>
        <div class="opciones">
            <label>Opción 1: <input type="text" name="questions[${index}][opciones][]" value="Nunca" required></label>
            <label>Opción 2: <input type="text" name="questions[${index}][opciones][]" value="Rara vez" required></label>
            <label>Opción 3: <input type="text" name="questions[${index}][opciones][]" value="A veces" required></label>
            <label>Opción 4: <input type="text" name="questions[${index}][opciones][]" value="Frecuente" required></label>
        </div>
    `;
    return wrapper;
}

function renderQuestions() {
    const cantidad = parseInt(cantidadInput.value) || 0;
    questionsContainer.innerHTML = '';
    for (let i = 0; i < cantidad; i++) {
        questionsContainer.appendChild(crearPregunta(i));
    }
}

cantidadInput.addEventListener('change', renderQuestions);
cantidadInput.addEventListener('input', renderQuestions);

// Si el formulario ya llega con un valor (ej. al recargar), renderiza
document.addEventListener('DOMContentLoaded', () => {
    if (cantidadInput.value) renderQuestions();
});
</script>

</html>
</body>

</html>
