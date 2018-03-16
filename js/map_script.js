var map;
var lineRoute;
var routeNum;
var directNum;
var markerStart;
var markerFinish;
var locations = [];
var infoWindow;
var latlngbounds;
$('#tabsMenu').on('change.zf.tabs', function() {

  if($('#timetable:visible').length){
    console.log('Tab 3 is now visible!');
  }

});
var stopIcon = "../img/stop.png";
function initMap(){
    GetAllStops();
    var mapProp = {
        center: new google.maps.LatLng(50.3165912, 30.2995321),
        disableDefaultUI: true,
        zoomControl: true,
        zoom: 17,
        clickableIcons: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    infoWindow = new google.maps.InfoWindow();
    latlngbounds = new google.maps.LatLngBounds();
    map = new google.maps.Map(document.getElementById('map'), mapProp);
    var geoloccontrol = new klokantech.GeolocationControl(map, 17);
    var bounds = new google.maps.LatLngBounds();
    map.fitBounds(bounds);
      }
function getRandomColor() {
  var letters = '0123489ABC';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}
var $wrap = $('.wrap').show().scrollLeft(100);
$('.show-left').click(function () {
    $wrap.animate({
        scrollLeft: 0
    }, 200);
});
$('.show-right').click(function () {
    $wrap.animate({
        scrollLeft: 200
    }, 200);
});
$('.hide-borders,.right-border,.left-border').click(function () {
    $wrap.animate({
        scrollLeft: 100
    }, 200);
});
      //path = [[50.3165912, 30.2995321], [50.3133146, 30.2989009], [50.3120086, 30.3047984], [50.3094448, 30.3025443], [50.3068896, 30.3010787], [50.3066838, 30.3034754], [50.3041261, 30.3093521]];

function checkWorkOrWeekend() {
    var sw = document.getElementById("switchWorkWeekend").checked;
    var weekend;
    if (sw==true) {
        return weekend = 1;
    }
    else{
        return weekend = 0;
    }
}
function GetAllStops() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            setMarkers(this.responseText);
        }
    };
    xmlhttp.open("GET", "php/getAllStops.php", true);
    xmlhttp.send();
}
function GetNumberByStop(id_stop) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("infoWindow").innerHTML += this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getNumberOfStopID.php?s="+id_stop, true);
    xmlhttp.send();
}
function checkTransfer(title_stop, routeF, routeS){
    for (var i = 0; i < locations.length; i++) {
        if(locations[i].title == title_stop){
            infoWindow.setContent("<div id='infoWindow'>Ост: " + locations[i].title + " <br> Пересадка з <b>"+routeF+"</b> на <b>"+routeS+"</b></div>");
            infoWindow.open(map, locations[i]);
            map.setZoom(17);
            map.panTo(locations[i].position);
                }
            }
}
function setMarkers(response) {
    var markers = JSON.parse(response); 
        for (var i = 0; i < markers.length; i++) {
            var data = markers[i]
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: stopIcon,
                title: data.title
            });
            locations.push(marker);
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    GetNumberByStop(data.id);
                    infoWindow.setContent("<div id='infoWindow' value='"+data.id+"'>" + "Ост: <b>" + data.title + "</b> (" + data.city + ")</div>");
                    infoWindow.open(map, marker);
                });
            })(marker, data);
            latlngbounds.extend(marker.position);
        }
        var clusterStyles = [
          {
            textColor: 'white',
            textSize: 8,
            url: '../img/smallmarkerclusterer.png',
            height: 24,
            width: 24
          },
         {
            textColor: 'white',
            textSize: 8,
            url: '../img/mediummarkerclusterer.png',
            height: 24,
            width: 24
          },
         {
            textColor: 'white',
            textSize: 8,
            url: '../img/largemarkerclusterer.png',
            height: 24,
            width: 24
          }
        ];
        var mcoptions = {   
                gridSize: 50, 
                maxZoom: 14,
                styles: clusterStyles
                //imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        }
        var markerCluster = new MarkerClusterer(map, locations, mcoptions);
        var bounds = new google.maps.LatLngBounds();
        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);

}
 function removePolyLine() {  
    lineRoute.setMap(null);  
 }
 function removeMarkerStart() {  
    markerStart.setMap(null);  
 }
 function removeMarkerFinish() {  
    markerFinish.setMap(null);  
 }

