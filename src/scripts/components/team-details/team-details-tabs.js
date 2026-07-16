        // Get all navigation items and sections
    const navItems = document.querySelectorAll('.nav-item');
    const sections = document.querySelectorAll('section');

    // Function to remove active class from all nav items
    function removeActiveClasses() {
        navItems.forEach(item => item.classList.remove('active'));
        }

    // Function to add active class to current nav item
    function addActiveClass(id) {
        removeActiveClasses();
    const activeLink = document.querySelector(`.nav-item[href="#${id}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
            }
        }

        // Smooth scroll on click
        navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = item.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
        });

        // Highlight active section on scroll
        window.addEventListener('scroll', () => {
        let current = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
    const sectionHeight = section.clientHeight;

                if (window.pageYOffset >= sectionTop - 100) {
        current = section.getAttribute('id');
                }
            });

    if (current) {
        addActiveClass(current);
            }
        });

    // Dynamic text download for buttons with '#' href
    const downloadButtons = document.querySelectorAll('.download-btn');
    downloadButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const href = btn.getAttribute('href');
            if (!href || href === '#' || href === '') {
                e.preventDefault();
                
                const section = btn.closest('section');
                if (!section) return;
                
                const titleEl = section.querySelector('h2');
                const contentEl = section.querySelector('.subcategory-description-container');
                
                if (!contentEl) return;
                
                const title = titleEl ? titleEl.textContent.trim() : 'Document';
                const contentText = contentEl.textContent.trim().replace(/\n\s*\n/g, '\n');
                
                const fileContent = `${title}\n\n${contentText}`;
                
                const blob = new Blob([fileContent], { type: 'text/plain;charset=utf-8' });
                const url = URL.createObjectURL(blob);
                
                const tempLink = document.createElement('a');
                tempLink.href = url;
                tempLink.download = `${title.replace(/[^a-z0-9\s]/gi, '').trim()}.txt`;
                document.body.appendChild(tempLink);
                tempLink.click();
                document.body.removeChild(tempLink);
                URL.revokeObjectURL(url);
            }
        });
    });
