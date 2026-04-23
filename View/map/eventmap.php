<?php
$locations = $locations ?? [];
$registeredLocations = $registeredLocations ?? [];
$filterOptions = $filterOptions ?? ['cities' => [], 'types' => []];
$isLoggedIn = isset($_SESSION['user_id']);

function extractLatLng($link) {
    if (strpos($link, 'goo.gl') !== false || strpos($link, 'maps.app.goo.gl') !== false) {
        $context = stream_context_create([
            'http' => ['method' => 'HEAD', 'follow_location' => 0, 'ignore_errors' => true],
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
        ]);
        $headers = @get_headers($link, 1, $context);
        if ($headers && isset($headers['Location'])) {
            $link = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
        } else if (function_exists('curl_init')) {
            $ch = curl_init($link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            if ($response !== false && preg_match('/^Location:\s*(.*)$/mi', $response, $m)) {
                $link = trim($m[1]);
            }
            curl_close($ch);
        }
    }

    if (preg_match('/(?:q=|query=|@|place\/)(-?\d+\.\d+),(-?\d+\.\d+)/', $link, $matches)) {
        return [
            "latitude" => floatval($matches[1]),
            "longitude" => floatval($matches[2])
        ];
    }
    
    if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $link, $matches)) {
        return [
            "latitude" => floatval($matches[1]),
            "longitude" => floatval($matches[2])
        ];
    }
    
    return null;
}

foreach ($locations as &$loc) {
    if (empty($loc["gmap_link"])) continue;
    $coords = extractLatLng($loc["gmap_link"]);
    if ($coords) {
        $loc["latitude"] = $coords["latitude"];
        $loc["longitude"] = $coords["longitude"];
    }
}
unset($loc);

$registeredEventIds = array_column($registeredLocations, 'name');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" type="text/css" href="/V/View/map/eventmap.css">
    <title>V</title>
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-background">
        <div class="map-card">
        <h2>📍 Event Locations</h2>
        
        <div class="filters-wrapper">
            <?php if ($isLoggedIn): ?>
            <div class="filter-container">
                <div class="radio-slider">
                    <input type="radio" id="allEvents" name="eventFilter" value="all" checked onchange="toggleFilter()">
                    <input type="radio" id="registeredEvents" name="eventFilter" value="registered" onchange="toggleFilter()">
                    <label for="allEvents">All Events</label>
                    <label for="registeredEvents">Registered Events</label>
                    <div class="slider-indicator"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="dropdown-filters">
                <input type="text" id="locationSearch" placeholder="Search by location..." oninput="applyFilters()">
                
                <select id="typeFilter" onchange="applyFilters()">
                    <option value="">All Types</option>
                    <?php foreach ($filterOptions['types'] as $type): ?>
                        <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
                    <?php endforeach; ?>
                </select>
                
                <input type="date" id="dateFilter" onchange="applyFilters()" min="<?php echo date('Y-m-d'); ?>">
                
                <button onclick="clearFilters()" class="clear-btn">Clear Filters</button>
            </div>
        </div>
        
        <div id="map"></div>
        <button onclick="resetView()">Reset View</button>
    </div>
