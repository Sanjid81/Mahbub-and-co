const LOAD_COUNT = 3;

function initRecognitionCards() {
    const container = document.querySelector(".recognition-section");
    if (!container) return;

    const loadMoreBtn = container.querySelector(".recognition-load-more-btn");
    if (!loadMoreBtn) return;

    loadMoreBtn.addEventListener("click", () => {
        const hiddenCards = container.querySelectorAll(".recognition-card-item--hidden");
        const toShow = Array.from(hiddenCards).slice(0, LOAD_COUNT);

        toShow.forEach((card) => card.classList.remove("recognition-card-item--hidden"));

        const remaining = container.querySelectorAll(".recognition-card-item--hidden");
        if (remaining.length === 0) {
            loadMoreBtn.style.display = "none";
        }
    });
}

initRecognitionCards();
