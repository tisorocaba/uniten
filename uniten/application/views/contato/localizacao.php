<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>

<script>

    $(document).ready(function(){
        initialize();
        codeAddress(document.getElementById('end').value,document.getElementById('endereco').value);
        codeAddress(document.getElementById('end2').value,document.getElementById('endereco2').value);
    })

    var geocoder;
    var map;
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-23.487578,-47.478915);
        var myOptions = {
            zoom: 12,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map"), myOptions);

    }

    function codeAddress(end,lbend) {
        var address = end;

        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });

                var contentString = lbend;
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                var markerL = new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map,
                    title: 'Localiza��o'
                });

                google.maps.event.addListener(markerL, 'click', function() {
                    infowindow.open(map,markerL);
                });


            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
</script>


<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>

<p class="editoria">Contato > Localização</p>

<input type="hidden" name="end" style="color:#000000;" id="end" value="Avenida General Osorio, 1840 Sorocaba, 18060-502, Brazil" />
<input type="hidden" name="endereco" id="endereco" value="<b>UNITEN General Osório</b><br>Avenida General Osório, 1.840 - Altos do Trujillo- CEP 18060-502 - Sorocaba/SP " />

<input type="hidden" name="end2" style="color:#000000;" id="end2" value="Avenida Bonifácio de Oliveira Cassu, 751 Sorocaba, 18103-100, Brazil" />
<input type="hidden" name="endereco2" id="endereco2" value="<b>UNITEN Éden</b><br>Avenida Bonifácio de Oliveira Cassu, 751 - Éden - Sorocaba/SP " />

<div id="map" style="width:100%; height:400px; color:#000000;"></div>