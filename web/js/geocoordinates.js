var placeSearch, autocomplete;

function initialize() {
    var input = document.getElementById('appbundle_weatherinfo_city');
    autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', fillGeoCode);
}

function fillGeoCode() {


    var geocoder = new google.maps.Geocoder();
    var address = document.getElementById('appbundle_weatherinfo_city').value;



    geocoder.geocode({ 'address': address }, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {



            document.getElementById('appbundle_weatherinfo_latitude').advalue = results[0].geometry.location.lat();

            document.getElementById('appbundle_weatherinfo_longitude').value = results[0].geometry.location.lng();

        }
    });
}

google.maps.event.addDomListener(window, 'load', initialize);

if (status === google.maps.GeocoderStatus.OK) {
    var latitude = results[0].geometry.location.lat();
    var longitude = results[0].geometry.location.lng();

}
