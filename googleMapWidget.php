<?
class googleMapWidget extends CWidget{
    public $adress, $zoom=11, $width='100%', $height='200px';
    public function run()
    {
        Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places');
        Yii::app()->clientScript->registerCss(__CLASS__.'_css',"
            #map_canvas{
                width:{$this->width};
                height:{$this->height};
            }
        ");
        Yii::app()->clientScript->registerScript(__CLASS__.'_js',"
            var map, marker;
            function initialize() {
                var myLatlng = new google.maps.LatLng(50.471491,30.519805);
                var myOptions = {
                    zoom: {$this->zoom},
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
                codeAddress('{$this->adress}');
                
            }
            function codeAddress(address) {
                if(address){
                  var geocoder = new google.maps.Geocoder();
                  geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      map.setCenter(results[0].geometry.location);
                      marker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map
                      });
                    } else {
                      return false;
                    }
                  });
                }
            }
            initialize();
        ");
        echo '<div id="map_canvas"></div>';
    }
    
}
?>