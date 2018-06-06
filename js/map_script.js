var map;
var lineRouteNotTransfer, lineRouteFrom, lineRouteTo;
var routeNum;
var directNum;
var stopsForInputs;
var markerMyLocation;
var markerStart;
var markerTransferFrom;
var markerTransferTo;
var markerFinish;
var infoWindow;
var latlngbounds;
var locations = [];
var directionsServiceNotTransfer, directionsDisplayNotTransfer;
var directionsServiceFrom, directionsDisplayFrom;
var directionsServiceTo, directionsDisplayTo;

$('#tabsMenu').on('change.zf.tabs', function() {

    if ($('#timetable:visible').length) {
        console.log('Tab 3 is now visible!');
    }

});
var stopIcon = "../img/stop.png";

function initMap() {
    directionsServiceNotTransfer = new google.maps.DirectionsService();
    directionsDisplayNotTransfer = new google.maps.DirectionsRenderer({
        suppressMarkers: true
    });
    GetAllStops();
    var mapProp = {
        center: new google.maps.LatLng(50.316, 30.299),
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

function getLocation() {
    removeMarkerMyLocation();
    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(function(position) {

            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            markerMyLocation = new google.maps.Marker({
                position: pos,
                draggable: true,
                animation: google.maps.Animation.DROP,
                map: map,
                icon: "../img/man.png",
                zIndex: 11,
                title: "Ви тут"
            });
            map.setCenter(pos);
            map.setZoom(17);
            map.panTo(pos);
        });
    } else {
        var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        markerMyLocation = new google.maps.Marker({
            position: pos,
            draggable: true,
            animation: google.maps.Animation.DROP,
            map: map,
            icon: "../img/man.png",
            zIndex: 11,
            title: "Ви тут"
        });
        map.setCenter(pos);
        map.setZoom(17);
        map.panTo(pos);
    }
}


var $wrap = $('.wrap').show().scrollLeft(100);
$('.show-left').click(function() {
    $wrap.animate({
        scrollLeft: 0
    }, 200);
});
$('.show-right').click(function() {
    $wrap.animate({
        scrollLeft: 200
    }, 200);
});
$('.hide-borders,.right-border,.left-border').click(function() {
    $wrap.animate({
        scrollLeft: 100
    }, 200);
});
$(document).ready(function() {
    var clicked = false;
    $('#user').hide();

    $('#btn-form').on('click', function() {
        clicked = !clicked;
        if (!clicked) {
            $('#user').hide();
        } else {
            $('#user').show();
        }
    });
});
$(function() {
    $("#startInput").autocomplete({
            minLength: 0,
            source: function(request, response) {
                $.ajax({
                    url: "js/stops.json",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            focus: function(event, ui) {
                $("#startInput").val(ui.item.title);
                return false;
            },
            select: function(event, ui) {
                $("#startInput").val(ui.item.title);
                $("#IDpointA").val(ui.item.id);
                return false;
            }
        })
        .data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li></li>")
                .data("ui-autocomplete-item", item)
                .append("<a> " + item.title + "</a>")
                .appendTo(ul);
        };
});
$(function() {
    $("#finishInput").autocomplete({
            minLength: 0,
            source: function(request, response) {
                $.ajax({
                    url: "js/stops.json",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            focus: function(event, ui) {
                $("#finishInput").val(ui.item.title);
                return false;
            },
            select: function(event, ui) {
                $("#finishInput").val(ui.item.title);
                $("#IDpointB").val(ui.item.id);

                return false;
            }
        })
        .data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li></li>")
                .data("ui-autocomplete-item", item)
                .append("<a> " + item.title + "</a>")
                .appendTo(ul);
        };
});
//path = [[50.3165912, 30.2995321], [50.3133146, 30.2989009], [50.3120086, 30.3047984], [50.3094448, 30.3025443], [50.3068896, 30.3010787], [50.3066838, 30.3034754], [50.3041261, 30.3093521]];
function checkWorkOrWeekend() {
    var sw = document.getElementById("switchWorkWeekend").checked;
    var weekend;
    if (sw == true) {
        return weekend = 1;
    } else {
        return weekend = 0;
    }
}

function GetAllStops() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
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
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("infoWindow").innerHTML += this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getNumberOfStopID.php?s=" + id_stop, true);
    xmlhttp.send();
}

function checkTransfer(title_stop, routeF, routeS) {
    for (var i = 0; i < locations.length; i++) {
        if (locations[i].title == title_stop) {
            infoWindow.setContent("<div id='infoWindow'>Ост: " + locations[i].title + " <br> Пересадка з <b>" + routeF + "</b> на <b>" + routeS + "</b></div>");
            infoWindow.open(map, locations[i]);
            map.setZoom(17);
            map.panTo(locations[i].position);
        }
    }
}

function showStopInputA() {
    var id = document.getElementById('IDpointA').value;
    if (id == null) {
        return;
    }
    for (var i = 0; i < locations.length; i++) {
        if (locations[i].store_id == id) {
            infoWindow.setContent("<div id='searchWindow'>Зупинка: <strong>" + locations[i].title + "</strong></div>");
            infoWindow.open(map, locations[i]);
            map.setZoom(17);
            map.panTo(locations[i].position);
        }
    }
}

function showStopInputB() {
    var id = document.getElementById('IDpointB').value;
    if (id == null) {
        return;
    }
    for (var i = 0; i < locations.length; i++) {
        if (locations[i].store_id == id) {
            infoWindow.setContent("<div id='searchWindow'>Зупинка: <strong>" + locations[i].title + "</strong></div>");
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
            store_id: data.id,
            title: data.title
        });
        locations.push(marker);
        (function(marker, data) {
            google.maps.event.addListener(marker, "click", function(e) {
                GetNumberByStop(data.id);
                infoWindow.setContent("<div id='infoWindow' value='" + data.id + "'>" + "Ост: <b>" + data.title + "</b> (" + data.city + ")</div>");
                infoWindow.open(map, marker);
            });
        })(marker, data);
        latlngbounds.extend(marker.position);
    }
    var clusterStyles = [{
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

function Polyline(response) {

    var markers = JSON.parse(response);
    var coordinates = [];
    var waypoint = [];
    for (var i = 0; i < markers.length; i++) {
        var data = markers[i]
        coordinates.push(new google.maps.LatLng(data.lat, data.lng));
    }
    /*  if (lineRoute != null) {
          removePolyLine();
      } */
    for (var i = 1; i < coordinates.length - 1; i++) {
        if (i != 23) {
            i++;
            waypoint.push({
                location: coordinates[i],
                stopover: true
            });
        } else {
            break;
        }
    }
    lineRouteNotTransfer = new google.maps.Polyline({
        path: coordinates,
        geodesic: true,
        strokeColor: getRandomColor(),
        strokeOpacity: 0.8,
        strokeWeight: 5
    })
    directionsServiceNotTransfer.route({
        origin: coordinates[0],
        destination: coordinates[coordinates.length - 1],
        waypoints: waypoint,
        optimizeWaypoints: true,
        travelMode: 'DRIVING'
    }, function(result, status) {
        if (status == 'OK') {
            directionsDisplayNotTransfer.setDirections(result);
            directionsDisplayNotTransfer.setMap(map);
        }
    });

    markerStart = new google.maps.Marker({
        position: coordinates[0],
        map: map,
        icon: "../img/marker.png",
        zIndex: 10
    });
    markerFinish = new google.maps.Marker({
        position: coordinates[coordinates.length - 1],
        map: map,
        icon: "../img/marker.png",
        zIndex: 10
    });
    markerStart.setMap(map);
    markerFinish.setMap(map);
    // lineRoute.setMap(map);
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < coordinates.length; i++) {
        bounds.extend(coordinates[i]);
    }
    bounds.getCenter();
    map.fitBounds(bounds);
}

function PolylineOneTransferFrom(response) {
    if (directionsDisplayFrom != null) {
        lineRouteFrom.setMap(null);
        directionsDisplayFrom.setMap(null);
        markerStart.setMap(null);
        markerTransferFrom.setMap(null);
    }
    directionsServiceFrom = new google.maps.DirectionsService();
    directionsDisplayFrom = new google.maps.DirectionsRenderer({
        suppressMarkers: true
    });
    var markers = JSON.parse(response);
    var coordinates = [];
    var waypoint = [];
    for (var i = 0; i < markers.length; i++) {
        var data = markers[i]
        coordinates.push(new google.maps.LatLng(data.lat, data.lng));
    }
    /*  if (lineRoute != null) {
          removePolyLine();
      } */
    for (var i = 1; i < coordinates.length - 1; i++) {
        if (i != 23) {
            i++;
            waypoint.push({
                location: coordinates[i],
                stopover: true
            });
        } else {
            break;
        }
    }
    lineRouteFrom = new google.maps.Polyline({
        path: coordinates,
        geodesic: true,
        strokeColor: getRandomColor(),
        strokeOpacity: 0.8,
        strokeWeight: 5
    })
    directionsServiceFrom.route({
        origin: coordinates[0],
        destination: coordinates[coordinates.length - 1],
        waypoints: waypoint,
        optimizeWaypoints: true,
        travelMode: 'DRIVING'
    }, function(result, status) {
        if (status == 'OK') {
            directionsDisplayFrom.setDirections(result);
            directionsDisplayFrom.setMap(map);
        }
    });

    markerStart = new google.maps.Marker({
        position: coordinates[0],
        map: map,
        icon: "../img/marker.png",
        zIndex: 10
    });
    markerTransferFrom = new google.maps.Marker({
        position: coordinates[coordinates.length - 1],
        map: map,
        icon: "../img/marker-transfer-from.png",
        zIndex: 10
    });
    markerStart.setMap(map);
    markerTransferFrom.setMap(map);
    // lineRoute.setMap(map);
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < coordinates.length; i++) {
        bounds.extend(coordinates[i]);
    }
    bounds.getCenter();
    map.fitBounds(bounds);
}

function PolylineOneTransferTo(response) {
    if (directionsDisplayTo != null) {
        lineRouteTo.setMap(null);
        directionsDisplayTo.setMap(null);
        markerTransferTo.setMap(null);
        markerFinish.setMap(null);
    }
    directionsServiceTo = new google.maps.DirectionsService();
    directionsDisplayTo = new google.maps.DirectionsRenderer({
        suppressMarkers: true
    });
    var markers = JSON.parse(response);
    var coordinates = [];
    var waypoint = [];
    for (var i = 0; i < markers.length; i++) {
        var data = markers[i]
        coordinates.push(new google.maps.LatLng(data.lat, data.lng));
    }
    /*  if (lineRoute != null) {
          removePolyLine();
      } */
    for (var i = 1; i < coordinates.length - 1; i++) {
        if (i != 23) {
            i++;
            waypoint.push({
                location: coordinates[i],
                stopover: true
            });
        } else {
            break;
        }
    }
    lineRouteTo = new google.maps.Polyline({
        path: coordinates,
        geodesic: true,
        strokeColor: getRandomColor(),
        strokeOpacity: 0.8,
        strokeWeight: 5
    })
    directionsServiceTo.route({
        origin: coordinates[0],
        destination: coordinates[coordinates.length - 1],
        waypoints: waypoint,
        optimizeWaypoints: true,
        travelMode: 'DRIVING'
    }, function(result, status) {
        if (status == 'OK') {
            directionsDisplayTo.setDirections(result);
            directionsDisplayTo.setMap(map);
        }
    });

    markerTransferTo = new google.maps.Marker({
        position: coordinates[0],
        map: map,
        icon: "../img/marker-transfer-to.png",
        zIndex: 10
    });
    markerFinish = new google.maps.Marker({
        position: coordinates[coordinates.length - 1],
        map: map,
        icon: "../img/marker.png",
        zIndex: 10
    });
    markerStart.setMap(map);
    markerTransferTo.setMap(map);
    // lineRoute.setMap(map);
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
    xmlhttp.open("GET", "php/getCity.php", true);
    xmlhttp.send();
}

function showNumbers(city) {
    if (city == "" || lineRouteTo != null) {
        removePolyline();
        removeMarkerAPolyline();
        removeMarkerBPolyline();
        hoverBlockNumbers();
        hoverBlockDirection();
        hoverBlockWeekend();
        hoverBlockAllTimesStart();
        hoverBlockDetailsOfRoute();
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (lineRouteTo != null) {
                removePolyline();
                removeMarkerAPolyline();
                removeMarkerBPolyline();
            }
            showBlockNumbers();
            hoverBlockDirection();
            hoverBlockWeekend();
            hoverBlockAllTimesStart();
            hoverBlockDetailsOfRoute();
            document.getElementById("numbers").innerHTML = "";
            document.getElementById("numbers").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getNumbers.php?c=" + city, true);
    xmlhttp.send();
}

function ShowDirection(id_route) {
    routeNum = id_route;
    if (id_route == "") {
        document.getElementById("direction").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            showBlockDirection();
            showBlockWeekend();
            showBlockAllTimesStart();
            showBlockDetailsOfRoute();
            document.getElementById("timedeparture").innerHTML = "";
            document.getElementById("direction").innerHTML = this.responseText;
            document.getElementById("direction").onchange();
            if (!document.getElementById('saveRouteUser')) {
                document.getElementById('saveRouteUser').value = id_route;
            }

        }
    };
    xmlhttp.open("GET", "php/getDirection.php?r=" + id_route, true);
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
    if (id_direction == "") {
        document.getElementById("timedeparture").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("timedeparture").innerHTML = "";
            document.getElementById("timedeparture").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getTimeDeparture.php?d=" + id_direction + "&w=" + checkWorkOrWeekend(), true);
    xmlhttp.send();

}

function ShowInfoAboutRoute(id_route) {
    if (id_route == "") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("infoRouteDiv").innerHTML = "";
            document.getElementById("infoRouteDiv").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getInfoAboutRoute.php?r=" + id_route, true);
    xmlhttp.send();
}

function getPolylineForRoute(id_route, id_direction) {
    if (id_route == "") {
        return;
    }
    if (id_direction == "") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (lineRouteNotTransfer != null) {
                removePolyline();
                removeMarkerAPolyline();
                removeMarkerBPolyline();
            }
            Polyline(this.responseText);
        }
    };
    xmlhttp.open("GET", "php/getPolylineRoute.php?r=" + id_route + "&d=" + id_direction, true);
    xmlhttp.send();
}

function toInputA(id_stop, id_direction) {
    if (id_stop == "" || id_direction == "") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            removeAllResults();
            document.getElementById("IDpointA").value = id_stop;
            document.getElementById("IDDir").value = id_direction;
            document.getElementById("startInput").value = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getStopToInputA.php?s=" + id_stop, true);
    xmlhttp.send();
}

function toInputB(id_stop) {
    if (id_stop == "") {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            removeAllResults();
            document.getElementById("IDpointB").value = id_stop;
            document.getElementById("finishInput").value = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getStopToInputA.php?s=" + id_stop, true);
    xmlhttp.send();
}

function getRouteNotTransfer() {
    var id_stopF = document.getElementById("IDpointA").value;
    var id_stopS = document.getElementById("IDpointB").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            removeAllResults();
            if (!$.trim(this.responseText)) {
                getRouteOneTransfer();
            } else {
                document.getElementById("resultRoute").innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("GET", "php/getRouteNotTransfer.php?F=" + id_stopF + "&S=" + id_stopS, true);
    xmlhttp.send();
}

function getPolylineForNotTransfer(id_route, id_start_stop, id_finish_stop) {
    if (id_route == null || id_start_stop == null || id_finish_stop == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (lineRouteNotTransfer != null) {
                removePolyline();
                removeMarkerAPolyline();
                removeMarkerBPolyline();
            }
            if (lineRouteFrom != null) {
                removePolylineFrom();
                removeMarkerAPolyline();
                removeMarkerBPolyline();
                removeMarkerTFromPolyline();
                removeMarkerTToPolyline();
            }
            if (lineRouteTo != null) {
                removePolylineTo();
                removeMarkerAPolyline();
                removeMarkerBPolyline();
                removeMarkerTFromPolyline();
                removeMarkerTToPolyline();
            }
            if (this.responseText == "[]" || this.responseText == null) {
                alert("Нажаль показати маршрут на карті неможливо. Перевірте чи відповідають зупинки напрямку.");
            } else {
                Polyline(this.responseText);
            }

        }
    };
    xmlhttp.open("GET", "php/getPolylineForNotTransfer.php?r=" + id_route + "&f=" + id_start_stop + "&s=" + id_finish_stop, true);
    xmlhttp.send();
}

function getRouteOneTransfer() {
    var id_stopF = document.getElementById("IDpointA").value;
    var id_stopS = document.getElementById("IDpointB").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "") {
                document.getElementById("resultRoute").innerHTML = "На жаль, немає результатів за заданим маршрутом"
                return;
            }
            document.getElementById("resultRoute").innerHTML += this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getRouteOneTransfer.php?F=" + id_stopF + "&S=" + id_stopS, true);
    xmlhttp.send();
}

function getPolylineForOneTransferFrom(id_routeF, id_routeS, id_from_stop, id_to_stop, id_start_stop, id_finish_stop) {
    if (id_routeF == null || id_start_stop == null || id_from_stop == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (lineRouteNotTransfer != null) {
                removePolyline();
                removeMarkerAPolyline();
                removeMarkerBPolyline();
            }
            if (lineRouteFrom != null) {
                removePolylineFrom();
                removeMarkerAPolyline();
                removeMarkerBPolyline();
                removeMarkerTFromPolyline();
                removeMarkerTToPolyline();
            }
            if (lineRouteTo != null) {
                removePolylineTo();
                removeMarkerAPolyline();
                removeMarkerBPolyline();
                removeMarkerTFromPolyline();
                removeMarkerTToPolyline();
            }
            PolylineOneTransferFrom(this.responseText);
            //checkStopTransfer(id_from_stop,id_to_stop);
            getPolylineForOneTransferTo(id_routeS, id_to_stop, id_finish_stop);
        }
    };
    xmlhttp.open("GET", "php/getPolylineForOneTransferFrom.php?route=" + id_routeF + "&start=" + id_start_stop + "&from=" + id_from_stop, true);
    xmlhttp.send();
}

function getPolylineForOneTransferTo(id_routeS, id_to_stop, id_finish_stop) {
    if (id_routeS == null || id_to_stop == null || id_finish_stop == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            PolylineOneTransferTo(this.responseText);
        }
    };
    xmlhttp.open("GET", "php/getPolylineForOneTransferTo.php?route=" + id_routeS + "&finish=" + id_finish_stop + "&to=" + id_to_stop, true);
    xmlhttp.send();
}

function getRouteByUser(id) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('user-numbers').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "php/getRoutesByUser.php?id=" + id, true);
    xmlhttp.send();
}

