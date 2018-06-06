<?php
if (!empty($_COOKIE['sid'])) {
// check session id in cookies
session_id($_COOKIE['sid']);
}
session_start();
require_once 'php/Auth.class.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <link rel="stylesheet" type="text/css" href="../admin/css/style.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js">
    </script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
    <script type="text/javascript" src="js/main.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <title>Admin Transport
    </title>
  </head>
  <body onload="init();">
    <div id="p_prldr">
      <div class="contpre">
        <span class="svg_anm">
        </span>
        <br>PLEASE STAND BY
      </div>
    </div>
    <?php if (Auth\User::isAuthorized()): ?>
    <div id="exit">
      <div class="btn-exit">
        <form method="post" action="ajax.php">
          <input type="hidden" name="act" value="logout">
          <button class="btn" type="submit">Вихід
          </button>
        </form>
      </div>
    </div>
    <nav class="navbar navbar-default sidebar" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
            <span class="sr-only">Toggle navigation
            </span>
            <span class="icon-bar">
            </span>
            <span class="icon-bar">
            </span>
            <span class="icon-bar">
            </span>
            <span class="icon-bar">
            </span>
          </button>      
        </div>
        <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li>
              <a class="active" href="#city">Місто
                <span class="pull-right hidden-xs showopacity fas fa-building icon-menu">
                </span>
              </a>
            </li>
            <li>
              <a href="#stop" data-section="stop">Зупинки
                <span class="pull-right hidden-xs showopacity fa fa-bus icon-menu">
                </span>
              </a>
            </li>
            <li>
              <a href="#route" data-section="route">№ маршрутів
                <span class="pull-right hidden-xs showopacity fa fa-random icon-menu">
                </span>
              </a>
            </li>        
            <li>
              <a href="#route-by-city" data-section="route-by-city">Маршрути через міста
                <span class="pull-right hidden-xs showopacity fa fa-map-signs icon-menu">
                </span>
              </a>
            </li>
            <li>
              <a href="#direction" data-section="direction">Направлення
                <span class="pull-right hidden-xs showopacity fa fa-exchange-alt icon-menu">
                </span>
              </a>
            </li>
            <li>
              <a href="#complex-route" data-section="complex-route">Зібрати маршрут
                <span class="pull-right hidden-xs showopacity fa fa-sort-numeric-up icon-menu">
                </span>
              </a>
            </li>
            <li>
              <a href="#time-departure" data-section="time-departure">Розклад відправлень
                <span class="pull-right hidden-xs showopacity fa fa-calendar-alt icon-menu">
                </span>
              </a>
            </li>
            <li>
              <a href="#info" data-section="info">Інф. про маршрут
                <span class="pull-right hidden-xs showopacity fa fa-info-circle icon-menu">
                </span>
              </a>
            </li>
            <li>
              <a href="#price" data-section="price">Ціни
                <span class="pull-right hidden-xs showopacity fa fa-money-bill-alt icon-menu">
                </span>
              </a>
            </li>
            <li>
              <a href="#transfer" data-section="transfer">Пересадки
                <span class="pull-right hidden-xs showopacity fa fa-arrows-alt icon-menu">
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <section id="city">
      <div class="container">
        <div class="row">
          <div class="header-section text-center">
            <h3>Місто
            </h3>
            <span class="header-icon fa fa-angle-down fa-1x">
            </span>
          </div>
        </div>
        <div class="row work-field">
          <div class="col-xs-12 col-sm-6 col-md-6 text-center">
            <div class="header-small">
              <h4>Додати місто
              </h4>
            </div>
            <div class="input">
              <label for="name_add_city">Назва: 
              </label>
              <input type="text" id="name_add_city">
            </div>
            <div class="button">
              <button class="btn" id="add_city_button" onclick="addCityToDB();">Додати
              </button>
            </div>
            <div class="header-small">
              <h4>Редагувати назву
              </h4>
            </div>
            <input id="ID_City_Edit" value="" hidden>
            <div class="input">
              <label for="name_edit_city">Назва: 
              </label>
              <input type="text" id="name_edit_city" disabled="true">
            </div>
            <div class="button">
              <button class="btn" id="edit_city_button" disabled="true" onclick="EditCity();">Редагувати
              </button>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="header-small text-center">
              <h4>Всі міста 
                <a id="update" onclick="showCitysToTable();" title="Оновити таблицю">
                  <i class="fa fa-sync">
                  </i>
                </a>
              </h4>
            </div>
            <div class="table-responsive">
              <table id="table_citys" class="table table-condensed">
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="stop">
      <div class="container">
        <div class="row header-section text-center">
          <h3>Зупинки
          </h3>
          <span class="header-icon fa fa-angle-down fa-1x">
          </span>
        </div>
        <div class="row work-field">
          <div class="col-xs-12 col-sm-12 col-md-6 text-center">
            <div class="stop_add">
              <div class="row">
                <div class="header-small">
                  <h4>Додати зупинку
                  </h4>
                  <p>Оберіть місто та заповніть поля
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="input">
                  <select id="add_stop_city" placeholder="Оберіть місто">
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="input">
                  <input type="text" id="add_stop_name" placeholder="Назва зупинки">
                </div>
              </div>
              <div class="row">
                <div class="input">
                  <input type="text" id="add_stop_lat" placeholder="Широта">
                </div>
              </div>
              <div class="row">
                <div class="input">
                  <input type="text" id="add_stop_lng" placeholder="Довгота">
                </div>
              </div>
              <div class="row">
                <div class="button">
                  <button class="btn" onclick="addStopToDB();" id="add_stop_button">Додати
                  </button>
                  <a href="" data-toggle='modal' data-target='#mapStop' title='Показати на карті' onclick="showStopFromAddStop();" id="update">
                    <i class="fa fa-map-marker-alt fa-2x">
                    </i>
                  </a>
                </div>
              </div>
              <div class="row">
                <div id="resultAddStop">
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 text-center">
            <div class="stop_edit">
              <div class="row">
                <div class="header-small">
                  <h4>Редагування зупинки
                  </h4>
                  <p>Для редагування оберить зупинку в таблиці
                  </p>
                </div>
              </div>
              <div class="row">
                <input id="ID_Stop_Edit" value="" hidden>
                <div class="input">
                  <input type="text" id="edit_stop_city" disabled="true" placeholder="Місто">
                </div>
              </div>
              <div class="row">
                <div class="input">
                  <input type="text" id="edit_stop_name" disabled="true" placeholder="Назва зупинки">
                </div>
              </div>
              <div class="row">
                <div class="input">
                  <input type="text" id="edit_stop_lat" disabled="true" placeholder="Широта">
                </div>
              </div>
              <div class="row">
                <div class="input">
                  <input type="text" id="edit_stop_lng" disabled="true" placeholder="Довгота">
                </div>
              </div>
              <div class="row">
                <div class="button">
                  <button class="btn" id="edit_stop_button" onclick="toEditStop();" disabled>Зберегти зміни
                  </button>
                </div>
              </div>
              <div class="row">
                <div id="resultEditStop">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-xs-12 col-sm-12 all_stops">
            <div class="row text-center">
              <div class="input">
                <select id="all_city_table" onchange="showStopsToTable(this.value);" placeholder="Оберіть місто">
                </select>
                <a id="update" onclick="updateStopTable();" title="Оновити таблицю">
                  <i class="fa fa-sync">
                  </i>
                </a>
                <p>Оберіть місто для демонстрації зупинок
                </p>
              </div>
            </div>
            <div class="row text-center">
              <div id="resultDeleteStop">
              </div>
            </div>
            <div class="table-responsive">
              <table id="table_stops" class="table table-condensed">
              </table>
            </div>
          </div>
        </div>
      </div>
      </div>
    </section>
  <section id="route">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h3>Маршрути
          </h3>
          <span class="header-icon fa fa-angle-down fa-1x">
          </span>
        </div>
      </div>
      <div class="row work-field">
        <div class="col-xs-12 col-sm-12 col-md-6 add_route_form text-center">
          <div class="row">
            <div class="header-small">
              <h4>Добавить маршрут
              </h4>
            </div>
            <div class="route_add text-center">
              <div class="row input">
                <label for="add_number_route">Номер: 
                </label>
                <input type="text" id="add_number_route" placeholder="Номер маршруту">
              </div>
              <div class="row button">
                <button class="btn" onclick="addRouteToDB();" id="add_route_button">Додати маршрут
                </button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="header-small">
              <h4>Редагувати номер маршруту
              </h4>
            </div>
            <div class="route_edit text-center">
              <input id="ID_Route_Edit" value="" hidden>
              <div class="row input">
                <label for="edit_number_route">Номер: 
                </label>
                <input type="text" id="edit_number_route" placeholder="Номер маршруту" disabled="true">
              </div>
              <div class="row button">
                <button class="btn" id="edit_route_button" onclick="toEditNumberRoute();" disabled="true">Редагувати
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="header-small text-center">
            <h4>Всі маршруты 
              <a id="update" onclick="showRoutesToTable();" title="Оновити таблицю">
                <i class="fa fa-sync">
                </i>
              </a>
            </h4>
          </div>
          <div class="table-responsive">
            <table id="table_routes" class="table table-condensed">
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="route-by-city">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h3>Маршрути через місто
          </h3>
          <span class="header-icon fa fa-angle-down fa-1x">
          </span>
        </div>
      </div>
      <div class="row work-field">
        <div class="col-xs-12 col-sm-12 col-md-6 route-by-city-add text-center">
          <div class="row">
            <div class="header-small">
              <h4>Оберіть маршрут
              </h4>
            </div>
            <div class="text-center">
              <div class="row input">
                <label for="add_route-by-city-number">Номер: 
                </label>
                <select id="add_route-by-city-number" placeholder="Номер маршруту">
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="header-small">
              <h4>Оберіть міста
              </h4>
            </div>
            <div class="text-center">
              <select multiple class="form-control" id="add_route-by-city-citys">
              </select>
            </div>
          </div>
          <div class="row button">
            <button id="add-route-by-city-button" class="btn button" onclick="addRouteByCity();">OK
            </button>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 route-by-city-table">
          <div class="header-small text-center">
            <h4>Всі маршруты 
              <a id="update" onclick="updateRouteByCityTable();" title="Оновити таблицю">
                <i class="fa fa-sync">
                </i>
              </a>
            </h4>
          </div>
          <div class="text-center">
            <select class="form-control" id="check-route-rbc" onchange="showRouteByCityToTable(this.value);">
            </select>
          </div>
          <div class="table-responsive">
            <table id="table-route-by-city" class="table table-condensed">
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="direction">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h3>Направлення
          </h3>
          <span class="header-icon fa fa-angle-down fa-1x">
          </span>
        </div>
      </div>
      <div class="row work-field">
        <div class="row">
          <div class="row text-center input col-xs-12 col-sm-12 col-md-offset-4 col-md-4">
            <label for="add_direction_route">Номер маршруту: 
            </label>
            <select id="add_direction_route" onchange="showDirectionsToTable();">
            </select>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 direct_direction"> 
            <div class="row input text-center">
              <div class="col-sm-6 col-xs-12 col-md-6 direct_city_A">
                <label for="direct_city_A" class="A">Місто: 
                </label>
                <select id="direct_city_A" onchange="showStopToSelect('direct_start',this.value);">
                </select>
              </div>
              <div class="col-sm-6 col-xs-12 col-md-6 direct_city_B">
                <label for="direct_city_B" class="B">Місто: 
                </label>
                <select id="direct_city_B" onchange="showStopToSelect('direct_finish',this.value);">
                </select>
              </div>
            </div>
            <div class="row input direct_start text-center">
              <div class="col-sm-6 col-xs-12 col-md-6">
                <label for="direct_start" class="A">A: 
                </label>
                <select id="direct_start">
                </select>
                <a id="direct_stop_A" data-toggle='modal' data-target='#mapStop' onclick="getLatLngForDirection(document.getElementById('direct_start').value);" title="Показати на карті">
                  <i class='fa fa-map-marker-alt fa-1x map'>
                  </i>
                </a>
              </div>
              <div class="col-sm-6 col-xs-12 col-md-6 direct_finish">
                <label for="direct_finish" class="B">B: 
                </label>
                <select id="direct_finish">
                </select>
                <a id="direct_stop_B" data-toggle='modal' data-target='#mapStop' onclick="getLatLngForDirection(document.getElementById('direct_finish').value);" title="Показати на карті">
                  <i class='fa fa-map-marker-alt fa-1x map'>
                  </i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center col-xs-12 col-sm-12 col-md-offset-3 col-md-6 col-md-offset-3">
          <button class="btn button" onclick="addDirectionOfRoute();">Добавить
          </button>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="table_directions" class="table table-condensed">
              </table>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </section>
  <section id="complex-route">
    <div class="container">
      <div class="row">
        <div class="header-section text-center">
          <h3>Зібрати маршрут
          </h3>
          <span class="header-icon fa fa-angle-down fa-1x">
          </span>
        </div>
      </div>
      <div class="row add-stop-for-route text-center work-field">
        <div class="row base-inputs">
          <div class="col-sm-12 col-xs-12 col-md-6 route">
            <label for="add-complex-route-routes">№ маршруту
            </label>
            <select id="add-complex-route-routes" class="selects" onchange="showDirectionsToSelect(this.value);">
            </select>
          </div>
          <div class="col-sm-12 col-xs-12 col-md-6">
            <label for="add-complex-route-direction">Напрямок
            </label>
            <select id="add-complex-route-direction" class="selects">
            </select>
            <button id="add-controls" onclick="addControls()" class="btn button">+
            </button>
            <button id="add-controls" onclick="removeControls()" class="btn button">-
            </button>
          </div>
        </div>
        <div id="other-inputs">
          <div id="other-conrols1" class="stop-controls">
            <div class="row text-center controls">
              <div class="col-sm-6 col-xs-12 col-md-4">
                <label for="add-complex-route-citys1">
                  <span class="number-stop">1. 
                  </span>Місто
                </label>
                <select id="add-complex-route-citys1" onchange="showStopToSelect('add-complex-route-stops1',this.value);">
                </select>
              </div>
              <div class="col-sm-6 col-xs-12 col-md-3">
                <label for="add-complex-route-stops1">Зупинка
                </label>
                <select id="add-complex-route-stops1">
                </select>
                <a id="complex-route-stop" data-toggle='modal' data-target='#mapStop' onclick="getLatLngForDirection(document.getElementById('add-complex-route-stops1').value);" title="Показати на карті">
                  <i class='fa fa-map-marker-alt fa-1x map'>
                  </i>
                </a>
              </div>
              <div class="col-sm-12 col-xs-12 col-md-2">
                <label for="add-complex-route-priority">Пріоритет:
                </label>
                <label id="add-complex-route-priority" class="priority">1
                </label>
              </div>
              <div class="col-sm-12 col-xs-12 col-md-3">
                <label for="add-complex-route-span1">Інтервал
                </label>
                <input id="add-complex-route-span1" class="span" maxlength="8" placeholder="00:00:00">
                </input>
            </div>
          </div>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-sm-12 col-xs-12 col-md-offset-4 col-md-4">
          <button class="btn" onclick="addComplexRoute();">Добавить
          </button>
        </div>
      </div>
    </div>
    <div class="row work-field">
      <div class="row header-small text-center">
        <h4>Всі маршрути
        </h4>
      </div>
      <div class="row text-center">
        <div class="col-md-12 col-xs-12 col-sm-12 show-complex-route">
          <div class="col-md-offset-1 col-md-5 col-xs-12 col-sm-12 input">
            <label for='all_route_complex_route_table'>Маршрут
            </label>
            <select id="all_route_complex_route_table" onchange="showDirectionsToSelectForTable(this.value);" placeholder="Оберіть номер">
            </select>
          </div>
          <div class=" col-md-5 col-xs-12 col-sm-12 input">
            <label for='all_direction_complex_route_table'>Напрямок
            </label>
            <select id="all_direction_complex_route_table" onchange="showComplexRouteToTable();" placeholder="Оберіть напрямок">
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-xs-12 col-sm-12 complex-route-table">
          <div class="table-responsive">
            <table id="table_complex_route" class="table table-condensed">
            </table>
          </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-12 edit-complex-route text-center">
          <div class="header-small text-center">
            <h4>
              Редагувати
            </h4>
          </div>
          <input hidden="true" id="edit-id-complex-route">
          <div class="row">
            <label for='all_direction_complex_route_table'>Зупинка
            </label>
            <input type="text" disabled="true" id="edit-input-stop">
          </div>
          <div class="row">
            <label for='all_direction_complex_route_table'>Пріоритет
            </label>
            <input type="text" disabled="true" id="edit-input-priority">
          </div>
          <div class="row">
            <label for='all_direction_complex_route_table'>Інтервал
            </label>
            <input type="text" disabled="true" id="edit-input-span">
          </div>
          <div class="row">
            <button class="btn" disabled="true" id="btn-edit-complex-route" onclick="toEditComplexRoute();">Добавить
            </button>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
