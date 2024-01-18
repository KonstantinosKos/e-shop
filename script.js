// script.js
function getData() {
    fetch('http://localhost/e=shop/getData.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            // Add any additional headers if needed
        },
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the backend
        document.getElementById('result').innerHTML = JSON.stringify(data);
    })
    .catch(error => console.error('Error:', error));
}