function deleteRouteByUser(id) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            document.getElementById('getUserRoute').onclick();
        }
    };
    xmlhttp.open("GET", "php/deleteRouteByUser.php?id=" + id, true);
    xmlhttp.send();
}

function saveRouteUser(id, route) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            getRouteByUser(id);
        }
    };
    xmlhttp.open("GET", "php/saveRouteUser.php?id=" + id + "&r=" + route, true);
    xmlhttp.send();
}

function removePolyline() {
    if (lineRouteNotTransfer != null) {
        lineRouteNotTransfer.setMap(null);
        directionsDisplayNotTransfer.setMap(null);
    }
}

function removePolylineFrom() {
    if (lineRouteFrom != null) {
        lineRouteFrom.setMap(null);
        directionsDisplayFrom.setMap(null);
    }
}

function removePolylineTo() {
    if (lineRouteTo != null) {
        lineRouteTo.setMap(null);
        directionsDisplayTo.setMap(null);
    }
}

function removeMarkerMyLocation() {
    if (markerMyLocation != null) {
        markerMyLocation.setMap(null);
    }
}

function removeMarkerAPolyline() {
    if (markerStart != null) {
        markerStart.setMap(null);
    }
}

function removeMarkerTFromPolyline() {
    if (markerTransferFrom != null) {
        markerTransferFrom.setMap(null);
    }
}

