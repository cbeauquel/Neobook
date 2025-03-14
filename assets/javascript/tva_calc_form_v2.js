console.log('This log comes from calc'); // Vérification de chargement

function initTVACalculator() {
    // console.log("Initialisation du calcul TVA...");

    const tauxGroups = document.querySelectorAll('[data-taux-group]');
    // if (!tauxGroups.length) {
    //     console.warn("Aucun groupe de TVA trouvé !");
    //     return;
    // }

    tauxGroups.forEach(group => {
        const priceHTField = group.querySelector('[data-price-ht]');
        const tauxFields = group.querySelectorAll('[data-taux] input[type="radio"]');
        const priceTTCField = group.querySelector('[data-price-ttc]');

        // console.log("Vérification des champs:", priceHTField, priceTTCField, tauxFields);

        if (priceHTField && tauxFields.length > 0 && priceTTCField) {
            const calculatePriceTTC = () => {
                const priceHT = parseFloat(priceHTField.value) || 0;
                let taux = 0;

                const selectedTaux = group.querySelector('[data-taux] input[type="radio"]:checked');
                if (selectedTaux) {
                    taux = parseFloat(selectedTaux.getAttribute('data-taux-value')) || 0;
                }

                const priceTTC = priceHT + ((priceHT * taux) / 100);
                priceTTCField.value = priceTTC.toFixed(2);
            };

            priceHTField.addEventListener('input', calculatePriceTTC);
            tauxFields.forEach(radio => radio.addEventListener('change', calculatePriceTTC));

            // **Forçage du calcul après un petit délai si nécessaire**
            setTimeout(calculatePriceTTC, 500);
        }
    });
}

// Exécuter au chargement normal et avec Turbo / Stimulus
document.addEventListener('DOMContentLoaded', initTVACalculator);
document.addEventListener('turbo:load', initTVACalculator);
document.addEventListener('stimulus:connect', initTVACalculator);