<section id="time-departure">
  <div class="container">
    <div class="row">
      <div class="header-section text-center">
        <h3>Розклад відправлень
        </h3>
        <span class="header-icon fa fa-angle-down fa-1x">
        </span>
      </div>
    </div>
    <div class="row work-field">
      <div class="row add-time-for-departure text-center"> 
        <div class="row base-inputs">
          <div class="col-sm-8 col-xs-12 col-md-offset-1 col-md-3">
            <label for="add-time-departure-routes">№ маршруту
            </label>
            <select id="add-time-departure-routes" onchange="showDirectionsToTimeSelect(this.value);">
            </select>
          </div>
          <div class="col-sm-4 col-xs-12 col-md-3">
            <div class="form-check">
              <label>
                Будні
                <input type="checkbox" data-toggle="toggle" data-on="" data-off="" id="add-time-departure-weekend">
                Вихідні
              </label>
            </div>
          </div>
          <div class="col-sm-12 col-xs-12 col-md-5">
            <label for="add-time-departure-direction">Напрямок
            </label>
            <select id="add-time-departure-direction">
            </select>
            <button id="add-controls" onclick="addTimeControls()" class="btn small-button">+
            </button>
            <button id="remove-controls" onclick="removeTimeControls()" class="btn small-button">-
            </button>
          </div>
        </div>
        <div id="other-time-inputs" class="row">
          <div id="other-time-conrols1">
            <div class="col-sm-12 col-xs-12 col-md-3 text-center">
              <label for="add-time-departure-time1">
                <span class="number-time">1. 
                </span>Час
              </label>
              <input id="add-time-departure-time1" class="time" maxlength="5" placeholder="00:00">
              </input>
          </div>
        </div>
        <div id="other-time-conrols2">
          <div class="col-sm-12 col-xs-12 col-md-3 text-center">
            <label for="add-time-departure-time2">
              <span class="number-time">2. 
              </span>Час
            </label>
            <input id="add-time-departure-time2" class="time" maxlength="5" placeholder="00:00">
            </input>
        </div>
      </div>
      <div id="other-time-conrols3">
        <div class="col-sm-12 col-xs-12 col-md-3 text-center">
          <label for="add-time-departure-time3">
            <span class="number-time">3. 
            </span>Час
          </label>
          <input id="add-time-departure-time3" class="time" maxlength="5" placeholder="00:00">
          </input>
      </div>
    </div>
    <div id="other-time-conrols4">
      <div class="col-sm-12 col-xs-12 col-md-3 text-center">
        <label for="add-time-departure-time4">
          <span class="number-time">4. 
          </span>Час
        </label>
        <input id="add-time-departure-time4" class="time" maxlength="5" placeholder="00:00">
        </input>
    </div>
  </div>
  </div>
