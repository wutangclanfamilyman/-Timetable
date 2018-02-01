function initMap() {
        var uluru = {lat: 50.363, lng: 30.044};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: uluru,
          disableDefaultUI: true
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
var step = 100;
var scrolling = false;

// Wire up events for the 'scrollUp' link:
$(".up").bind("click", function(event) {
    event.preventDefault();
    // Animates the scrollTop property by the specified
    // step.
    $(".cities-list").animate({
        scrollTop: "-=" + step + "px"
    });
}).bind("mouseover", function(event) {
    scrolling = true;
    scrollContent("up");
}).bind("mouseout", function(event) {
    scrolling = false;
});


$(".down").bind("click", function(event) {
    event.preventDefault();
    $(".cities-list").animate({
        scrollTop: "+=" + step + "px"
    });
}).bind("mouseover", function(event) {
    scrolling = true;
    scrollContent("down");
}).bind("mouseout", function(event) {
    scrolling = false;
});

function scrollContent(direction) {
    var amount = (direction === "up" ? "-=1px" : "+=1px");
    $(".cities-list").animate({
        scrollTop: amount
    }, 1, function() {
        if (scrolling) {
            scrollContent(direction);
        }
    });
} 