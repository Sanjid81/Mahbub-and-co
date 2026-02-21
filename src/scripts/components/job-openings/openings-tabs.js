(function () {
    const section = document.querySelector('.maco-openings');
    if (!section) return;

    const tabs = section.querySelectorAll('.maco-openings-tab');
    const cards = section.querySelectorAll('.maco-openings-card');

    function setActiveTab(activeTab) {
        tabs.forEach(t => {
            t.classList.remove('maco-openings-tab--active');
            t.setAttribute('aria-selected', 'false');
        });
        activeTab.classList.add('maco-openings-tab--active');
        activeTab.setAttribute('aria-selected', 'true');
    }

    function filterCards(filterValue) {
        cards.forEach(card => {
            const catAttr = card.getAttribute('data-maco-openings-category') || '';
            const categories = catAttr.trim().split(/\s+/).filter(Boolean);

            // মূল লজিক: সব কার্ডকে প্রথমে hide করা
            let shouldShow = (filterValue === 'all');

            if (!shouldShow) {
                // কোনো একটা ক্যাটাগরি মিললে দেখাবে
                shouldShow = categories.some(cat => cat === filterValue);
            }

            // ডিবাগের জন্য (পরে মুছে ফেলতে পারো)
            // console.log(card.querySelector('.maco-openings-card-title').textContent.trim(), categories, filterValue, shouldShow);

            card.classList.toggle('maco-openings-card--hidden', !shouldShow);
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const filterValue = this.getAttribute('data-maco-openings-filter') || 'all';
            setActiveTab(this);
            filterCards(filterValue);
        });
    });

    // পেজ লোড হলে All ট্যাব active + সব দেখানো
    const allTab = section.querySelector('[data-maco-openings-filter="all"]');
    if (allTab) {
        setActiveTab(allTab);
        filterCards('all');
    }
})();