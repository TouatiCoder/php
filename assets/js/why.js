// assets/js/why.js
document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('.why-section');
    if (!section) return;

    // Move section before footer when footer is available
    const moveSection = () => {
        const footer = document.querySelector('footer');
        if (footer && section.parentNode !== footer.parentNode) {
            footer.parentNode.insertBefore(section, footer);
            return true;
        }
        return false;
    };

    if (!moveSection()) {
        const observer = new MutationObserver((mutations, obs) => {
            if (moveSection()) {
                obs.disconnect();
            }
        });
        const app = document.getElementById('app');
        if (app) {
            observer.observe(app, { childList: true, subtree: true });
        } else {
            observer.observe(document.body, { childList: true, subtree: true });
        }
    }

    const slides = document.querySelectorAll('.why-carousel-slide');
    const dots = document.querySelectorAll('.why-carousel-pagination .why-dot');
    const prevBtn = document.querySelector('.why-carousel-btn.why-prev-btn');
    const nextBtn = document.querySelector('.why-carousel-btn.why-next-btn');
    const wrapper = document.querySelector('.why-carousel-wrapper');

    if (!slides.length) return;

    let currentIndex = 0;
    const totalSlides = slides.length;
    let autoplayInterval;

    function updateCarousel() {
        slides.forEach(slide => {
            slide.classList.remove('active', 'prev', 'next', 'prev-2', 'next-2');
        });
        dots.forEach(dot => dot.classList.remove('active'));

        const prevIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        const nextIndex = (currentIndex + 1) % totalSlides;
        const prev2Index = (currentIndex - 2 + totalSlides) % totalSlides;
        const next2Index = (currentIndex + 2) % totalSlides;

        slides[currentIndex].classList.add('active');
        
        if (totalSlides > 1) {
            slides[prevIndex].classList.add('prev');
            slides[nextIndex].classList.add('next');
        }
        if (totalSlides > 3) {
            slides[prev2Index].classList.add('prev-2');
            slides[next2Index].classList.add('next-2');
        }
        if (dots[currentIndex]) {
            dots[currentIndex].classList.add('active');
        }
    }

    function goToNext() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateCarousel();
    }

    function goToPrev() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }

    function startAutoplay() {
        stopAutoplay();
        autoplayInterval = setInterval(goToNext, 4000);
    }

    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            goToPrev();
            startAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            goToNext();
            startAutoplay();
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
            startAutoplay();
        });
    });

    if (wrapper) {
        wrapper.addEventListener('mouseenter', stopAutoplay);
        wrapper.addEventListener('mouseleave', startAutoplay);

        // Touch support
        let touchStartX = 0;
        let touchEndX = 0;

        wrapper.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
            stopAutoplay();
        }, {passive: true});

        wrapper.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startAutoplay();
        }, {passive: true});

        function handleSwipe() {
            const threshold = 50;
            if (touchEndX < touchStartX - threshold) {
                goToNext();
            }
            if (touchEndX > touchStartX + threshold) {
                goToPrev();
            }
        }
    }

    // Init
    updateCarousel();
    startAutoplay();
});