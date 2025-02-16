    console.log('This log comes from calc');
    document.addEventListener('DOMContentLoaded', () => {
        // Sélectionner tous les conteneurs de groupes de taux
        const tauxGroups = document.querySelectorAll('[data-taux-group]');

        // Parcourir chaque groupe
        tauxGroups.forEach(group => {
            const priceHTField = group.querySelector('[data-price-ht]');
            const tauxFields = group.querySelectorAll('[data-taux] input[type="radio"]'); // Tous les boutons radio
            const priceTTCField = group.querySelector('[data-price-ttc]');
        
            if (priceHTField && tauxFields.length > 0 && priceTTCField) {
                const calculatePriceTTC = () => {
                    const priceHT = parseFloat(priceHTField.value) || 0;
                    let taux = 0;

                    // Récupérer la valeur du bouton radio sélectionné
                    const selectedTaux = group.querySelector('[data-taux] input[type="radio"]:checked');
                    if (selectedTaux) {
                        taux = parseFloat(selectedTaux.getAttribute('data-taux-value')) || 0;
                    }
        
                    // Calculer le prix TTC
                    const priceTTC = priceHT + ((priceHT * taux) / 100);
                    priceTTCField.value = priceTTC.toFixed(2); // Arrondi à 2 décimales
                };

                // Écouter les changements sur les champs PriceHT et Taux
                priceHTField.addEventListener('input', calculatePriceTTC);
                tauxFields.forEach(radio => {
                    radio.addEventListener('change', calculatePriceTTC); // Écouter les changements
            });        
        }
    });
});