function removeMarkerTToPolyline() {
    if (markerTransferTo != null) {
        markerTransferTo.setMap(null);
    }
}

function removeMarkerBPolyline() {
    if (markerFinish != null) {
        markerFinish.setMap(null);
    }
}

function removeAllResults() {
    document.getElementById('resultRoute').innerHTML = '';
}

function hoverBlockNumbers() {
    var elems = document.getElementsByClassName('allNumbersRoutes');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'none';
}

function showBlockNumbers() {
    var elems = document.getElementsByClassName('allNumbersRoutes');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'block';
}

function hoverBlockDirection() {
    var elems = document.getElementsByClassName('direction');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'none';
}

function showBlockDirection() {
    var elems = document.getElementsByClassName('direction');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'block';
}

function hoverBlockWeekend() {
    var elems = document.getElementsByClassName('weekend');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'none';
}

function showBlockWeekend() {
    var elems = document.getElementsByClassName('weekend');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'block';
}

function hoverBlockAllTimesStart() {
    var elems = document.getElementsByClassName('allTimesStart');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'none';
}

function showBlockAllTimesStart() {
    var elems = document.getElementsByClassName('allTimesStart');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'block';
}

function hoverBlockDetailsOfRoute() {
    var elems = document.getElementsByClassName('detailOfRoute');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'none';
}

function showBlockDetailsOfRoute() {
    var elems = document.getElementsByClassName('detailOfRoute');
    for (var i = 0; i < elems.length; i++) elems[i].style.display = 'block';
}