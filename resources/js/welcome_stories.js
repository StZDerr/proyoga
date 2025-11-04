// Drag-to-scroll, arrows, modal and "seen" marking for stories

document.addEventListener('DOMContentLoaded', () => {
  const list = document.querySelector('.istoria__list');
  if (!list) return;

  const leftBtn = document.querySelector('.istoria__arrow--left');
  const rightBtn = document.querySelector('.istoria__arrow--right');
  const modal = document.querySelector('.istoria-modal');
  const modalContent = document.querySelector('.istoria-modal__content');
  const modalClose = document.querySelector('.istoria-modal__close');

  // helpers
  const updateArrows = () => {
    if (!list) return;
    const isOverflowing = list.scrollWidth > list.clientWidth + 2;
    if (!isOverflowing) {
      leftBtn && leftBtn.classList.add('hidden');
      rightBtn && rightBtn.classList.add('hidden');
      return;
    }
    leftBtn && leftBtn.classList.remove('hidden');
    rightBtn && rightBtn.classList.remove('hidden');
    leftBtn && (leftBtn.disabled = list.scrollLeft <= 0);
    const maxScrollLeft = list.scrollWidth - list.clientWidth - 1;
    rightBtn && (rightBtn.disabled = list.scrollLeft >= maxScrollLeft);
  };

  // initial
  updateArrows();
  window.addEventListener('resize', () => requestAnimationFrame(updateArrows));
  list.addEventListener('scroll', () => { window.requestAnimationFrame(updateArrows); });

  // arrow clicks: scroll by viewport width / 2
  const scrollAmount = () => Math.max(150, Math.floor(list.clientWidth / 2));
  leftBtn && leftBtn.addEventListener('click', () => list.scrollBy({ left: -scrollAmount(), behavior: 'smooth' }));
  rightBtn && rightBtn.addEventListener('click', () => list.scrollBy({ left: scrollAmount(), behavior: 'smooth' }));

  // drag to scroll (pointer events)
  let isDown = false, startX, scrollLeft;
  list.addEventListener('pointerdown', (e) => {
    isDown = true;
    list.setPointerCapture(e.pointerId);
    startX = e.clientX;
    scrollLeft = list.scrollLeft;
    list.classList.add('dragging');
  });
  list.addEventListener('pointermove', (e) => {
    if (!isDown) return;
    const dx = e.clientX - startX;
    list.scrollLeft = scrollLeft - dx;
  });
  list.addEventListener('pointerup', (e) => {
    isDown = false;
    try { list.releasePointerCapture(e.pointerId); } catch (err) {}
    list.classList.remove('dragging');
  });
  list.addEventListener('pointerleave', () => { isDown = false; list.classList.remove('dragging'); });

  // modal open for img/video
  const openModal = (type, src, itemEl) => {
    if (!modal || !modalContent) return;
    modalContent.querySelectorAll('img,video').forEach(n => n.remove());
    if (type === 'video') {
      const v = document.createElement('video');
      v.controls = true;
      v.autoplay = true;
      v.src = src;
      v.playsInline = true;
      v.style.maxWidth = '100%';
      modalContent.appendChild(v);
      v.play().catch(()=>{});
    } else {
      const img = document.createElement('img');
      img.src = src;
      modalContent.appendChild(img);
    }
    modal.classList.add('active');
    // mark seen
    if (itemEl) {
      itemEl.classList.add('seen');
      try {
        const key = 'proyoga_seen_stories';
        const seen = JSON.parse(localStorage.getItem(key) || '[]');
        const id = itemEl.dataset.storyId;
        if (id && !seen.includes(id)) {
          seen.push(id);
          localStorage.setItem(key, JSON.stringify(seen));
        }
      } catch (e) {}
    }
  };

  // modal close
  const closeModal = () => {
    if (!modal || !modalContent) return;
    modal.classList.remove('active');
    modalContent.querySelectorAll('video').forEach(v => { v.pause(); v.src = ''; v.remove(); });
    modalContent.querySelectorAll('img').forEach(i => i.remove());
  };
  modalClose && modalClose.addEventListener('click', closeModal);
  modal && modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

  // wire up items
  list.querySelectorAll('.istoria__item').forEach(item => {
    item.addEventListener('click', () => {
      const type = item.dataset.type || 'image';
      const src = item.dataset.src;
      if (!src) return;
      openModal(type, src, item);
    });
  });

  // restore seen state
  try {
    const key = 'proyoga_seen_stories';
    const seen = JSON.parse(localStorage.getItem(key) || '[]');
    list.querySelectorAll('.istoria__item').forEach(item => {
      const id = item.dataset.storyId;
      if (id && seen.includes(id)) item.classList.add('seen');
    });
  } catch (e) {}

});
