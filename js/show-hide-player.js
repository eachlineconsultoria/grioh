
document.addEventListener('shown.bs.modal', function (event) {
  const modal = event.target;
  const iframe = modal.querySelector('iframe');
  if (!iframe) return;

  try {
    const url = new URL(iframe.src);
    if (!url.searchParams.has('autoplay')) {
      url.searchParams.set('autoplay', '1');
      iframe.dataset.srcOriginal = iframe.src;
      iframe.src = url.toString();
    }
  } catch (e) { }
});

document.addEventListener('hide.bs.modal', function (event) {
  const modal = event.target;
  const iframe = modal.querySelector('iframe');
  if (iframe && iframe.dataset.srcOriginal) {
    iframe.src = iframe.dataset.srcOriginal; // reseta (pausa)
    delete iframe.dataset.srcOriginal;
  }
});

