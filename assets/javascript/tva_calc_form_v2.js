document.addEventListener('DOMContentLoaded', () => {
    // Utiliser MutationObserver pour observer les changements dans le DOM
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            mutation.addedNodes.forEach(node => {
                // Vérifier si le nœud ajouté est un élément du formulaire
                if (node instanceof Element && node.matches('[data-taux-group]')) {
                    // Un nouveau groupe a été ajouté, appliquer la logique
                    handleTauxGroup(node);
                }
            });
        });
    });

    // Configurer l'observateur pour surveiller les ajouts de nœuds
    observer.observe(document.querySelector('form'), { childList: true, subtree: true });

    // Fonction pour gérer la logique d'un groupe de taux
    function handleTauxGroup(group) {
        const priceHTField = group.querySelector('[data-price-ht]');
        const tauxFields = group.querySelectorAll('[data-taux] input[type="radio"]');
        const priceTTCField = group.querySelector('[data-price-ttc]');

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

            // Calcul initial
            calculatePriceTTC();

            priceHTField.addEventListener('input', calculatePriceTTC);
            tauxFields.forEach(radio => {
                radio.addEventListener('change', calculatePriceTTC);
            });
        }
    }

    // Gérer les groupes déjà présents au chargement de la page
    const initialTauxGroups = document.querySelectorAll('[data-taux-group]');
    initialTauxGroups.forEach(handleTauxGroup);
});
