    document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.insights-tab');
    const contents = document.querySelectorAll('.insights-tab-content');

    if (tabs.length === 0) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', function (e) {
            e.preventDefault();
            const category = this.getAttribute('data-category');

            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            this.classList.add('active');
            const activeContent = document.querySelector('.insights-tab-content[data-category="' + category + '"]');
            if (activeContent) {
                activeContent.classList.add('active');
            }
        });
    });
});
