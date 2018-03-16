function getRandomColor() {
  var letters = '0289AB';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}
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



// Loop through the results array and place a marker for each
// set of coordinates.
