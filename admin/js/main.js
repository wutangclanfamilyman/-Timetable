// Map scripts
var map, pr, tm;
var markers = [];
pr = 1;
tm = 4;
st = 1;

function initMap() {
    var mapProp = {
        center: new google.maps.LatLng(50.316, 30.299),
        disableDefaultUI: true,
        zoomControl: true,
        zoom: 15,
        clickableIcons: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map'), mapProp);
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function stop_on_map(latitude, longitude) {
    clearMarkers();
    var position = new google.maps.LatLng({
        lat: parseFloat(latitude),
        lng: parseFloat(longitude)
    });
    var marker = new google.maps.Marker({
        position: position,
        map: map,
        title: 'Here'
    });
    markers.push(marker);
    showMarkers();
    var bounds = new google.maps.LatLngBounds();
    bounds.extend(position);
    map.fitBounds(bounds);
    map.setZoom(18);
}

function showStopFromAddStop() {
    clearMarkers();
    latitude = document.getElementById('add_stop_lat').value;
    longitude = document.getElementById('add_stop_lng').value;
    var position = new google.maps.LatLng({
        lat: parseFloat(latitude),
        lng: parseFloat(longitude)
    });
    var marker = new google.maps.Marker({
        position: position,
        map: map,
        title: 'Here'
    });
    markers.push(marker);
    showMarkers();
    var bounds = new google.maps.LatLngBounds();
    bounds.extend(position);
    map.fitBounds(bounds);
}

function showMarkers() {
    setMapOnAll(map);
}

function clearMarkers() {
    setMapOnAll(null);
    markers = [];
}
//***** INIT BODY *****\\
function init() {
    showCityToSelect();
    showCitysToTable();
    showRoutesToTable();
    showRouteToSelect();
}
//***** ADD DATA *****\\
// add city scripts
function addCityToDB() {
    var name = document.getElementById('name_add_city').value;
    if (name == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            clearAddInputCity();
            showCitysToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addCity.php?n=" + name, true);
    xmlhttp.send();
}
// add stop scripts
function addStopToDB() {
    var city = document.getElementById("add_stop_city").value;
    var name = document.getElementById("add_stop_name").value;
    var lat = document.getElementById("add_stop_lat").value;
    var lng = document.getElementById("add_stop_lng").value;
    if (city == null || lat == null || lng == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            clearAddInputStops();
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addStop.php?c=" + city + "&n=" + name + "&lat=" + lat + "&lng=" + lng, true);
    xmlhttp.send();
}
// add route to db scripts
function addRouteToDB() {
    var route = document.getElementById('add_number_route').value;
    if (route == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            clearAddInputRoute();
            showRoutesToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addRoute.php?r=" + route, true);
    xmlhttp.send();
}
// add route-by-city scripts
function addRouteByCity() {
    var route = document.getElementById('add_route-by-city-number').value;
    var city = $('select#add_route-by-city-citys').val();
    if (route == null || city == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            clearAddInputRouteByCity();
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addRouteByCity.php?R=" + route + "&C=" + city, true);
    xmlhttp.send();
}
// add direction of route scripts
function addDirectionOfRoute() {
    var route = document.getElementById('add_direction_route').value;
    var firstStop = document.getElementById('direct_start').value;
    var secondStop = document.getElementById('direct_finish').value;
    if (route == null || firstStop == null || secondStop == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            showDirectionsToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addDirection.php?R=" + route + "&F=" + firstStop + "&S=" + secondStop, true);
    xmlhttp.send();
}
// add complex route scripts
function addComplexRoute() {
    var route = document.getElementById('add-complex-route-routes').value;
    var direction = document.getElementById('add-complex-route-direction').value;
    var stops = [];
    var span = [];
    for (var i = 1; i <= pr; i++) {
        stops.push(document.getElementById('add-complex-route-stops' + i + '').value);
        span.push(document.getElementById('add-complex-route-span' + i + '').value);
    }
    if (route == null || direction == null || stops == null || span == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            removeValues();
            removeAllControls();
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addComplexRoute.php?R=" + route + "&D=" + direction + "&S=" + stops + "&P=" + span, true);
    xmlhttp.send();
}
// add time departure scripts
function addTimeDeparture() {
    var route = document.getElementById('add-time-departure-routes').value;
    var direction = document.getElementById('add-time-departure-direction').value;
    var weekend = checkWorkOrWeekend();
    var time = [];
    for (var i = 1; i <= tm; i++) {
        time.push(document.getElementById('add-time-departure-time' + i + '').value);
    }
    if (route == null || direction == null || time == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            //removeTimeValues();
            // removeAllTimeControls();
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addTimeDeparture.php?R=" + route + "&D=" + direction + "&W=" + weekend + "&T=" + time, true);
    xmlhttp.send();
}
// add info about route scripts
function addInfoAboutRoute() {
    var route = document.getElementById('route_for_info').value;
    var direct = document.getElementById('direct_for_info').value;
    var reverse = document.getElementById('reverse_for_info').value;
    var price = document.getElementById('price_for_info').value;
    var time = document.getElementById('time_for_info').value;
    if (route == null || direct == null || reverse == null || price == null || time == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addInfoAboutRoute.php?R=" + route + "&D=" + direct + "&RD=" + reverse + "&P=" + price + "&T=" + time, true);
    xmlhttp.send();
}
// add price for route scripts
function addPriceRoute() {
    var route = document.getElementById('route_for_price').value;
    var direct = document.getElementById('direct_for_price').value;
    var firstStop = document.getElementById('first_stop_for_price').value;
    var stops = [];
    var prices = [];
    if (route == null || direct == null || firstStop == null) {
        return;
    }
    for (var i = 1; i <= st; i++) {
        stops.push(document.getElementById('second_stop_for_price' + i + '').value);
        prices.push(document.getElementById('price_for_price' + i + '').value);
    }
    for (var i = 0; i <= stops.length; i++) {
        if (firstStop == stops[i]) {
            alert('Потрібно обирати різні зупинки!');
            return;
        }
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            //removePriceValues();
            //removeAllPriceControls() 
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addPriceRoute.php?R=" + route + "&D=" + direct + "&FS=" + firstStop + "&ST=" + stops + "&P=" + prices, true);
    xmlhttp.send();
}
// add price for transfer scripts
function addTransferRoute() {
    var routeFrom = document.getElementById('route_from_transfer').value;
    var routeTo = document.getElementById('route_to_transfer').value;
    var directFrom = document.getElementById('direct_from_transfer').value;
    var directTo = document.getElementById('direct_to_transfer').value;
    var stopFrom = document.getElementById('stop_from_transfer').value;
    var stopTo = document.getElementById('stop_to_transfer').value;
    if (routeFrom == null || routeTo == null || directFrom == null || directTo == null || stopFrom == null || stopTo == null) {
        return;
    }
    if (routeFrom == routeTo || directFrom == directTo) {
        alert("Не обирайте однакові дані");
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            showTransferByRouteToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Add Data/addTransferRoute.php?RF=" + routeFrom + "&RT=" + routeTo + "&DF=" + directFrom + "&DT=" + directTo + "&SF=" + stopFrom + "&ST=" + stopTo, true);
    xmlhttp.send();
}
//***** EDIT DATA *****\\
// edit city scripts
function EditCity() {
    var id = document.getElementById("ID_City_Edit").value;
    var name = document.getElementById("name_edit_city").value;
    if (name == null || id == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            disabledEditInputCity();
            showCitysToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Edit Data/editCity.php?ID=" + id + "&Name=" + name, true);
    xmlhttp.send();
}
// edit stops scripts
function toEditStop() {
    var id = document.getElementById("ID_Stop_Edit").value;
    var name = document.getElementById("edit_stop_name").value;
    var lat = document.getElementById("edit_stop_lat").value;
    var lng = document.getElementById("edit_stop_lng").value;
    if (name == null || lat == null || lng == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            disabledEditInputStops();
        }
    };
    xmlhttp.open("GET", "../admin/php/Edit Data/editStop.php?ID=" + id + "&Name=" + name + "&lat=" + lat + "&lng=" + lng, true);
    xmlhttp.send();
}
// edit route number
function toEditNumberRoute() {
    var id = document.getElementById("ID_Route_Edit").value;
    var number = document.getElementById("edit_number_route").value;
    if (name == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            disabledEditInputRoutes();
            showRoutesToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Edit Data/editRoute.php?ID=" + id + "&Number=" + number, true);
    xmlhttp.send();
}

function toEditComplexRoute() {
    var id = document.getElementById("edit-id-complex-route").value;
    var span = document.getElementById("edit-input-span").value;
    if (id == null || span == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            disabledEditInputComplexRoute();
            showComplexRouteToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Edit Data/editComplexRoute.php?ID=" + id + "&Span=" + span, true);
    xmlhttp.send();
}
// edit route info
function toEditInfoAboutRoute() {
    var id = document.getElementById("edit_id_info").value;
    var id_route = document.getElementById("edit_route_for_info").value;
    var id_direct = document.getElementById("edit_direct_for_info").value;
    var id_reverse = document.getElementById("edit_reverse_for_info").value;
    var time = document.getElementById("edit_time_for_info").value;
    var price = document.getElementById("edit_price_for_info").value;
    if (name == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            disabledEditInputInfoAboutRoute();
            showInfoAboutRouteToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Edit Data/editInfo.php?ID=" + id + "&Route=" + id_route + "&Direct=" + id_direct + "&Reverse=" + id_reverse + "&Time=" + time + "&Price=" + price, true);
    xmlhttp.send();
}
// edit route price
function toEditPriceRoute() {
    var id = document.getElementById("edit_id_price").value;
    var price = document.getElementById("edit_price_for_price").value;
    if (name == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            disabledEditInputPrice();
            showPriceByDirectonToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Edit Data/editPrice.php?ID=" + id + "&Price=" + price, true);
    xmlhttp.send();
}
//***** DELETE DATA *****\\
deleteStopFromComplexRoute
// delete stop from table
function deleteStopFromDB(id_stop) {
    if (id_stop == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
        }
    };
    xmlhttp.open("GET", "../admin/php/Delete Data/deleteStop.php?S=" + id_stop, true);
    xmlhttp.send();
}
// delete stop from complex route table
function deleteStopFromComplexRoute(id) {
    if (id == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            showComplexRouteToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Delete Data/deleteComplexRoute.php?ID=" + id, true);
    xmlhttp.send();
}
// delete stop from table
function deleteInfoAboutRouteFromDB(id_route) {
    if (id_route == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            showInfoAboutRouteToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Delete Data/deleteInfoAboutRoute.php?R=" + id_route, true);
    xmlhttp.send();
}
// delete price from table
function deletePriceFromDB(id_price) {
    if (id_price == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            showPriceByDirectonToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Delete Data/deletePrice.php?P=" + id_price, true);
    xmlhttp.send();
}
// delete direction from table
function deleteDirectionFromDB(id_direction) {
    if (id_direction == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            showDirectionsToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Delete Data/deleteDirection.php?D=" + id_direction, true);
    xmlhttp.send();
}

function deleteTransferFromDB(id_transfer) {
    if (id_transfer == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            showTransferByRouteToTable();
        }
    };
    xmlhttp.open("GET", "../admin/php/Delete Data/deleteTransfer.php?T=" + id_transfer, true);
    xmlhttp.send();
}
//***** GET DATA TO TABLE *****\\
// show city in table
function showCitysToTable() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table_citys").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getCitysToTable.php", true);
    xmlhttp.send();
}
// show stops in table scripts
function showStopsToTable(id_city) {
    if (id_city == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table_stops").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getStopsToTable.php?C=" + id_city, true);
    xmlhttp.send();
}
// show all routes to table
function showRoutesToTable() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table_routes").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getRoutesToTable.php", true);
    xmlhttp.send();
}
// show all direction to table
function showDirectionsToTable() {
    var route = document.getElementById('add_direction_route').value;
    if (route == null || route == "") {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table_directions").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getDirectionsToTable.php?R=" + route, true);
    xmlhttp.send();
}
// show route by city in table scripts
function showRouteByCityToTable(id_route) {
    if (id_route == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table-route-by-city").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getRouteByCityToTable.php?R=" + id_route, true);
    xmlhttp.send();
}
// show complex route in table scripts
function showComplexRouteToTable() {
    var id_direction = document.getElementById('all_direction_complex_route_table').value;
    if (id_direction == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table_complex_route").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getComplexRouteToTable.php?D=" + id_direction, true);
    xmlhttp.send();
}
// show info about route to table
function showInfoAboutRouteToTable() {
    var id_route = document.getElementById('all_route_info_table').value;
    if (id_route == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table_info_about_route").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getInfoAboutRouteToTable.php?R=" + id_route, true);
    xmlhttp.send();
}
// show time departure to table
function showTimeDepartureToTable() {
    var id_direction = document.getElementById('all_direction_time_departure').value;
    if (id_direction == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("add-time-departure-table-weekend").disabled = false;
            document.getElementById("table_time_departure").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getTimeDepartureToTable.php?D=" + id_direction + "&W=" + checkWorkOrWeekendToTable(), true);
    xmlhttp.send();
}
// show price in table scripts
function showPriceByDirectonToTable() {
    var id_direction = document.getElementById('all_direction_price_table').value;
    if (id_direction == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table_price_of_route").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getPriceToTable.php?D=" + id_direction, true);
    xmlhttp.send();
}
// show transfer in table scripts
function showTransferByRouteToTable() {
    var id_route = document.getElementById('all_route_for_transfer_table').value;
    if (id_route == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table_transfer").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/Get Data to Table/getTransferToTable.php?R=" + id_route, true);
    xmlhttp.send();
}
//***** GET DATA FROM TABLE TO INPUTS *****\\
// get value from city table to edit form
function getValueCityFromTable() {
    document.getElementById('name_edit_city').disabled = false;
    document.getElementById('edit_city_button').disabled = false;
    var table = document.getElementById('table_citys');
    if (!document.getElementsByTagName || !document.createTextNode) return;
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
            document.getElementById('ID_City_Edit').value = table.rows[this.rowIndex].cells[0].innerHTML;
            document.getElementById('name_edit_city').value = table.rows[this.rowIndex].cells[1].innerHTML;
        }
    }
}
// get data from table in edit stop form
function getValueStopFromTable() {
    document.getElementById('edit_stop_name').disabled = false;
    document.getElementById('edit_stop_lat').disabled = false;
    document.getElementById('edit_stop_lng').disabled = false;
    document.getElementById('edit_stop_button').disabled = false;
    var table = document.getElementById('table_stops');
    if (!document.getElementsByTagName || !document.createTextNode) return;
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
            document.getElementById('ID_Stop_Edit').value = table.rows[this.rowIndex].cells[0].innerHTML;
            document.getElementById('edit_stop_city').value = table.rows[this.rowIndex].cells[1].innerHTML;
            document.getElementById('edit_stop_name').value = table.rows[this.rowIndex].cells[2].innerHTML;
            document.getElementById('edit_stop_lat').value = table.rows[this.rowIndex].cells[3].innerHTML;
            document.getElementById('edit_stop_lng').value = table.rows[this.rowIndex].cells[4].innerHTML;
        }
    }
}
// show data for edit form route
function getValueRouteFromTable() {
    document.getElementById('edit_number_route').disabled = false;
    document.getElementById('edit_route_button').disabled = false;
    var table = document.getElementById('table_routes');
    if (!document.getElementsByTagName || !document.createTextNode) return;
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
            document.getElementById('ID_Route_Edit').value = table.rows[this.rowIndex].cells[0].innerHTML;
            document.getElementById('edit_number_route').value = table.rows[this.rowIndex].cells[1].innerHTML;
        }
    }
}
// show data for edit form price
function getValuePriceFromTable() {
    document.getElementById('edit_price_for_price').disabled = false;
    document.getElementById('edit_price_button_edit').disabled = false;
    var table = document.getElementById('table_price_of_route');
    if (!document.getElementsByTagName || !document.createTextNode) return;
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
            document.getElementById('edit_id_price').value = table.rows[this.rowIndex].cells[0].innerHTML;
            document.getElementById('edit_first_stop_price').value = table.rows[this.rowIndex].cells[1].innerHTML;
            document.getElementById('edit_second_stop_price').value = table.rows[this.rowIndex].cells[2].innerHTML;
            document.getElementById('edit_price_for_price').value = table.rows[this.rowIndex].cells[3].innerHTML;
        }
    }
}
// show data for edit form complex route
function getValueComplexRouteFromTable() {
    document.getElementById('edit-input-span').disabled = false;
    document.getElementById('btn-edit-complex-route').disabled = false;
    var table = document.getElementById('table_complex_route');
    if (!document.getElementsByTagName || !document.createTextNode) return;
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
            document.getElementById('edit-id-complex-route').value = table.rows[this.rowIndex].cells[0].innerHTML;
            document.getElementById('edit-input-stop').value = table.rows[this.rowIndex].cells[1].innerHTML;
            document.getElementById('edit-input-priority').value = table.rows[this.rowIndex].cells[2].innerHTML;
            document.getElementById('edit-input-span').value = table.rows[this.rowIndex].cells[3].innerHTML;
        }
    }
}
// show data for edit form direction
function getValueDirectionFromTable(id_first_city, id_second_city, id_first_stop, id_second_stop) {
    var table = document.getElementById('table_directions');
    if (!document.getElementsByTagName || !document.createTextNode) return;
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
            document.getElementById('direct_city_A').value = id_first_city;
            document.getElementById('direct_city_A').onchange('direct_start', this.value);
            document.getElementById('direct_city_B').value = id_second_city;
            document.getElementById('direct_city_B').onchange('direct_finish', this.value);
        }
    }
    document.getElementById('direct_start').value = id_first_stop;
    document.getElementById('direct_finish').value = id_second_stop;
}
// show data for edit form info about route
function getValueInfoAboutRouteFromTable(id, id_route, time, price, date) {
    document.getElementById('edit_route_for_info').disabled = false;
    document.getElementById('edit_time_for_info').disabled = false;
    document.getElementById('edit_direct_for_info').disabled = false;
    document.getElementById('edit_reverse_for_info').disabled = false;
    document.getElementById('edit_price_for_info').disabled = false;
    document.getElementById('edit_info_button_edit').disabled = false;
    if (id_route == null || time == null || price == null || date == null) {
        return;
    }
    document.getElementById('edit_id_info').value = id;
    document.getElementById('edit_route_for_info').value = id_route;
    document.getElementById('edit_route_for_info').onchange(this.value);
    document.getElementById('edit_time_for_info').value = time;
    document.getElementById('edit_price_for_info').value = price;
    document.getElementById('edit_update_for_info').innerHTML = date;
}
//***** CLEAR DATA ELEMENTS *****\\
// clear form add city scripts
function clearAddInputCity() {
    document.getElementById('name_add_city').value = "";
}
// clear form add stop scripts
function clearAddInputStops() {
    document.getElementById('add_stop_name').value = "";
    document.getElementById('add_stop_lat').value = "";
    document.getElementById('add_stop_lng').value = "";
}
// clear input add route form
function clearAddInputRoute() {
    document.getElementById('add_number_route').value = "";
}
// clear input add routeByCity form
function clearAddInputRouteByCity() {
    document.getElementById('add_route-by-city-number').value = "";
}
// clear input add complex route form
function clearAddInputComplexRoute() {
    document.getElementById('add_route-by-city-number').value = "";
    document.getElementById('add_route-by-city-number').value = "";
    document.getElementById('add_route-by-city-number').value = "";
    document.getElementById('add_route-by-city-number').value = "";
    document.getElementById('add_route-by-city-number').value = "";
}
//***** GET DATA TO SELECT *****\\
// Show city in selects
function showCityToSelect() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("add_stop_city").innerHTML = this.responseText;
            document.getElementById("all_city_table").innerHTML = this.responseText;
            document.getElementById("add_route-by-city-citys").innerHTML = this.responseText;
            document.getElementById("direct_city_A").innerHTML = this.responseText;
            document.getElementById("direct_city_B").innerHTML = this.responseText;
            document.getElementById("add-complex-route-citys" + pr + "").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getCityToSelect.php", true);
    xmlhttp.send();
}
// Show stops in selects
function showStopToSelect(id_select, id_city) {
    if (id_city == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(id_select).disabled = false;
            document.getElementById(id_select).innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getStopToSelect.php?C=" + id_city, true);
    xmlhttp.send();
}
// Show stops in price selects
function showStopToPriceSelect() {
    var id_direction = document.getElementById('direct_for_price').value;
    if (id_direction == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (document.getElementById('first_stop_for_price').disabled == true) {
                document.getElementById('first_stop_for_price').disabled = false;
                document.getElementById("second_stop_for_price" + st + "").disabled = false;
                document.getElementById('first_stop_for_price').innerHTML = this.responseText;
                document.getElementById("second_stop_for_price" + st + "").innerHTML = this.responseText;
            }
            document.getElementById("second_stop_for_price" + st + "").disabled = false;
            document.getElementById("second_stop_for_price" + st + "").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getStopsToPriceSelect.php?D=" + id_direction, true);
    xmlhttp.send();
}
// Show stops in 'from' transfer selects
function showStopFromTransferSelect(id_direction) {
    if (id_direction == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('stop_from_transfer').disabled = false;
            document.getElementById('stop_from_transfer').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getStopsToPriceSelect.php?D=" + id_direction, true);
    xmlhttp.send();
}
// Show stops in 'to' transfer selects
function showStopToTransferSelect(id_direction) {
    if (id_direction == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('stop_to_transfer').disabled = false;
            document.getElementById('stop_to_transfer').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getStopsToPriceSelect.php?D=" + id_direction, true);
    xmlhttp.send();
}
// show routes to route-by-citys select
function showRouteToSelect() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('add_route-by-city-number').innerHTML = this.responseText;
            document.getElementById('check-route-rbc').innerHTML = this.responseText;
            document.getElementById('add_direction_route').innerHTML = this.responseText;
            document.getElementById('add-complex-route-routes').innerHTML = this.responseText;
            document.getElementById('add-time-departure-routes').innerHTML = this.responseText;
            document.getElementById('route_for_info').innerHTML = this.responseText;
            document.getElementById('all_route_info_table').innerHTML = this.responseText;
            document.getElementById('edit_route_for_info').innerHTML = this.responseText;
            document.getElementById('route_for_price').innerHTML = this.responseText;
            document.getElementById('edit_route_for_price').innerHTML = this.responseText;
            document.getElementById('all_route_complex_route_table').innerHTML = this.responseText;
            document.getElementById('all_route_price_table').innerHTML = this.responseText;
            document.getElementById('route_from_transfer').innerHTML = this.responseText;
            document.getElementById('route_to_transfer').innerHTML = this.responseText;
            document.getElementById('all_route_time_departure').innerHTML = this.responseText;
            document.getElementById('all_route_for_transfer_table').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getRoutesToSelect.php", true);
    xmlhttp.send();
}
// show directions to complex route select
function showDirectionsToSelect(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('add-complex-route-direction').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to complex route select for table
function showDirectionsToSelectForTable(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('all_direction_complex_route_table').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to info about route select
function showDirectionsToInfoSelect(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('direct_for_info').innerHTML = this.responseText;
            document.getElementById('reverse_for_info').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to info about route select
function showDirectionsToEditInfoSelect(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('edit_direct_for_info').innerHTML = this.responseText;
            document.getElementById('edit_reverse_for_info').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to time-departure select
function showDirectionsToTimeSelect(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('add-time-departure-direction').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to price select
function showDirectionsToPriceSelect(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('direct_for_price').disabled = false;
            document.getElementById('direct_for_price').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to price select
function showDirectionsToPriceSelectTable(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('all_direction_price_table').disabled = false;
            document.getElementById('all_direction_price_table').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to transfer 'from' select
function showDirectionsFromTransferSelect(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('direct_from_transfer').disabled = false;
            document.getElementById('direct_from_transfer').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to transfer 'to' select
function showDirectionsToTransferSelect(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('direct_to_transfer').disabled = false;
            document.getElementById('direct_to_transfer').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
// show directions to all time departure 'to' select
function showDirectionsToAllTimeSelect(id_route) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('all_direction_time_departure').disabled = false;
            document.getElementById('all_direction_time_departure').innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../admin/php/GetDataToSelect/getDirectionComplexRouteToSelect.php?R=" + id_route, true);
    xmlhttp.send();
}
//***** DISABLED EDIT ELEMENTS *****\\
// disabled all input and button in edit city form
function disabledEditInputCity() {
    document.getElementById('ID_City_Edit').value = "";
    document.getElementById('name_edit_city').value = "";
    document.getElementById('name_edit_city').disabled = true;
    document.getElementById('edit_city_button').disabled = true;
}
// disabled all input and button in edit stop form
function disabledEditInputStops() {
    document.getElementById('ID_Stop_Edit').value = "";
    document.getElementById('edit_stop_city').value = "";
    document.getElementById('edit_stop_name').value = "";
    document.getElementById('edit_stop_lat').value = "";
    document.getElementById('edit_stop_lng').value = "";
    document.getElementById('edit_stop_name').disabled = true;
    document.getElementById('edit_stop_lat').disabled = true;
    document.getElementById('edit_stop_lng').disabled = true;
    document.getElementById('edit_stop_button').disabled = true;
}
// disabled elements route form
function disabledEditInputRoutes() {
    document.getElementById('ID_Route_Edit').value = "";
    document.getElementById('edit_number_route').value = "";
    document.getElementById('edit_number_route').disabled = true;
    document.getElementById('edit_route_button').disabled = true;
}
// disabled elements complex route form
function disabledEditInputComplexRoute() {
    document.getElementById('edit-id-complex-route').value = "";
    document.getElementById('edit-input-stop').value = "";
    document.getElementById('edit-input-priority').value = "";
    document.getElementById('edit-input-span').value = "";
    document.getElementById('edit-input-span').disabled = true;
    document.getElementById('btn-edit-complex-route').disabled = true;
}
// disabled elements info about route form
function disabledEditInputInfoAboutRoute() {
    document.getElementById('edit_route_for_info').value = "";
    document.getElementById('edit_direct_for_info').value = "";
    document.getElementById('edit_reverse_for_info').value = "";
    document.getElementById('edit_time_for_info').value = "";
    document.getElementById('edit_price_for_info').value = "";
    document.getElementById('edit_update_for_info').innerHTML = "";
    document.getElementById('edit_route_for_info').disabled = true;
    document.getElementById('edit_direct_for_info').disabled = true;
    document.getElementById('edit_reverse_for_info').disabled = true;
    document.getElementById('edit_time_for_info').disabled = true;
    document.getElementById('edit_price_for_info').disabled = true;
    document.getElementById('edit_info_button_edit').disabled = true;
}
// disabled elements edit price form
function disabledEditInputPrice() {
    document.getElementById('edit_route_for_price').value = "";
    document.getElementById('edit_direct_for_price').value = "";
    document.getElementById('edit_first_stop_price').value = "";
    document.getElementById('edit_second_stop_price').value = "";
    document.getElementById('edit_price_for_price').value = "";
    document.getElementById('edit_route_for_price').disabled = true;
    document.getElementById('edit_direct_for_price').disabled = true;
    document.getElementById('edit_first_stop_price').disabled = true;
    document.getElementById('edit_second_stop_price').disabled = true;
    document.getElementById('edit_price_for_price').disabled = true;
    document.getElementById('edit_price_button_edit').disabled = true;
}
//***** UPDATE STOP TABLEs *****\\
// update stops in table
function updateStopTable() {
    var id_city = document.getElementById('all_city_table').value;
    showStopsToTable(id_city);
}
// update route by city in table
function updateRouteByCityTable() {
    var id_route = document.getElementById('check-route-rbc').value;
    showRouteByCityToTable(id_route);
}
// get lat and lng for direction stop
function getLatLngForDirection(id_stop) {
    if (id_stop == null) {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var responseArray = this.responseText.split(",");
            stop_on_map(responseArray[0], responseArray[1]);
        }
    };
    xmlhttp.open("GET", "../admin/php/getLatLngStopForDirection.php?S=" + id_stop, true);
    xmlhttp.send();
}

function addControls() {
    pr++;
    var inputStop = "\"add-complex-route-stops" + pr.toString() + "\"";
    var markerStop = "\'add-complex-route-stops" + pr.toString() + "\'";
    $("#other-inputs").append("<div id='other-conrols" + pr + "' class='stop-controls'><div class='row text-center controls'><div class='col-sm-12 col-xs-12 col-md-4'><label for='add-complex-route-citys" + pr + "'><span class='number-stop'>" + pr + ". </span>Місто</label><select id='add-complex-route-citys" + pr + "' onchange='showStopToSelect(" + inputStop + ",this.value);'></select></div><div class='col-sm-12 col-xs-12 col-md-3'><label for='add-complex-route-stops" + pr + "'>Зупинка</label><select id='add-complex-route-stops" + pr + "'></select><a id='complex-route-stop' data-toggle='modal' data-target='#mapStop' onclick=getLatLngForDirection(document.getElementById(" + markerStop + ").value) title='Показати на карті'><i class='fa fa-map-marker-alt fa-1x map'></i></a></div><div class='col-sm-12 col-xs-12 col-md-2'><label for='add-complex-route-priority'>Пріоритет:</label><label id='add-complex-route-priority' disabled class='priority'>" + pr + "</label></div><div class='col-sm-12 col-xs-12 col-md-3'><label for='add-complex-route-span" + pr + "'>Інтервал</label><input id='add-complex-route-span" + pr + "' class='span' maxlength='8' placeholder='00:00:00'></input></div></div></div>");
    showCityToSelect();
}

function addTimeControls() {
    tm++;
    $("#other-time-inputs").append("<div id='other-time-conrols" + tm + "'><div class='col-sm-12 col-xs-12 col-md-3 text-center'><label for='add-time-departure-time" + tm + "'><span class='number-time'>" + tm + ". </span>Час</label><input id='add-time-departure-time" + tm + "' class='time' maxlength='5' placeholder='00:00'></input></div></div>");
}

function addPriceControls() {
    st++;
    if ((st - 1) == document.getElementById('first_stop_for_price').length) {}
    $("#other-stops-inputs").append("<div id='other-price-conrols" + st + "'><div class='col-sm-12 col-xs-12 col-md-8'><label for='second_stop_for_price" + st + "'>Зупинка " + st + ": </label><select id='second_stop_for_price" + st + "' disabled='true'></select></div><div class='col-sm-12 col-xs-12 col-md-4 text-center'><label for='price_for_price" + st + "'>Ціна: </label><input type='text' id='price_for_price" + st + "' placeholder='17.00' maxlength='5'><label for='price_for_price" + st + "'>грн</label></div></div>");
    showStopToPriceSelect();
}

function removeControls() {
    if (pr == 1) {
        return;
    }
    $("#other-conrols" + pr + "").remove();
    pr--;
}

function removeAllControls() {
    for (var i = pr; i >= 1; i--) {
        removeControls();
    }
}

function removeValues() {
    $('#other-inputs').find('input:text').val('');
}

function removeTimeControls() {
    if (tm == 1) {
        return;
    }
    $("#other-time-conrols" + tm + "").remove();
    tm--;
}

function removePriceControls() {
    if (st == 1) {
        return;
    }
    $("#other-price-conrols" + st + "").remove();
    st--;
}

function removeAllTimeControls() {
    for (var i = tm; i >= 5; i--) {
        removeTimeControls();
    }
}

function removeTimeValues() {
    $('#other-time-conrols').find('input:text').val('');
}

function removeAllPriceControls() {
    for (var i = st; i >= 1; i--) {
        removePriceControls();
    }
}

function removePriceValues() {
    $('#other-stops-inputs').find('input:text').val('');
}

function checkWorkOrWeekend() {
    var sw = document.getElementById("add-time-departure-weekend").checked;
    var weekend;
    if (sw == true) {
        return weekend = 1;
    }
    else {
        return weekend = 0;
    }
}

function checkWorkOrWeekendToTable() {
    var sw = document.getElementById("add-time-departure-table-weekend").checked;
    var weekend;
    if (sw == true) {
        return weekend = 1;
    }
    else {
        return weekend = 0;
    }
}

function change() {
    showTimeDepartureToTable();
}