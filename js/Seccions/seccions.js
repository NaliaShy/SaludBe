function mostrarSeccion(id) {
    const secciones = [
        "Psicologo-PaginaPrincipal",
        "Psicologo-ListadoUsuarios",
        "Psicologo-Historial",
        "Psicologo-Calendario",
        "Chat",
        "Psicologo-CrearTest",
        "chat-bot"
    ];

    // Recorre TODAS las secciones para decidir si ocultarlas o mostrarlas
    secciones.forEach(secId => {
        const elemento = document.getElementById(secId);
        
        if (elemento) {
            // Si el ID de la sección actual (secId) es igual al ID que se pasó (id),
            // lo mostramos ("block" o "flex"). Si no, lo ocultamos ("none").
            elemento.style.display = (secId === id) ? "block" : "none";
        }
    });
}

