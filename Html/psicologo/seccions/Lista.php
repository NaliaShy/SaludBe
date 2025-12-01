<div id="Psicologo-ListadoUsuarios" style="display: none;">
    <h2 id="listaAprendizTitulo">Lista de Aprendiz</h2>

    <form method="GET">
        <div class="search-bar">
            <span class="icon">🔍</span>
            <input type="text" placeholder="Buscar aprendiz..." name="search_term"
                value="<?php echo htmlspecialchars($_GET['search_term'] ?? ''); ?>">

            <button type="submit">Buscar</button>

            <button type="button">Filtro</button>
            <button type="button">Fecha</button>
        </div>
    </form>

    <?php
    // --- CORRECCIÓN DE VARIABLES DE CONEXIÓN ---
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Asumiendo que la clase Conexion ya está incluida (require/include)
    $conexionObj = new Conexion();
    $conn = $conexionObj->getConnect(); // ⬅️ CAMBIADO: Usando $conn para consistencia

    // 1. Verificar si el ID está en la sesión
    if (!isset($_SESSION['us_id'])) {
        // En un entorno real, redirigirías al login en lugar de morir.
        // die("No hay usuario en sesión.");
    }
    $usuario_id = $_SESSION['us_id'] ?? null;


    // 1. Obtener el término de búsqueda de manera segura
    $searchTerm = $_GET['search_term'] ?? '';
    $searchParam = '%' . $searchTerm . '%';

    // 2. Definir el ID del Rol para Aprendiz
    $rol_aprendiz = 1;

    // 3. Consulta SQL con el filtro de rol y búsqueda agrupada
    $sql = "SELECT Us_id, Us_nombre, Us_apellios 
        FROM usuarios 
        WHERE (Us_nombre LIKE :search OR Us_apellios LIKE :search)
        AND Rol_id = :rol_id";

    // 4. Preparación y ejecución de la consulta PDO
    $stmt = $conn->prepare($sql); // ⬅️ CORREGIDO: Ahora usa $conn (Objeto PDO)
    $stmt->bindParam(':search', $searchParam);
    $stmt->bindParam(':rol_id', $rol_aprendiz, PDO::PARAM_INT);
    $stmt->execute();
    $aprendices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <div class="aprendiz-container">

        <?php if (!empty($aprendices)): ?>
            <div class="aprendices-grid">
                <?php foreach ($aprendices as $aprendiz): ?>
                    <div class="aprendiz-card" onclick="openModal('<?= htmlspecialchars($aprendiz['Us_id']) ?>')">
                        <h3><?= htmlspecialchars($aprendiz['Us_nombre']) ?></h3>
                        <p><?= htmlspecialchars($aprendiz['Us_apellios']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No hay aprendices registrados que coincidan con la búsqueda 😢</p>
        <?php endif; ?>
    </div>

    <?php
    if (isset($conn)) {
        $conn = null;
    }
    ?>
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">×</span>
            <div id="modal-body-content">
                <center>
                    <div class="loading-spinner"></div>
                    <p>Cargando información del aprendiz...</p>
                </center>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../js/Lista.js"></script>