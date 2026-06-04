// Arrow navigation
const containers = document.querySelectorAll(".insights-tabs-container");

containers.forEach(function (container) {
  const track = container.querySelector(".insights-tabs");
  const prev = container.querySelector(".arrow-prev");
  const next = container.querySelector(".arrow-next");
  const amount = 200;

  function updateArrows() {
    prev.disabled = track.scrollLeft <= 0;
    next.disabled =
      track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
  }

  next.addEventListener("click", function () {
    track.scrollLeft += amount;
    setTimeout(updateArrows, 300);
  });

  prev.addEventListener("click", function () {
    track.scrollLeft -= amount;
    setTimeout(updateArrows, 300);
  });

  track.addEventListener("scroll", updateArrows);
  updateArrows(); // set initial state
});