<div class="row button">
  <div class="col-sm-12 col-xs-12 col-md-offset-4 col-md-4 text-center">
    <button class="btn" onclick="addTimeDeparture();">Добавить
    </button>
  </div>
</div>
</div>
<hr>
<div class="row">
  <div class="header-small text-center">
    <h4>Розклад руху
    </h4>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-offset-2 col-md-4 text-center">
    <div class="input">
      <select id="all_route_time_departure" onchange="showDirectionsToAllTimeSelect(this.value);" placeholder="Оберіть місто">
      </select>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-3 text-center">
    <div class="input">
      <select id="all_direction_time_departure" disabled="true" onchange="showTimeDepartureToTable();" placeholder="Оберіть місто">
      </select>
    </div>
  </div>
  <div class="col-sm-12 col-xs-12 col-md-3 text-center">
    <div class="form-check">
      <label>
        Будні
        <input type="checkbox" disabled="true" data-toggle="toggle" data-on="" data-off="" onchange="change();" id="add-time-departure-table-weekend">
        Вихідні
      </label>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12 col-xs-12 col-md-offset-1 col-md-11">
    <div class="row table-responsive">
      <table id="table_time_departure" class="table table-condensed">
      </table>
    </div>
  </div>
</div>
</div>
</div>
</section>
<section id="info">
  <div class="container">
    <div class="row">
      <div class="header-section text-center">
        <h3>Інформація про маршрут
        </h3>
        <span class="header-icon fa fa-angle-down fa-1x">
        </span>
      </div>
    </div>
    <div class="row work-field">
      <div class="row">
        <div class="add-info-about-route col-sm-12 col-xs-12 col-md-6 text-right">
          <div class="header-small text-center">
            <h4>Додати інформацію
            </h4>
          </div>
          <div class="row inputs">
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="route_for_info">№ маршруту: 
              </label>
              <select id="route_for_info" onchange="showDirectionsToInfoSelect(this.value);">
              </select>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="direct_for_info">Прямий: 
              </label>
              <select id="direct_for_info">
              </select>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="reverse_for_info">Зворотній: 
              </label>
              <select id="reverse_for_info">
              </select>
            </div>
          </div>
          <div class="row inputs">
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="time_for_info">Час роботи: 
              </label>
              <input type="text" id="time_for_info" placeholder="06:00 - 23:00" maxlength="13">
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12 text-center">
              <label for="price_for_info">Макс. ціна: 
              </label>
              <input type="text" id="price_for_info" placeholder="17.00" maxlength="5">
              <label for="price_for_info">грн
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-offset-4 col-md-4 col-md-offset-4">
              <button class="btn button" onclick="addInfoAboutRoute();" id="info_button_add">ОК
              </button>
            </div>
          </div>
        </div>
        <div class="edit-info-about-route col-sm-12 col-xs-12 col-md-6 text-right">
          <div class="header-small text-center">
            <h4>Редагувати інформацію
            </h4>
          </div>
          <div class="row inputs">
            <input type="text" id="edit_id_info" hidden="true">
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="edit_route_for_info">№ маршруту: 
              </label>
              <select id="edit_route_for_info" disabled="true" onchange="showDirectionsToEditInfoSelect(this.value);">
              </select>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="edit_direct_for_info">Прямий: 
              </label>
              <select id="edit_direct_for_info" disabled="true">
              </select>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="edit_reverse_for_info">Зворотній: 
              </label>
              <select id="edit_reverse_for_info" disabled="true">
              </select>
            </div>
          </div>
          <div class="row inputs">
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="edit_time_for_info">Час роботи: 
              </label>
              <input type="text" id="edit_time_for_info" disabled="true" placeholder="06:00 - 23:00" maxlength="13">
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12 text-center">
              <label for="edit_price_for_info">Макс. ціна: 
              </label>
              <input type="text" id="edit_price_for_info" disabled="true" placeholder="17.00" maxlength="5">
              <label for="edit_price_for_info">грн
              </label>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12 text-center">
              <label for="edit_update_for_info">Останнє оновленя:
              </label>
              <label id="edit_update_for_info">
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-offset-4 col-md-4 col-md-offset-4">
              <button class="btn button" onclick="toEditInfoAboutRoute();" disabled="true" id="edit_info_button_edit">ОК
              </button>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="row col-xs-12 col-sm-12 col-md-offset-4 col-md-4 text-center">
        <div class="row text-center">
          <div class="input">
            <select id="all_route_info_table" onchange="showInfoAboutRouteToTable();" placeholder="Оберіть місто">
            </select>
            <a id="update" onclick="showInfoAboutRouteToTable()" title="Оновити таблицю">
              <i class="fa fa-sync">
              </i>
            </a>
            <p>Оберіть маршрут для демонстрації інформації
            </p>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-xs-12 col-md-offset-1 col-md-11">
        <div class="row table-responsive">
          <table id="table_info_about_route" class="table table-condensed">
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="price">
  <div class="container">
    <div class="row">
      <div class="header-section text-center">
        <h3>Ціни
        </h3>
        <span class="header-icon fa fa-angle-down fa-1x">
        </span>
      </div>
    </div>
    <div class="row work-field">
      <div class="row">
        <div class="add-price col-sm-12 col-xs-12 col-md-6 text-right">
          <div class="header-small text-center">
            <h3>Додати ціну
            </h3>
          </div>
          <div class="row inputs">
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="route_for_price">№ маршруту: 
              </label>
              <select id="route_for_price" onchange="showDirectionsToPriceSelect(this.value);">
              </select>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="direct_for_price">Напрямок: 
              </label>
              <select id="direct_for_price" onchange="showStopToPriceSelect()" disabled="true">
              </select>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="first_stop_for_price">Від зупинки: 
              </label>
              <select id="first_stop_for_price" disabled="true">
              </select>
            </div>
            <div id="other-stops-inputs">
              <div id="other-price-conrols1">
              </div>
              <div class="col-sm-12 col-xs-12 col-md-offset-1 col-md-6">
                <label for="second_stop_for_price1">Зупинка 1: 
                </label>
                <select id="second_stop_for_price1" disabled="true">
                </select>
              </div>
              <div class="col-sm-12 col-xs-12 col-md-5">
                <label for="price_for_price1">Ціна: 
                </label>
                <input type="text" id="price_for_price1" class="input-price" placeholder="17.00" maxlength="5">
                <label for="price_for_price1">грн
                </label>
                <button id="add-controls" onclick="addPriceControls()" class="btn button-controls">+
                </button>
                <button id="add-controls" onclick="removePriceControls()" class="btn button-controls">-
                </button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-offset-4 col-md-4 col-md-offset-4">
              <button class="btn button" onclick="addPriceRoute();" id="price_button_add">ОК
              </button>
            </div>
          </div>
        </div>
        <div class="edit-price col-sm-12 col-xs-12 col-md-6 text-right">
          <div class="header-small text-center">
            <h3>Редагувати ціну
            </h3>
          </div>
          <div class="row inputs">
            <input type="text" id="edit_id_price" hidden="true">
            <div class="col-sm-12 col-xs-12 col-md-12">
              <label for="edit_route_for_price">№ маршруту: 
              </label>
              <input id="edit_route_for_price" disabled="true">
              </input>
          </div>
          <div class="col-sm-12 col-xs-12 col-md-12">
            <label for="edit_direct_for_price">Напрямок: 
            </label>
            <input id="edit_direct_for_price" disabled="true">
            </input>
        </div>
        <div class="col-sm-12 col-xs-12 col-md-12">
          <label for="edit_first_stop_price">Зупинка 1: 
          </label>
          <input id="edit_first_stop_price" disabled="true">
          </input>
      </div>
      <div class="col-sm-12 col-xs-12 col-md-12">
        <label for="edit_second_stop_price">Зупинка 2: 
        </label>
        <input type="text" id="edit_second_stop_price" disabled="true" maxlength="13">
      </div>
    </div>
    <div class="row inputs">
      <div class="col-sm-12 col-xs-12 col-md-12 text-center">
        <label for="edit_price_for_price">Ціна: 
        </label>
        <input type="text" id="edit_price_for_price" disabled="true" maxlength="5">
        <label for="edit_price_for_price">грн
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-xs-12 col-md-offset-4 col-md-4 col-md-offset-4">
        <button class="btn button" onclick="toEditPriceRoute()" disabled="true" id="edit_price_button_edit">ОК
        </button>
      </div>
    </div>
  </div>
  </div>
