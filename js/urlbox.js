document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll("[data-render-url]").forEach((image) => {
    const parentElement = image.parentElement;
    const url = image.dataset.renderUrl;

    if (url) {
      parentElement.classList.add('urlbox-spinner');

      fetch(urlbox_ajax.ajax_url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          action: 'proxy_fetch_render_url',
          url: url,
          nonce: urlbox_ajax.nonce
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success && data.data.rendered_url) {
          image.src = data.data.rendered_url;
          parentElement.classList.remove('urlbox-spinner'); // Remove spinner class
        } else {
          console.error('Failed to fetch rendered URL.');
          // Keep the spinner active
        }
      })
      .catch(error => {
        console.error('Error:', error);
        parentElement.classList.remove('urlbox-spinner'); // Remove spinner class
      });
    }
  });
});