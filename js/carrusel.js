document.addEventListener('DOMContentLoaded', () => {

    // Cargar imágenes desde la BD
    fetch("../../Php/obtener_carrusel.php")
        .then(r => r.json())
        .then(data => {

            const slidesContainer = document.getElementById("slides-container");

            data.forEach(item => {
                const div = document.createElement("div");
                div.classList.add("slide");
                div.style.backgroundImage = `url('${item.imagen_url}')`;
                slidesContainer.appendChild(div);
            });

            iniciarCarrusel(); // Llama a tu carrusel original
        })
        .catch(e => console.error("Error cargando carrusel:", e));
});


function iniciarCarrusel() {
    const slides = document.querySelectorAll('.slide');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    const dotsContainer = document.querySelector('.dots-container');
    const container = document.querySelector(".carousel-container");
    let currentSlide = 0;
    let autoPlayInterval;

    if (slides.length === 0) return;

    // Crear puntos
    slides.forEach((_, i) => {
        const dot = document.createElement("div");
        dot.classList.add("dot");
        if (i === 0) dot.classList.add("active");
        dot.addEventListener("click", () => {
            goToSlide(i);
            resetAutoPlay();
        });
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.dot');

    function updateSlides() {
        slides.forEach(s => s.classList.remove("active"));
        dots.forEach(d => d.classList.remove("active"));

        slides[currentSlide].classList.add("active");
        dots[currentSlide].classList.add("active");

        // Fondo blur igual a la imagen actual
        container.style.backgroundImage =
            slides[currentSlide].style.backgroundImage;
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlides();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlides();
    }

    function goToSlide(i) {
        currentSlide = i;
        updateSlides();
    }

    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 5000);
    }

    function resetAutoPlay() {
        clearInterval(autoPlayInterval);
        startAutoPlay();
    }

    prevButton.addEventListener("click", () => {
        prevSlide();
        resetAutoPlay();
    });

    nextButton.addEventListener("click", () => {
        nextSlide();
        resetAutoPlay();
    });

    updateSlides();
    startAutoPlay();
}
