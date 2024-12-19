<?php
if (isset($_COOKIE['latitude']) && isset($_COOKIE['longitude'])) {
    header("Location: ../index.php");
    exit;
}


if (isset($_COOKIE['user_id'])) {
    header("Location: ../user/profile.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html class="use-all-space">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset="UTF-8" />
    <title>My Map</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />

    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">
    
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css"/>
    
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js"></script>
    <style>
        #map {
            width: 60vw;
            height: 60vh;
            display: none;
        }

         /* Custom style for the search box input */
         .tt-search-box{
            width: 100%;
            margin: auto;
            padding: 12px;
        }
        
        .tt-search-box input {
            font-size: 16px;
            width: 100%;
            height: 50px;
        }

        .tt-search-box input:focus {
            outline: none;
            box-shadow: none;
        }
        
        .tt-search-box-input-container{
            width: 100%;
            max-width: 512px;
            height: 50px;
            border: 3px solid gray;
            border-radius: 8px;
            margin: auto;
        }

        /* Custom style for the search box suggestions */
        .tt-search-box .tt-dataset.tt-dataset-results {
            background-color: #ffffff;
            border: 2px solid #007bff;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .tt-search-box .tt-dataset.tt-dataset-results .tt-suggestion {
            padding: 10px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
        }
        
        /* Highlight suggestion on hover */
        .tt-search-box .tt-dataset.tt-dataset-results .tt-suggestion.tt-cursor {
            background-color: #007bff;
            color: white;
        }
        
        /* Custom style for the "no results" message */
        .tt-search-box .tt-dataset.tt-dataset-results .tt-no-results {
            padding: 10px;
            font-size: 14px;
            color: #888;
            height: 100%;
        }

        .tt-search-box-result-list-container{
            position: absolute;
            left: 0;
            top: 100px;
            width: 100%;
            background-color: #e5e7eb;
            border-radius: 8px;
        }

        .tt-search-box-result-list{
            margin: 7px;
            border-radius: 8px;
            padding: 20px 12px;
        }
    </style>
</head>

<body>

    <div id="loader" class="flex-col gap-4 w-full flex items-center justify-center bg-black/30 fixed top-0 h-full backdrop-blur-sm z-40" style="display: none;">
        <div class="w-20 h-20 border-4 border-transparent text-blue-400 text-4xl animate-spin flex items-center justify-center border-t-gray-700 rounded-full">
            <div class="w-16 h-16 border-4 border-transparent text-red-400 text-2xl animate-spin flex items-center justify-center border-t-gray-900 rounded-full"></div>
        </div>
    </div>

    <!-- Header -->
    <header class="flex items-center bg-white p-2 h-14 shadow-md border-b-2 border-gray-400 mb-6">
        <a href="../index.php" class="p-2">
            <!-- Left Arrow Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492 492" class="w-5 h-5">
                <path d="M198.608 246.104 382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z" fill="currentColor"></path>
            </svg>
        </a>
        <h1 class="flex-grow text-center text-lg font-semibold">Your Location</h1>
    </header>

    <div id="map" class="map"></div>
    <div id="distance" class="hidden">Click to select the first point.</div>

    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
    <script>

        function loader() {
            let loader = document.getElementById('loader');
            let body = document.body;
            
            loader.style.display = 'flex';

            setTimeout(() => {
                body.style.overflow = 'hidden';
                window.location.href="../index.php";
            }, 2000);
        }

        tt.setProductInfo("hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw", "6.25.0");
        let map = tt.map({
            key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
            container: "map",
        });

        var options = {
            searchOptions: {
                key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                language: "en-GB",
                limit: 5,
            },
            autocompleteOptions: {
                key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                language: "en-GB",
            },
        };

        var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
        var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
        document.body.append(searchBoxHTML);

        // Predefined location coordinates
        var predefinedLocation = { lat: 21.23639167790857, lng: 72.82233304180576 }; 

        var currentMarker = null;

        // Function to remove the current marker
        function removeCurrentMarker() {
            if (currentMarker) {
                currentMarker.remove();
            }
        }

        // Haversine formula to calculate the distance
        function haversine(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c;
            return distance;
        }

        // Handle search result selection
        ttSearchBox.on('tomtom.searchbox.resultselected', function(event) {
            const selectedResult = event.data.result;
            const coordinates = selectedResult.position;

            removeCurrentMarker();

            // Add a marker at the selected search location
            currentMarker = new tt.Marker()
                .setLngLat(coordinates)
                .addTo(map);

            var distance = haversine(predefinedLocation.lat, predefinedLocation.lng, coordinates.lat, coordinates.lng);
            
            fetch('set_location.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'latitude=' + coordinates.lat + '&longitude=' + coordinates.lng
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // This is the PHP response
            })
            .catch(error => console.error('Error:', error));


            var distanceDisplay = document.getElementById('distance');
            if (distance > 15) {
                distanceDisplay.innerHTML = "We cannot go there, the location is more than 15 km away.";
            } else {
                distanceDisplay.innerHTML = "Distance: " + distance.toFixed(2) + " km";
            }

            loader();
        });
    </script>
</body>

</html>
