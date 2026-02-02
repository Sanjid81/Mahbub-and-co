<?php
$team_tabs = get_query_var('team_tabs');
if (empty($team_tabs))
    return;
?>
<div class="team-details-tab-section">
    <!-- Tabs Navigation -->
    <div class="team-details-tabs">
        <div class="team-details-tab">
            <?php foreach ($team_tabs as $index => $tab): ?>
                <a href="#<?php echo esc_attr($tab['tab_id']); ?>"
                    class="tab-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <?php echo esc_html($tab['tab_title']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Tab Content -->
    <div class="container">
        <?php foreach ($team_tabs as $index => $tab): ?>
            <section id="<?php echo esc_attr($tab['tab_id']); ?>" class="tab-content">
                <div class="subcategory-description-container">
                    <?php echo apply_filters('the_content', $tab['tab_content']); ?>
                </div>
                <?php if (!empty($tab['button_text'])): ?>
                    <a href="<?php echo esc_url($tab['button_link']); ?>" class="download-btn">
                        <?php echo esc_html($tab['button_text']); ?>
                    </a>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
</div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get all navigation items and sections
        const navItems = document.querySelectorAll('.tab-item');
        const sections = document.querySelectorAll('.tab-content');

        // Function to remove active class from all nav items
        function removeActiveClasses() {
            navItems.forEach(item => item.classList.remove('active'));
        }

        // Function to add active class to current nav item
        function addActiveClass(id) {
            removeActiveClasses();
            const activeLink = document.querySelector(`.tab-item[href="#${id}"]`);
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
    });
</script> -->