<hr>
<div class="row">
  <div class="header-small text-center">
    <h4>Всі ціни
    </h4>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-6 text-center">
    <div class="input">
      <label for="all_route_price_table">№ маршруту: 
      </label>
      <select id="all_route_price_table" onchange="showDirectionsToPriceSelectTable(this.value);" placeholder="Оберіть місто">
      </select>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-6 text-center">
    <div class="input">
      <label for="all_direction_price_table">Напрямок: 
      </label>
      <select id="all_direction_price_table" onchange="showPriceByDirectonToTable();" disabled="true" placeholder="Оберіть місто">
      </select>
    </div>
  </div>
</div>
<div class="col-sm-12 col-xs-12 col-md-offset-1 col-md-11">
  <div class="row table-responsive">
    <table id="table_price_of_route" class="table table-condensed">
    </table>
  </div>
</div>
</div>
</div>
</div>
</section>
<section id="transfer">
  <div class="container">
    <div class="row">
      <div class="header-section text-center">
        <h3>Пересадки
        </h3>
        <span class="header-icon fa fa-angle-down fa-1x">
        </span>
      </div>
    </div>
    <div class="row work-field">
      <div class="add-info-about-route col-sm-12 col-xs-12 col-md-12 text-right">
        <div class="header-small text-center">
          <h4>Додати інформацію
          </h4>
        </div>
        <div class="row inputs">
          <div class="col-sm-12 col-xs-12 col-md-6">
            <label for="route_from_transfer">№ маршруту (з): 
            </label>
            <select id="route_from_transfer" onchange="showDirectionsFromTransferSelect(this.value);">
            </select>
          </div>
          <div class="col-sm-12 col-xs-12 col-md-6">
            <label for="route_to_transfer">№ маршруту (на): 
            </label>
            <select id="route_to_transfer" onchange="showDirectionsToTransferSelect(this.value);">
            </select>
          </div>
        </div>
        <div class="row inputs">
          <div class="col-sm-12 col-xs-12 col-md-6">
            <label for="direct_from_transfer">Напрямок (з): 
            </label>
            <select id="direct_from_transfer" disabled="true" onchange="showStopFromTransferSelect(this.value);">
            </select>
          </div>
          <div class="col-sm-12 col-xs-12 col-md-6">
            <label for="direct_to_transfer">Напрямок (на): 
            </label>
            <select id="direct_to_transfer" disabled="true" onchange="showStopToTransferSelect(this.value);">
            </select>
          </div>
        </div>
        <div class="row inputs">
          <div class="col-sm-12 col-xs-12 col-md-6">
            <label for="stop_from_transfer">Зупинка (з): 
            </label>
            <select id="stop_from_transfer" disabled="true">
            </select>
          </div>
          <div class="col-sm-12 col-xs-12 col-md-6">
            <label for="stop_to_transfer">Зупинка (на): 
            </label>
            <select id="stop_to_transfer" disabled="true">
            </select>
          </div>
        </div>
        <div class="row text-center col-md-offset-4 col-md-4">
          <button class="btn button" onclick="addTransferRoute();" id="transfer_button_add">ОК
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-offset-1 col-md-11 col-xs-12 col-sm-12 all_stops">
          <div class="row text-center">
            <div class="input">
              <select id="all_route_for_transfer_table" onchange="showTransferByRouteToTable(this.value);" placeholder="Оберіть місто">
              </select>
              <p>Оберіть маршрут для демонстрації пересадок
              </p>
            </div>
          </div>
          <div class="table-responsive">
            <table id="table_transfer" class="table table-condensed">
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="mapStop" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div id="map">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрити
        </button>
      </div>
    </div>
  </div>
</div>
<?php else: ?>
<div class="row text-center authorize">
  <form class="form-signin" method="post" action="./ajax.php">
    <div class="main-error alert alert-error hide">
    </div>
    <input name="username" type="text" class="input-block-level" placeholder="Логін" autofocus>
    <input name="password" type="password" class="input-block-level" placeholder="Пароль">
    <input type="hidden" name="act" value="login">
    <button class="btn btn-large btn-primary" type="submit">Авторизиція
    </button>
  </form>
</div>
<?php endif; ?>
<script type="text/javascript">$(window).on('load', function () {
    var $preloader = $('#p_prldr'),
        $svg_anm   = $preloader.find('.svg_anm');
    $svg_anm.fadeOut();
    $preloader.delay(500).fadeOut('slow');
  }
                                           );
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe-P7g_p1JjWk6k3qHHqMIkF4fkUv7MxM&libraries=places&callback=initMap" async defer
        >
</script>
</body>
</html>
