/**
 * Current Openings: tab click filters cards by category.
 * Uses only maco-openings-* class names.
 */
(function () {
    const section = document.querySelector('.maco-openings');
    if (!section) return;

    const tabs = section.querySelectorAll('.maco-openings-tab');
    const cards = section.querySelectorAll('.maco-openings-card');

    function setActiveTab(activeBtn) {
        tabs.forEach(function (t) {
            t.classList.remove('maco-openings-tab--active');
            t.setAttribute('aria-selected', 'false');
        });
        if (activeBtn) {
            activeBtn.classList.add('maco-openings-tab--active');
            activeBtn.setAttribute('aria-selected', 'true');
        }
    }

    function filterCards(filterSlug) {
        cards.forEach(function (card) {
            const cat = (card.getAttribute('data-maco-openings-category') || '').trim();
            const categories = cat ? cat.split(/\s+/) : [];
            const show = filterSlug === 'all' || categories.indexOf(filterSlug) !== -1;
            card.classList.toggle('maco-openings-card--hidden', !show);
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const slug = (this.getAttribute('data-maco-openings-filter') || 'all').trim();
            setActiveTab(this);
            filterCards(slug);
        });
    });
})();
