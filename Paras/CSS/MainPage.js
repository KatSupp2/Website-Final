// Nav
const hamburger = document.getElementById('hamburger');
const navLinks = document.querySelector('.nav-links');

if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// Header
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('.carousel');
    const carouselItems = document.querySelectorAll('.carousel-item');
    let currentIndex = 0;

    function showCarousel() {
        const offset = 50;
        const itemWidth = carouselItems[0].offsetWidth;
        const containerWidth = carousel.offsetWidth;

        const totalWidth = itemWidth * carouselItems.length;
        const activeOffset = (containerWidth / 2) - (itemWidth / 2);
        const translateX = activeOffset - (itemWidth * currentIndex);

        carousel.style.transform = `translateX(${translateX}px)`;

        carouselItems.forEach((item, index) => {
            item.classList.remove('active');
            if (index === currentIndex) {
                item.classList.add('active');
            }
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % carouselItems.length;
        showCarousel();
    }

    if (carouselItems.length > 0) {
        setInterval(nextSlide, 3000);
    }

    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const captionText = document.getElementById('caption');
    const closeModal = document.getElementsByClassName('close')[0];

    if (modal && modalImg && closeModal) {
        carouselItems.forEach(item => {
            item.addEventListener('click', function () {
                modal.style.display = 'block';
                modalImg.src = this.querySelector('img').src;
                captionText.innerHTML = this.querySelector('img').alt;
            });
        });

        closeModal.onclick = function () {
            modal.style.display = 'none';
        };

        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    }

    showCarousel();
});