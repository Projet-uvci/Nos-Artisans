document.addEventListener("DOMContentLoaded", function() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        });
    } else {
        alert("La géolocalisation n'est pas disponible sur votre navigateur.");
    }
});


