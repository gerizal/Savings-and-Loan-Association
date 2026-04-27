/**
 * Leaflet Map Helper Functions
 * Replaces Google Maps with Leaflet.js for geolocation
 */

let maps = {};
let markers = {};

/**
 * Initialize Leaflet map
 * @param {string} mapId - ID of the map container
 * @param {number} lat - Initial latitude
 * @param {number} lng - Initial longitude
 * @param {string} latInputId - ID of latitude input field
 * @param {string} lngInputId - ID of longitude input field
 * @param {string} addressInputId - ID of address input field (optional)
 */
function initLeafletMap(mapId, lat = -6.2088, lng = 106.8456, latInputId = 'address_latitude', lngInputId = 'address_longitude', addressInputId = 'address') {
    try {
        // Check if map container exists
        const mapContainer = document.getElementById(mapId);
        if (!mapContainer) {
            console.warn(`Map container #${mapId} not found`);
            return null;
        }

        // Check if map already exists
        if (maps[mapId]) {
            console.log(`Map #${mapId} already initialized, skipping...`);
            return maps[mapId];
        }

        // Check if container is visible (has dimensions)
        const rect = mapContainer.getBoundingClientRect();
        if (rect.width === 0 || rect.height === 0) {
            console.warn(`Map container #${mapId} is not visible (hidden or zero size)`);
            return null;
        }

        // Initialize map
        const map = L.map(mapId).setView([lat, lng], 13);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Add marker
    const marker = L.marker([lat, lng], {
        draggable: true
    }).addTo(map);

    // Store map and marker
    maps[mapId] = map;
    markers[mapId] = marker;

    // Update coordinates on marker drag
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng, latInputId, lngInputId);
        
        // Reverse geocoding using Nominatim
        if (addressInputId) {
            reverseGeocode(position.lat, position.lng, addressInputId);
        }
    });

    // Update coordinates on map click
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng, latInputId, lngInputId);
        
        if (addressInputId) {
            reverseGeocode(e.latlng.lat, e.latlng.lng, addressInputId);
        }
    });

    // Initialize with stored values if available
    const latInput = document.getElementById(latInputId);
    const lngInput = document.getElementById(lngInputId);
    
    if (latInput && lngInput) {
        const storedLat = parseFloat(latInput.value);
        const storedLng = parseFloat(lngInput.value);
        
        if (!isNaN(storedLat) && !isNaN(storedLng)) {
            marker.setLatLng([storedLat, storedLng]);
            map.setView([storedLat, storedLng], 13);
        }
    }

    // Search on address input change
    if (addressInputId) {
        const addressInput = document.getElementById(addressInputId);
        if (addressInput) {
            let searchTimeout;
            addressInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const address = this.value;
                    if (address.length > 5) {
                        geocodeAddress(address, mapId, latInputId, lngInputId);
                    }
                }, 1000); // Delay to avoid too many requests
            });
        }
    }

        return map;
    } catch (error) {
        console.error(`Error initializing Leaflet map #${mapId}:`, error);
        // Clean up if initialization failed
        if (maps[mapId]) {
            delete maps[mapId];
        }
        if (markers[mapId]) {
            delete markers[mapId];
        }
        return null;
    }
}

/**
 * Update coordinate input fields
 */
function updateCoordinates(lat, lng, latInputId, lngInputId) {
    const latInput = document.getElementById(latInputId);
    const lngInput = document.getElementById(lngInputId);
    
    if (latInput) latInput.value = lat.toFixed(6);
    if (lngInput) lngInput.value = lng.toFixed(6);
    
    // Update geo_location field if exists (format: lat, lng)
    const geoLocationId = latInputId.replace('_latitude', '').replace('address', 'geo_location');
    const geoLocationInput = document.getElementById(geoLocationId);
    if (geoLocationInput) {
        geoLocationInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        geoLocationInput.dispatchEvent(new Event('change'));
    }
    
    // Trigger change event
    if (latInput) latInput.dispatchEvent(new Event('change'));
    if (lngInput) lngInput.dispatchEvent(new Event('change'));
}

/**
 * Geocode address to coordinates using Nominatim
 */
let geocodeTimeout;
function geocodeAddress(address, mapId, latInputId, lngInputId) {
    const map = maps[mapId];
    const marker = markers[mapId];
    
    if (!map || !marker) {
        console.warn(`Map or marker not found for ${mapId}`);
        return;
    }

    // Clear previous timeout to avoid too many requests
    clearTimeout(geocodeTimeout);
    
    geocodeTimeout = setTimeout(() => {
        // Use Nominatim for geocoding (respecting usage policy with delay)
        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1&countrycodes=id`;
        
        console.log('Fetching geocode for:', address);
        
        fetch(url, {
            headers: {
                'User-Agent': 'SIPKPFI-Application' // Required by Nominatim usage policy
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);
                    
                    console.log(`Geocode result: ${lat}, ${lng}`);
                    
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 13);
                    updateCoordinates(lat, lng, latInputId, lngInputId);
                } else {
                    console.warn('No geocode results found for:', address);
                }
            })
            .catch(error => {
                console.error('Geocoding error:', error);
            });
    }, 1000); // 1 second delay to respect Nominatim usage policy
}

/**
 * Reverse geocode coordinates to address using Nominatim
 */
function reverseGeocode(lat, lng, addressInputId) {
    const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data && data.display_name) {
                const addressInput = document.getElementById(addressInputId);
                if (addressInput && !addressInput.value) {
                    // Only update if address field is empty
                    addressInput.value = data.display_name;
                }
            }
        })
        .catch(error => {
            console.error('Reverse geocoding error:', error);
        });
}

/**
 * Initialize function - called when DOM is ready
 */
function initialize() {
    // Initialize address map if exists
    if (document.getElementById('address_map')) {
        initLeafletMap('address_map', -6.2088, 106.8456, 'address_latitude', 'address_longitude', 'address');
    }
    
    // Initialize domicile map if exists
    if (document.getElementById('domicile_address_map')) {
        initLeafletMap('domicile_address_map', -6.2088, 106.8456, 'domicile_address_latitude', 'domicile_address_longitude', 'domicile_address');
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initialize);
} else {
    initialize();
}
