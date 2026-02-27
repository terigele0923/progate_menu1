	
		(function () {
			const categorySelect = document.querySelector('select[name="category"]');
			if (!categorySelect) {
				return;
			}

			const typeField = document.querySelector('[data-field="type"]');
			const typeInput = typeField ? typeField.querySelector('input[name="type"]') : null;
			const spicinessField = document.querySelector('[data-field="spiciness"]');
			const spicinessInput = spicinessField ? spicinessField.querySelector('input[name="spiciness"]') : null;

			const applyVisibility = () => {
				const isDrink = categorySelect.value === 'drink';

				if (typeField) {
					typeField.style.display = isDrink ? '' : 'none';
				}
				if (spicinessField) {
					spicinessField.style.display = isDrink ? 'none' : '';
				}
				if (typeInput) {
					typeInput.disabled = !isDrink;
				}
				if (spicinessInput) {
					spicinessInput.disabled = isDrink;
				}
			};

			categorySelect.addEventListener('change', applyVisibility);
			applyVisibility();
		})();