function Polyline(response) {
    var markers = JSON.parse(response);
    var coordinates = [];
    for (var i = 0; i < markers.length; i++) {
        var data = markers[i]
        coordinates.push(new google.maps.LatLng(data.lat, data.lng));
    } 
  /*  if (lineRoute != null) {
        removePolyLine();
    } */
    if (markerStart != null) {
        removeMarkerStart();
    }
    if (markerFinish != null) {
        removeMarkerFinish();
    }
    lineRoute = new google.maps.Polyline({
        path: coordinates,
        geodesic: true,
        strokeColor: getRandomColor(),
        strokeOpacity: 0.8,
        strokeWeight: 5
    })
    markerStart = new google.maps.Marker({
        position: coordinates[0],
        map: map,
        icon: "../img/marker-a.png",
        zIndex: 10
    });
    markerFinish = new google.maps.Marker({
        position: coordinates[coordinates.length - 1],
        map: map,
        icon: "../img/marker-b.png",
        zIndex: 10
    });
    markerStart.setMap(map);
    markerFinish.setMap(map);
    lineRoute.setMap(map);
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < coordinates.length; i++) {
      bounds.extend(coordinates[i]);
    }
    bounds.getCenter();
    map.fitBounds(bounds);
}

function showCity() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("city").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","php/getCity.php",true);
        xmlhttp.send();
}
function showNumbers(city){
    if (city=="") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("numbers").innerHTML = "";
            document.getElementById("numbers").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getNumbers.php?c="+city, true);
    xmlhttp.send();
}
function ShowDirection(id_route){
    routeNum = id_route;
    if (id_route=="") {
        document.getElementById("direction").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("timedeparture").innerHTML = "";
            document.getElementById("direction").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getDirection.php?r="+id_route, true);
    xmlhttp.send();
    ShowInfoAboutRoute(id_route);
}

function change() {
    ShowTimeDeparture(directNum);
}

function ShowTimeDeparture(id_direction) {
    directNum = id_direction;
    checkWorkOrWeekend();
   // GetCoordinatesForPolyline(routeNum, id_direction);
    if (id_direction=="") {
        document.getElementById("timedeparture").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("timedeparture").innerHTML = "";
            document.getElementById("timedeparture").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getTimeDeparture.php?d="+id_direction +"&w=" + checkWorkOrWeekend(), true);
    xmlhttp.send();
    
}
function ShowInfoAboutRoute(id_route) {
    if (id_route=="") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("infoRouteDiv").innerHTML = "";
            document.getElementById("infoRouteDiv").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getInfoAboutRoute.php?r="+id_route, true);
    xmlhttp.send();
}


function getPolylineForRoute(id_route, id_direction) {
    if (id_route=="") {
        return;
    }
    if (id_direction=="") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            Polyline(this.responseText);
        }
    };
    xmlhttp.open("GET", "php/getPolylineRoute.php?r="+id_route+"&d="+id_direction, true);
    xmlhttp.send();
}


function toInputA(id_stop) {
    if (id_stop=="") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("IDpointA").value = id_stop;
            document.getElementById("startInput").value = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getStopToInputA.php?s="+id_stop, true);
    xmlhttp.send();
    }
 function toInputB(id_stop) {
    if (id_stop=="") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("IDpointB").value = id_stop;
            document.getElementById("finishInput").value = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getStopToInputA.php?s="+id_stop, true);
    xmlhttp.send();
}
function getRouteNotTransfer() {
    var id_stopF = document.getElementById("IDpointA").value;
    var id_stopS = document.getElementById("IDpointB").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("resultRoute").innerHTML = this.responseText;
            getRouteOneTransfer();
        }
    };
    xmlhttp.open("GET", "php/getRouteNotTransfer.php?F="+id_stopF+"&S="+id_stopS, true);
    xmlhttp.send();
}

function getRouteOneTransfer() {
    var id_stopF = document.getElementById("IDpointA").value;
    var id_stopS = document.getElementById("IDpointB").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("resultRoute").innerHTML += this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getRouteOneTransfer.php?F="+id_stopF+"&S="+id_stopS, true);
    xmlhttp.send();
}
function getRouteTwoTransfer() {
    var id_stopF = document.getElementById("IDpointA").value;
    var id_stopS = document.getElementById("IDpointB").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("resultRoute").innerHTML += this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getRouteTwoTransfer.php?F="+id_stopF+"&S="+id_stopS, true);
    xmlhttp.send();
}