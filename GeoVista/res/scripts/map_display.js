
// get geojson
async function getCountryData(countryCode) {
    const response = await fetch('./res/country_data/countries.geo.json');
    const data = await response.json();
    console.log(countryCode);
    return data.features.filter( country => country.properties.ISO_A3 === countryCode );
}

// load geoJSON data to map
export async function loadCountryData(map, countryCode, oldLayer) {
    if (oldLayer != undefined) {
        map.removeLayer(oldLayer);
    }
    
    const data = await getCountryData(countryCode);
    
    const geoJsonLayer = await L.geoJSON(data, {
        style: {
            color: 'blue',
            weight: 1.5,
            opacity: 1
        }
    }).addTo(map);

    map.fitBounds(L.geoJSON(data).getBounds());

    return geoJsonLayer;
}

export function getLeafletModule(container, mapUrl, withWorld) {
    const map = L.map(container).setView([51.5050, 10.09], 4);

    if (withWorld) {
        L.tileLayer(mapUrl, {
            minZoom: 3,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    } else {
        L.rectangle([
            [-90, -180],
            [90, 180]
        ], {
            fillColor: '#f0f0f0',
            fillOpacity: 1
        }).addTo(map);

        // disable scrolling and the 
        map.scrollWheelZoom.disable();
        map.doubleClickZoom.disable();
        map.touchZoom.disable();
        map.boxZoom.disable();
        map.keyboard.disable();
        map.removeControl(map.zoomControl);
    }

    return map;
}