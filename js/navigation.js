/**
 * navigation.js — versão otimizada
 *
 * Melhora:
 * - performance
 * - acessibilidade (ARIA + foco)
 * - organização
 * - robustez (sem uso de event global)
 * - suporte mobile/tablet
 */

(() => {

	const nav = document.getElementById('site-navigation');
	if (!nav) return;

	const button = nav.querySelector('button[aria-controls]');
	const menu = nav.querySelector('ul');

	// Se menu ou botão não existem, interrompe.
	if (!button || !menu) return;

	// Garante classe de navegação
	menu.classList.add('nav-menu');

	// 🔹 Toggle do menu mobile
	button.addEventListener('click', () => {
		const expanded = button.getAttribute('aria-expanded') === 'true';
		button.setAttribute('aria-expanded', String(!expanded));
		nav.classList.toggle('toggled');
	});

	// 🔹 Fecha menu ao clicar fora
	document.addEventListener('click', e => {
		if (!nav.contains(e.target)) {
			nav.classList.remove('toggled');
			button.setAttribute('aria-expanded', 'false');
		}
	});

	// 🔹 Acessibilidade para dropdowns
	const itemsWithChildren = nav.querySelectorAll(
		'.menu-item-has-children, .page_item_has_children'
	);

	itemsWithChildren.forEach(item => {
		const link = item.querySelector('a');
		const sub = item.querySelector('ul');

		if (!link || !sub) return;

		// Adiciona ARIA para leitores de tela
		link.setAttribute('aria-haspopup', 'true');
		link.setAttribute('aria-expanded', 'false');

		// Clique ou toque abre dropdown
		link.addEventListener('click', e => {
			if (window.innerWidth > 992) return; // desktop usa hover do CSS

			e.preventDefault();

			const isOpen = item.classList.toggle('focus');
			link.setAttribute('aria-expanded', String(isOpen));

			// Fecha outros abertos
			itemsWithChildren.forEach(other => {
				if (other !== item) {
					other.classList.remove('focus');
					const otherLink = other.querySelector('a');
					if (otherLink) {
						otherLink.setAttribute('aria-expanded', 'false');
					}
				}
			});
		});

		// Foco via teclado (TAB)
		link.addEventListener('focus', () => {
			item.classList.add('focus');
			link.setAttribute('aria-expanded', 'true');
		});

		link.addEventListener('blur', () => {
			item.classList.remove('focus');
			link.setAttribute('aria-expanded', 'false');
		});
	});

})();
