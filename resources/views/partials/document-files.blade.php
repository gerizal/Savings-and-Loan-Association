<ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
    @foreach($documents as $i => $document)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{$i == 0 ? 'active' : ''}}"
                    id="{{$document->type}}-tab"
                    data-toggle="tab"
                    data-target="#{{$document->type}}-content"
                    type="button"
                    role="tab"
                    aria-controls="{{$document->type}}-content"
                    aria-selected="{{$i == 0 ? 'true' : 'false'}}">
                {{ applicationDocumentType($document->type) }}
            </button>
        </li>
    @endforeach
</ul>

<div class="tab-content" id="myTabContent" style="height:50vh;">
    @foreach($documents as $j => $document)
        <div class="tab-pane fade {{$j == 0 ? 'show active' : ''}}"
             id="{{$document->type}}-content"
             role="tabpanel"
             aria-labelledby="{{$document->type}}-tab">
            <div class="row">
                <div class="col-md-12 text-center">

                    @if(in_array($document->type, ['slik', 'application', 'credit-analysis']))
                        <iframe
                            src="{{$document->url}}"
                            frameborder="0"
                            scrolling="auto"
                            width="100%"
                            style="min-height:400px; max-height:50%;"
                        >
                        </iframe>

                    @elseif(in_array($document->type, ['insurance_video', 'interview_video']))
                        <video src="{{$document->url}}" height="60%" width="100%" controls></video>

                    @elseif($document->type === 'map')
                        <div id="map-{{$j}}" class="google-map" style="height: 50vh;"></div>

                        <script>
                            window.mapsData = window.mapsData || [];
                            window.mapsData.push({
                                id: "map-{{$j}}",
                                lat: parseFloat("{{$document->latitude}}"),
                                lng: parseFloat("{{$document->longitude}}")
                            });
                        </script>
                    @endif

                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Global map loader and tab watcher --}}
<script>
    let mapsInitialized = {};

    async function initMap() {
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

        document.querySelectorAll(".google-map").forEach(container => {
            const mapId = container.id;

            // Check if already initialized
            if (mapsInitialized[mapId]) return;

            const data = window.mapsData.find(m => m.id === mapId);
            if (!data) return;

            const position = { lat: data.lat, lng: data.lng };

            const map = new Map(container, {
                zoom: 14,
                center: position,
                mapId: "DEMO_MAP_ID"
            });

            new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Map Location"
            });

            mapsInitialized[mapId] = true;
        });
    }

    // When a tab is shown, try to load the map
    document.querySelectorAll('a[data-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function () {
            initMap();
        });
    });

</script>

{{-- Load Google Maps JS API --}}
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap&v=weekly"
    defer
></script>
