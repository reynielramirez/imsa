document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('imageModal');
  
  // Si el modal no existe en esta página, no ejecutamos nada más
  if (!modal) {
    return;
  }

  const closeBtn = document.querySelector('.modal-carousel-close');
  const prevBtn = document.querySelector('.carousel-prev');
  const nextBtn = document.querySelector('.carousel-next');
  const slidesContainer = document.querySelector('.carousel-slides');
  const slides = document.querySelectorAll('.carousel-slide');
  const indicators = document.querySelectorAll('.indicator-dot');
  const currentSlideSpan = document.querySelector('.current-slide');
  const galleryThumbs = document.querySelectorAll('.gallery-thumb');
  
  let currentIndex = 0;
  let totalSlides = slides.length;
  
  // Si no hay slides, no tiene sentido continuar
  if (totalSlides === 0) {
    return;
  }
  
  // Función para actualizar el carrusel
  function updateCarousel(index) {
    // (el mismo código que tenías, sin cambios)
    if (index < 0) {
      index = totalSlides - 1;
    } else if (index >= totalSlides) {
      index = 0;
    }
    
    currentIndex = index;
    
    const offset = -currentIndex * 100;
    slidesContainer.style.transform = `translateX(${offset}%)`;
    
    indicators.forEach((indicator, i) => {
      if (i === currentIndex) {
        indicator.classList.add('active');
      } else {
        indicator.classList.remove('active');
      }
    });
    
    if (currentSlideSpan) {
      currentSlideSpan.textContent = currentIndex + 1;
    }
    
    const currentSlide = slides[currentIndex];
    const currentImg = currentSlide.querySelector('.carousel-image');
    if (currentImg) {
      currentImg.style.animation = 'none';
      setTimeout(() => {
        currentImg.style.animation = 'zoomIn 0.3s ease';
      }, 10);
    }
  }
  
  function nextSlide() {
    updateCarousel(currentIndex + 1);
  }
  
  function prevSlide() {
    updateCarousel(currentIndex - 1);
  }
  
  function openModal(startIndex) {
    currentIndex = startIndex;
    updateCarousel(currentIndex);
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    modal.addEventListener('touchmove', preventScroll, { passive: false });
  }
  
  function closeModal() {
    modal.classList.remove('show');
    document.body.style.overflow = '';
    modal.removeEventListener('touchmove', preventScroll);
  }
  
  function preventScroll(e) {
    e.preventDefault();
  }
  
  // Event listeners para miniaturas (solo si existen)
  galleryThumbs.forEach((thumb, index) => {
    thumb.addEventListener('click', function() {
      openModal(index);
    });
  });
  
  // ----- VERIFICACIONES DE SEGURIDAD -----
  if (nextBtn) {
    nextBtn.addEventListener('click', nextSlide);
  } else {
    console.warn('Elemento .carousel-next no encontrado');
  }
  
  if (prevBtn) {
    prevBtn.addEventListener('click', prevSlide);
  } else {
    console.warn('Elemento .carousel-prev no encontrado');
  }
  
  if (closeBtn) {
    closeBtn.addEventListener('click', closeModal);
  } else {
    console.warn('Elemento .modal-carousel-close no encontrado');
  }
  
  const overlay = modal.querySelector('.modal-carousel-overlay');
  if (overlay) {
    overlay.addEventListener('click', closeModal);
  }
  
  // Cerrar con tecla ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.classList.contains('show')) {
      closeModal();
    }
    if (modal.classList.contains('show')) {
      if (e.key === 'ArrowLeft') {
        prevSlide();
      } else if (e.key === 'ArrowRight') {
        nextSlide();
      }
    }
  });
  
  // Indicadores
  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
      updateCarousel(index);
    });
  });
  
  // Swipe
  let touchStartX = 0;
  let touchEndX = 0;
  const carouselContainer = document.querySelector('.carousel-container');
  if (carouselContainer) {
    carouselContainer.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    });
    carouselContainer.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    });
  }
  
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchEndX - touchStartX;
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        prevSlide();
      } else {
        nextSlide();
      }
    }
  }
  
  const modalContent = modal.querySelector('.modal-carousel-content');
  if (modalContent) {
    modalContent.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }
});