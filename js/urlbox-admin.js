document.addEventListener('DOMContentLoaded', () => {
  // Test proxy connection
  const testButton = document.getElementById('test-proxy-connection');
  const resultDiv = document.getElementById('proxy-test-result');

  testButton.addEventListener('click', async (e) => {
    e.preventDefault();

    resultDiv.textContent = "Testing...";
    resultDiv.style.color = "black";

    const form = document.querySelector('form');
    const formData = new FormData(form);
    const data = new URLSearchParams();

    formData.forEach((value, key) => {
      data.append(key, value);
    });

    data.append('action', 'test_proxy_connection');
    data.append('nonce', urlbox_admin_ajax.nonce);

    try {
      const response = await fetch(urlbox_admin_ajax.ajax_url, {
        method: 'POST',
        body: data
      });

      const result = await response.json();
      console.log(result);
      resultDiv.textContent = result.data;
      resultDiv.style.color = result.success ? "green" : "red";
    } catch (error) {
      resultDiv.textContent = `Error: ${error.message}`;
      resultDiv.style.color = "red";
    }
  });
});
