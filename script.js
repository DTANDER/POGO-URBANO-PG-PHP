const pupilas = document.querySelectorAll(".pupila");

document.addEventListener("mousemove", (e) => {
  pupilas.forEach(p => {
    const ojo = p.parentElement.getBoundingClientRect();

    const centerX = ojo.left + ojo.width / 2;
    const centerY = ojo.top + ojo.height / 2;

    let dx = e.clientX - centerX;
    let dy = e.clientY - centerY;

    const angle = Math.atan2(dy, dx);

    const max = 5; // 🔥 antes era muy grande

    const x = Math.cos(angle) * max;
    const y = Math.sin(angle) * max;

    p.style.transform = `translate(${x}px, ${y}px)`;
  });
});