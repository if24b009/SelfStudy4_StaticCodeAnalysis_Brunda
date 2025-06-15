<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
?>
<style>
    #map {
        height: 550px;
        width: 720px;
    }
</style>
<!-- LEAFLET STYLESHEET -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
crossorigin=""/>

<!-- LEAFLET SOURCE CODE -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
crossorigin=""></script>