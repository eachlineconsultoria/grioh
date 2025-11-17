/* global wp */
/**
 * customizer.js — versão otimizada
 *
 * Atualiza elementos no preview do Customizer em tempo real
 * usando apenas JavaScript moderno (sem jQuery).
 */

(function () {

	/**
	 * Helper para atualizar texto de seletores
	 */
	function updateText(selector, value) {
		document.querySelectorAll(selector).forEach(el => {
			el.textContent = value;
		});
	}

	/**
	 * Helper para aplicar estilos
	 */
	function updateStyle(selector, styles) {
		document.querySelectorAll(selector).forEach(el => {
			Object.assign(el.style, styles);
		});
	}

	// 1) Nome do site
	wp.customize('blogname', value => {
		value.bind(to => updateText('.site-title a', to));
	});

	// 2) Descrição / tagline
	wp.customize('blogdescription', value => {
		value.bind(to => updateText('.site-description', to));
	});

	// 3) Cor do texto do cabeçalho
	wp.customize('header_textcolor', value => {
		value.bind(to => {

			// Oculto
			if (to === 'blank') {
				updateStyle('.site-title, .site-description', {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute'
				});
				return;
			}

			// Visível
			updateStyle('.site-title, .site-description', {
				clip: 'auto',
				position: 'relative'
			});

			updateStyle('.site-title a, .site-description', {
				color: to
			});
		});
	});

})();
