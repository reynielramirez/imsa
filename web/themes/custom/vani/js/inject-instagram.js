(function ($, Drupal) {
  'use strict';

  Drupal.behaviors.injectInstagramIcon = {
    attach: function (context, settings) {
      // Solo ejecutar una vez
      const container = document.querySelector('.social-share-btns');
      
      // Verificar si ya existe el botón de Instagram
      if (!container || container.querySelector('.social-link-instagram')) {
        return;
      }

      // Obtener datos de la página
      const entityUrl = container.getAttribute('data-entity_url') || window.location.href;
      const entityTitle = container.getAttribute('data-entity_title') || document.title;

      // Crear el botón de Instagram
      const instagramLink = document.createElement('a');
      instagramLink.className = 'social-link social-link-instagram';
      instagramLink.setAttribute('rel', 'nofollow');
      instagramLink.setAttribute('title', 'Instagram');
      instagramLink.setAttribute('alt', 'Instagram');
      instagramLink.setAttribute('href', 'javascript:void(0)');
      instagramLink.setAttribute('data-once', 'social-link-click');
      
      // Configurar el link (Instagram no tiene API de share, se puede usar para seguir)
      instagramLink.setAttribute('data-link', `https://www.instagram.com/?url=${encodeURIComponent(entityUrl)}`);

      // Crear el span del SVG
      const svgSpan = document.createElement('span');
      svgSpan.className = 'better-social-share-svg';
      svgSpan.style.cssText = 'width:32px;height:32px;';
      svgSpan.setAttribute('title', 'Instagram');

      // SVG de Instagram (estilo consistente con los otros íconos)
      svgSpan.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32">
            <!-- Fondo redondeado -->
            <rect width="32" height="32" rx="5.4" ry="5.4" fill="url(#gradient)"/>
            
            <!-- Borde interior -->
            <rect x="4.5" y="4.5" width="23" height="23" rx="3.6" ry="3.6" fill="none" stroke="white" stroke-width="1.8"/>
            
            <!-- Círculo de la cámara -->
            <circle cx="16" cy="16" r="5.9" fill="none" stroke="white" stroke-width="1.8"/>
            
            <!-- Flash (punto pequeño) -->
            <circle cx="23.3" cy="8.6" r="1.2" fill="white"/>
            
            <!-- Centro -->
            <circle cx="16" cy="16" r="3.1" fill="white"/>
            
            <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#feda77"/>
                <stop offset="22%" stop-color="#f58529"/>
                <stop offset="48%" stop-color="#dd2a7b"/>
                <stop offset="78%" stop-color="#8134af"/>
                <stop offset="100%" stop-color="#515bd4"/>
                </linearGradient>
            </defs>
            </svg>`;

      // Crear el span del texto
      const labelSpan = document.createElement('span');
      labelSpan.className = 'social-media-share-label';
      labelSpan.textContent = 'Instagram';

      // Ensamblar el botón
      instagramLink.appendChild(svgSpan);
      instagramLink.appendChild(labelSpan);

      // Insertar antes del botón "Más"
      const moreButton = container.querySelector('.social-link-more');
      if (moreButton) {
        container.insertBefore(instagramLink, moreButton);
      } else {
        container.appendChild(instagramLink);
      }

      // Agregar evento click (simular comportamiento de los otros botones)
      instagramLink.addEventListener('click', function(e) {
        e.preventDefault();
        // Abrir Instagram en nueva ventana (o lo que necesites)
        window.open('https://www.instagram.com/', '_blank');
        
        // Si quieres disparar el mismo sistema de tracking de Better Social Share
        if (Drupal && Drupal.behaviors && Drupal.behaviors.betterSocialShare) {
          // Esto intentará usar el mismo sistema de los otros botones
          $(this).trigger('social-link-click');
        }
      });

      // Opcional: Agregar color de fondo de Instagram al hover
      const style = document.createElement('style');
      style.textContent = `
        .social-link-instagram:hover {
          background-color: #E4405F;
          transition: background-color 0.3s ease;
        }
      `;
      document.head.appendChild(style);
    }
  };

})(jQuery, Drupal);