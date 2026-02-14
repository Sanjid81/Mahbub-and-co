/**
 * Career page: one page with Overview + What We Look For.
 * - Tab click: smooth scroll to that section.
 * - Scroll: active tab updates by which section is in view (scroll spy).
 */
(function () {
    const block = document.querySelector('.career-overview-block');
    if (!block) return;

    const tabItems = block.querySelectorAll('.tab-item[data-tab-id]');
    const tabContents = block.querySelectorAll('.career-tab-contents .tab-content');

    function setActiveTab(tabId) {
        tabItems.forEach(function (item) {
            if ((item.getAttribute('data-tab-id') || '').toString() === tabId) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    // Tab click: smooth scroll to section
    tabItems.forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const tabId = (this.getAttribute('data-tab-id') || '').toString();
            const section = tabId ? document.getElementById(tabId) : null;
            if (section) {
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                setActiveTab(tabId);
            }
        });
    });

    // Scroll spy: which section is in view → set that tab active
    const stickyNavHeight = 80;
    function onScroll() {
        let activeId = '';
        tabContents.forEach(function (content) {
            const id = content.getAttribute('id');
            if (!id) return;
            const rect = content.getBoundingClientRect();
            const top = rect.top - stickyNavHeight;
            const bottom = rect.bottom;
            if (top <= 120 && bottom > 150) {
                activeId = id;
            }
        });
        if (activeId) setActiveTab(activeId);
    }

    window.addEventListener('scroll', function () {
        onScroll();
    }, { passive: true });
    onScroll();
})();
