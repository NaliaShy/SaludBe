document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.slide');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    const dotsContainer = document.querySelector('.dots-container');
    const container = document.querySelector(".carousel-container");
    let currentSlide = 0;
    let autoPlayInterval;

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
        container.style.backgroundImage = `url('${slides[currentSlide].src}')`;
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

    container.style.backgroundImage = `url('${slides[0].src}')`;
    startAutoPlay();
});
