document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('#liveSearch');
    const cards = document.querySelectorAll('[data-attraction-card]');

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase().trim();

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.closest('.attraction-column').style.display =
                    text.includes(term) ? '' : 'none';
            });
        });
    }

    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', event => {
            if (!confirm(el.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });
});
