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
