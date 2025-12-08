function mostrarSeccion(id) {
    const secciones = [
        "Psicologo-PaginaPrincipal",
        "Psicologo-ListadoUsuarios",
        "Psicologo-Historial",
        "Psicologo-Calendario",
        "Psicologo-CrearTest",
        "chat-bot",
        "Chat",
        "Psicologo-Configuracion",
        "Aprendiz-PaginaPrincipal",
        "Aprendiz-AgendarCita",
        "Aprendiz-Seguimiento",
        "Aprendiz-Calendario",
        "AprendizTest",
        "Aprendiz-Configuracion"
    ];

    // Recorre TODAS las secciones para decidir si ocultarlas o mostrarlas
    secciones.forEach(secId => {
        const elemento = document.getElementById(secId);
        
        if (elemento) {
            // Usa "block" para mostrar, "none" para ocultar
            elemento.style.display = (secId === id) ? "block" : "none";
        }
    });
}


function mostrarChat() {
    // 🛑 CLAVE: Incluir TODOS los IDs de todas las secciones, incluido el ID del chat.
    const todosLosIDs = [
        "Psicologo-PaginaPrincipal",
        "Psicologo-ListadoUsuarios",
        "Psicologo-Historial",
        "Psicologo-Calendario",
        "Psicologo-CrearTest",
        "chat-bot",
        "Chat",
        "Psicologo-Configuracion",
        "Aprendiz-PaginaPrincipal",
        "Aprendiz-AgendarCita",
        "Aprendiz-Seguimiento",
        "Aprendiz-Calendario",
        "AprendizTest",
        "Aprendiz-Configuracion"
    ];

    const idChat = "Chat";

    // Recorre TODAS las secciones
    todosLosIDs.forEach(secId => {
        const elemento = document.getElementById(secId);
        
        if (elemento) {
            if (secId === idChat) {
                // Si es el chat, usamos "" para respetar el estilo CSS (ej: flex)
                elemento.style.display = ""; 
            } else {
                // Si no es el chat, lo ocultamos
                elemento.style.display = "none";
            }
        }
    });
}