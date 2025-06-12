document.addEventListener('DOMContentLoaded', function() {
	// Manejar los dropdowns anidados
	var dropdownElements = document.querySelectorAll('.dropdown-submenu');
	
	dropdownElements.forEach(function(el) {
		el.addEventListener('click', function(e) {
			e.stopPropagation();
			var submenu = this.querySelector('.dropdown-menu');
			submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
		});
	});
	
	// Cerrar los submenús cuando se hace clic fuera
	document.addEventListener('click', function() {
		dropdownElements.forEach(function(el) {
			el.querySelector('.dropdown-menu').style.display = 'none';
		});
	});
});