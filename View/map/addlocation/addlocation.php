<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <link rel="stylesheet" type="text/css" href="/V/View/map/addlocation/addlocation.css">
    <title>V</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-background">
        <div class="map-card">
            <h2>📍 Select Event Location</h2>
            <div id="map"></div>

            <!-- Hidden input to store Google Maps link -->
            <input type="hidden" id="gmapLink" name="gmap_link">

            <!-- Display generated Google Maps link -->
            <p id="link">Click on the map to add event location.</p>

            <form action="save_location.php" method="post">
            <input type="hidden" name="gmap_link" id="hiddenInput">
            <button type="button" onclick="saveAndClose()">Save Location</button>
            </form>
        </div>
    </div>

  <script>
    let map;
    let marker;

    function initMap() {
      // Center on Sri Lanka
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 7.8731, lng: 80.7718 },
        zoom: 7,
      });

      // Click event
      map.addListener("click", (e) => {
        if (marker) {
          marker.setMap(null);
        }

        marker = new google.maps.Marker({
          position: e.latLng,
          map: map,
        });

        const lat = e.latLng.lat();
        const lng = e.latLng.lng();
        const gmapLink = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;

        // Update hidden inputs
        document.getElementById("gmapLink").value = gmapLink;
        document.getElementById("hiddenInput").value = gmapLink;

        // Show link
        document.getElementById("link").innerHTML =
          `Google Maps Link: <a href="${gmapLink}" target="_blank">${gmapLink}</a>`;
      });
    }

    function saveAndClose() {
      const gmapLink = document.getElementById('gmapLink').value;
      
      if (!gmapLink) {
          alert('Please select a location on the map first.');
          return;
      }
      
      // Send data to parent window
      if (window.opener && !window.opener.closed) {
          window.opener.receiveLocation(gmapLink);
          window.close();
      } else {
          alert('Parent window not found.');
      }
    }
  </script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJSU1xHdWQ06eflLu6dIWvs46kj0v9gfI&callback=initMap" async defer></script>
</body>
</html>
