<?php

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}

session_start();
require_once 'php/Auth.class.php';

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	<link rel="stylesheet" type="text/css" href="css/style.css">
    <href type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe-P7g_p1JjWk6k3qHHqMIkF4fkUv7MxM&libraries=places"></href>
  	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.11/css/all.css" integrity="sha384-p2jx59pefphTFIpeqCcISO9MdVfIm4pNnsL08A6v5vaQc4owkQqxMV8kg4Yvhaw/" crossorigin="anonymous">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdn.klokantech.com/maptilerlayer/v1/index.js"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://cdn.klokantech.com/maptilerlayer/v1/index.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/map_script.js"></script>
    <script src="js/ajax-form.js"></script>
  </head>
  <body onload="showCity()">
    <div id="p_prldr"><div class="contpre"><span class="svg_anm"></span><br>PLEASE STAND BY</div></div>
    <div id="map"></div>
    <div id="RoutePanel">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#route">Побудова маршруту</a></li>
        <li><a data-toggle="tab" href="#timetable">Розклад руху</a></li>
      </ul>

        <div class="tab-content" id="tabsMenu">
          <div id="route" class="tab-pane fade in active">
            <div class="row">
              <form role="form" id="formSearch">
              <div class="row input-start">
                <div class="form-group col-sm-12">
                        <input type="text" class="form-control" id="startInput" placeholder="Точка відправки" required>
                        <input type="hidden" id="IDpointA">
                        <input type="hidden" id="IDDir">
                    </div>
                  </div>
                  <div class="row input-finish">
                    <div class="form-group col-sm-12">
                        <input type="text" class="form-control" id="finishInput" placeholder="Точка прибуття" required>
                        <input type="hidden" id="IDpointB">
                    </div>
                  </div>
                  <div class="row btn-send texc-center">
                    <div class="form-group col-sm-offset-1 col-sm-10 col-sm-offset-1">
                        <a class="btn" onclick="getRouteNotTransfer()" id="btn-search">Пошук</a>
                    </div>
                  </div>
              </form> 
              <hr>
             </div>
           <div id="resultRoute" class="container-route">

           </div>
          </div>
          <div id="timetable" class="tab-pane fade">
            <div class="row listCity text-center">
                <div class="row header">
                  <label>Оберіть місто</label>
                </div>
                <div class="row">
                  <select id="city" onchange="showNumbers(this.value)">
                  </select>
                </div>
              </div>
              <div class="row allNumbersRoutes" id="numbers">
              </div>
              <div class="row">
              <div class="direction text-center">
                  <label class="name">Напрям маршруту 
  	            <?php if (Auth\User::isAuthorized()): ?>
                  	<button id="saveRouteUser" value='' onclick="saveRouteUser(<?php echo $_SESSION['user_id'] ?>, value)" title="Зберегти маршрут в профіль"><i class="fa fa-save"></i></button>
  				<?php endif; ?>
                  </label>
                  <select id="direction" onchange="ShowTimeDeparture(this.value); getPolylineForRoute(routeNum,this.value);">
                    <option class="active" value="">Не обрано</option>
                  </select>
              </div>
              </div>
              <div class="row">
                <div class="weekend text-center">
                  <label>
                    Будні
                    <input type="checkbox" data-toggle="toggle" data-on="" data-off="" onchange="change()" id="switchWorkWeekend">
                    Вихідні
                  </label>
                </div>
              </div>
              <div class="row allTimesStart" id="timedeparture">
              </div>
              <div class="detailOfRoute" id="infoRouteDiv">
              </div>
          </div>
        </div>
    </div>
    <div id="user">
    <?php if (Auth\User::isAuthorized()): ?>
      <div class="tab-content" id="tabsMenu">
        <div id="tab-user-numbers" class="tab-pane fade in active">
          <div id="user-numbers">

          </div>
          <label class="label label-success"><a data-toggle="tab" id="getUserRoute" onclick="getRouteByUser(<?php echo $_SESSION['user_id'] ?>);" href="#tab-user-numbers">Мої маршртури</a></label>
          <form method="post" action="ajax.php">
              <input type="hidden" name="act" value="logout">
              <label class="label label-danger"><button type="submit">Вихід</button></label>
          </form>
        </div>
      </div>
      <?php else: ?>
        <div class="tab-content" id="tabsMenu">
        <div id="authorization" class="tab-pane fade in active">
            <form method="post" action="ajax.php">
              <div class="main-error alert alert-error hide"></div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="loginInputEmail" id="loginInputEmail" aria-describedby="emailHelp" placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" name="loginInputPassword" id="loginInputPassword" placeholder="Пароль">
              </div>
              <label class="checkbox">
          			<input name="remember-me" type="checkbox" value="remember-me" checked> Remember me
        	</label>
              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Авторизація</button>
              </div>
              <input type="hidden" name="act" value="login">
              <div class="form-group register">
                <label class="label label-success"><a data-toggle="tab" href="#registration">Реєстрація</a></label>
              </div>
            </form>
        </div>
        <div id="registration" class="tab-pane fade">
        	<form method="post" action="ajax.php">
            <div class="main-error alert alert-error hide"></div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="registerInputEmail" id="registerInputEmail" placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" name="registerInputPassword" id="registerInputPassword" placeholder="Пароль">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Повторіть пароль</label>
                <input type="password" class="form-control" name="registerInputRepeatPassword" id="registerInputRepeatPassword" placeholder="Повторіть пароль">
              </div>
              <div class="form-group text-center">
                <button id="register-user-btn" onclick="registerUser()" class="btn btn-primary">Реєстрація</button>
              </div>
              <input type="hidden" name="act" value="register">
              <div class="form-group authorization">
                <label class="label label-success"><a data-toggle="tab" href="#authorization">Авторизація</a></label>
              </div>
          </form>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <div id="user-button">
      <?php if (Auth\User::isAuthorized()): ?>
      <button class="btn" id="btn-form"><i class="fa fa-user"></i></button>
       <?php else: ?>
      <button class="btn" id="btn-form"><i class="fa fa-sign-in-alt"></i></button>
      <?php endif; ?>
    </div>
    <script type="text/javascript">$(window).on('load', function () {
        var $preloader = $('#p_prldr'),
            $svg_anm   = $preloader.find('.svg_anm');
        $svg_anm.fadeOut();
        $preloader.delay(1000).fadeOut('slow');
      });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe-P7g_p1JjWk6k3qHHqMIkF4fkUv7MxM&libraries=places&callback=initMap" async defer
    >
    </script>
	<script src="js/ajax-form.js"></script>
  </body>
</html>