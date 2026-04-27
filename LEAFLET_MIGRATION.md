# Migrasi dari Google Maps ke Leaflet.js

## Perubahan yang Dilakukan

### 1. File Baru
- **`public/assets/scripts/leaflet-map.js`** - Library helper untuk Leaflet maps
  - Fungsi `initLeafletMap()` - Inisialisasi peta
  - Fungsi `geocodeAddress()` - Konversi alamat ke koordinat (menggunakan Nominatim)
  - Fungsi `reverseGeocode()` - Konversi koordinat ke alamat
  - Fungsi `updateCoordinates()` - Update field latitude/longitude

### 2. File yang Diupdate
- **`resources/views/layouts/template.blade.php`**
  - ✅ Menghapus Google Maps API script
  - ✅ Menambahkan Leaflet CSS (unpkg CDN)
  - ✅ Menambahkan Leaflet JS (unpkg CDN)
  - ✅ Menambahkan leaflet-map.js script
  - ✅ Menambahkan CSS untuk class `.map`

## Fitur Leaflet Maps

### Kelebihan:
1. **Gratis 100%** - Tidak memerlukan API key
2. **Open Source** - Menggunakan OpenStreetMap data
3. **Geocoding Gratis** - Menggunakan Nominatim API
4. **Lightweight** - Lebih ringan dari Google Maps
5. **Privacy** - Tidak ada tracking dari Google

### Cara Kerja:
1. **Drag & Drop Marker** - User bisa drag marker untuk update lokasi
2. **Click pada Map** - Klik di peta untuk set lokasi baru
3. **Auto-geocoding** - Ketik alamat, map otomatis update (dengan delay 1 detik)
4. **Reverse geocoding** - Klik/drag marker, alamat otomatis terisi (jika field kosong)

### Map yang Diinisialisasi:
- `#address_map` - Peta alamat KTP (latitude: address_latitude, longitude: address_longitude)
- `#domicile_address_map` - Peta alamat domisili (latitude: domicile_address_latitude, longitude: domicile_address_longitude)

## Koordinat Default
Default location: **Jakarta, Indonesia**
- Latitude: `-6.2088`
- Longitude: `106.8456`

## Geocoding Provider
Menggunakan **Nominatim** (OpenStreetMap):
- Search: `https://nominatim.openstreetmap.org/search`
- Reverse: `https://nominatim.openstreetmap.org/reverse`

⚠️ **Note**: Nominatim memiliki rate limit, sudah ditambahkan delay 1 detik untuk pencarian otomatis.

## Testing
Field latitude dan longitude akan otomatis terisi ketika:
1. User drag marker di peta
2. User klik di peta
3. Map diinisialisasi (menggunakan value yang ada di database)

## Tidak Perlu Konfigurasi
- ❌ Tidak perlu Google Maps API Key
- ❌ Tidak perlu setting di `.env`
- ✅ Langsung bisa digunakan

## Browser Support
- Chrome/Edge: ✅
- Firefox: ✅
- Safari: ✅
- Mobile: ✅

## Dokumentasi
- Leaflet: https://leafletjs.com/
- Nominatim: https://nominatim.org/
- OpenStreetMap: https://www.openstreetmap.org/
