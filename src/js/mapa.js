if (document.querySelector('#mapa')) {
    const latitud = 37.48486;
    const longitud = -5.98246;
    const zoom = 16;

    const map = L.map('mapa').setView([latitud, longitud], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([latitud, longitud]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp 2024</h2>
            <p class="mapa__texto">Centro Cultural Antonio Gala</p>
        `)
        .openPopup();
}