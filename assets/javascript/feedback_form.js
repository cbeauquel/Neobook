console.log('This log comes from feedback'); // Vérification de chargement
document.querySelectorAll('.rating .star').forEach((label, index, labels) => {
    label.addEventListener('mouseenter', () => {
        labels.forEach((l, i) => l.style.color = i >= labels.length - index - 1 ? 'gold' : '#ccc');
    });
    label.addEventListener('mouseleave', () => {
        const checked = document.querySelector('.rating input:checked');
        labels.forEach((l, i) => {
            l.style.color = checked && i >= labels.length - [...labels].indexOf(checked.nextElementSibling) - 1 ? 'gold' : '#ccc';
        });
    });
});