</div>

    <script>
        let map;
        const allLocations = <?php echo json_encode($locations); ?>;
        const registeredEventNames = <?php echo json_encode($registeredEventIds); ?>;
        const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
        const todayDateStr = <?php echo json_encode(date('Y-m-d')); ?>;
        let markers = [];
        let infoWindows = [];
        let showOnlyRegistered = false;
        let currentFilteredLocations = allLocations;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 7.8731, lng: 80.7718 },
                zoom: 7.25,
            });

            displayMarkers(allLocations, true);
        }

        function displayMarkers(locations, useAnimation = false) {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
            infoWindows = [];

            locations.forEach((loc) => {
                if (loc.latitude && loc.longitude) {
                    const isRegistered = registeredEventNames.includes(loc.name);
                    
                    const markerColor = isRegistered ? 'http://maps.google.com/mapfiles/ms/icons/green-dot.png' : 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
                    
                    const normalSize = new google.maps.Size(32, 32);
                    const enlargedSize = new google.maps.Size(48, 48);

                    const markerOptions = {
                        position: { lat: loc.latitude, lng: loc.longitude },
                        map: map,
                        title: loc.name,
                        icon: {
                            url: markerColor,
                            scaledSize: normalSize
                        }
                    };
                    
                    if (useAnimation) {
                        markerOptions.animation = google.maps.Animation.DROP;
                    }
                    
                    const marker = new google.maps.Marker(markerOptions);

                    const isHappeningNow = loc.state_of_event === 'active' && loc.event_date === todayDateStr;
                    
                    if (isRegistered && isHappeningNow) {
                        let isFaded = false;
                        setInterval(() => {
                            if (marker.getMap()) {
                                isFaded = !isFaded;
                                marker.setOpacity(isFaded ? 0.5 : 1.0);
                                marker.setIcon({
                                    url: markerColor,
                                    scaledSize: enlargedSize
                                });
                            }
                        }, 600);
                    }

                    const statusBadge = isRegistered ? '<span style="background: #28a745; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-left: 5px;">✓ Registered</span>' : '<span style="background: #e74c3c; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-left: 5px;">✕ Not Registered</span>';
                    const happeningNowBadge = isHappeningNow ? '<span style="background: #ffc107; color: #000; font-weight: bold; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-left: 5px; display: inline-block; margin-top: 4px;">🔥 Happening Now</span>' : '';

                    const viewEventButton = isLoggedIn ? `<button onclick="redirectToEvent('${loc.event_id}')" style="background: #65AC9F; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; margin-top: 10px; font-weight: bold; width: 100%;">View Event Details</button>` : '';

                    const infowindow = new google.maps.InfoWindow({
                        content: `<div style="padding: 10px; min-width: 200px;">
                                    <h3 style="margin: 0 0 5px 0; color: #2C3E50; line-height: 1.4;">${loc.name}<br>${statusBadge} ${happeningNowBadge}</h3>
                                    <p style="margin: 5px 0; color: #555; font-size: 13px;"><strong>Location:</strong> ${loc.location}</p>
                                    <p style="margin: 5px 0; color: #555; font-size: 13px;"><strong>Type:</strong> ${loc.event_type}</p>
                                    <p style="margin: 5px 0; color: #555; font-size: 13px;"><strong>Date:</strong> ${loc.event_date}</p>
                                    <a href="${loc.gmap_link}" target="_blank" style="color: #007bff; text-decoration: underline; font-weight: bold;">
                                        View on Google Maps
                                    </a>
                                    ${viewEventButton}
                                    </div>`
                    });

                    infoWindows.push(infowindow);
                    markers.push(marker);

                    marker.addListener("click", () => {
                        infoWindows.forEach(iw => iw.close());
                        infowindow.open(map, marker);
                    });
                }
            });
        }

        function redirectToEvent(eventId) {
            window.location.href = `/V/router.php?module=projects&action=projects#event-${eventId}`;
        }

        function toggleFilter() {
            const registeredRadio = document.getElementById('registeredEvents');
            const allEventsRadio = document.getElementById('allEvents');
            showOnlyRegistered = registeredRadio.checked;
            applyFilters();
        }

        function applyFilters() {
            let filteredLocations = allLocations;
            
            if (isLoggedIn && showOnlyRegistered) {
                filteredLocations = filteredLocations.filter(loc => 
                    registeredEventNames.includes(loc.name)
                );
            }
            
            const locationSearch = document.getElementById('locationSearch').value.toLowerCase().trim();
            if (locationSearch) {
                filteredLocations = filteredLocations.filter(loc => 
                    loc.location.toLowerCase().includes(locationSearch)
                );
            }
            
            const typeFilter = document.getElementById('typeFilter').value;
            if (typeFilter) {
                filteredLocations = filteredLocations.filter(loc => 
                    loc.event_type === typeFilter
                );
            }
            
            const dateFilter = document.getElementById('dateFilter').value;
            if (dateFilter) {
                filteredLocations = filteredLocations.filter(loc => 
                    loc.event_date === dateFilter
                );
            }
            
            currentFilteredLocations = filteredLocations;
            displayMarkers(filteredLocations);
        }

        function clearFilters() {
            document.getElementById('locationSearch').value = '';
            document.getElementById('typeFilter').value = '';
            document.getElementById('dateFilter').value = '';
            
            applyFilters();
        }

        function resetView() {
            map.setCenter({ lat: 7.8731, lng: 80.7718 });
            map.setZoom(7.25);
            infoWindows.forEach(iw => iw.close());
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJSU1xHdWQ06eflLu6dIWvs46kj0v9gfI&callback=initMap" async defer></script>
</body>
</html>
