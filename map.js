var map = L.map("map").setView([14.48829245842671, 120.98897736022812], 19);

// var imageUrl = "res/images/palanayg.jpg",
//   imageBounds = [
//     [14.48923666666667, 120.98678888888889],
//     [14.48711444444444, 120.99159888888889],
//   ];

// L.imageOverlay(imageUrl, imageBounds).addTo(map);

var CartoDB_Voyager = L.tileLayer(
  "https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png",
  {
    attribution:
      '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    subdomains: "abcd",
    maxZoom: 20,
  }
).addTo(map);

// prototype purposes only
var cemeteryData = [
  {
    name: "John Doe",
    dod: "2020-05-10",
    age: 70,
    lat: 14.488331375689809,
    lon: 120.98878554544292,
  },
  {
    name: "Jane Smith",
    dod: "2021-07-22",
    age: 61,

    lat: 14.487982740111919,
    lon: 120.98883918962736,
  },
  {
    name: "Michael Brown",
    dod: "2019-03-12",
    age: 80,
    lat: 14.48859072513555,
    lon: 120.989335319557,
  },
  {
    name: "John Wick",
    dod: "2020-04-12",
    age: 50,
    lat: 14.48859072513555,
    lon: 120.989335319557,
  },
];

var tomb = L.icon({
  iconUrl: "res/images/tomb.webp",

  iconSize: [25],
});

let invisibleIcon = L.icon({
  iconUrl:
    "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/wcAAgAB/evOawAAAABJRU5ErkJggg==",
  iconSize: [1, 1],
  iconAnchor: [1, 1],
});

var polyline;
var startingPoint = [14.488235352726106, 120.98922252199092];
var fixedRange = -0.0005;
var pointC = [startingPoint[0] + 0.00023, startingPoint[1] + fixedRange];
function addPolyline(mapName, coordinates, color = "blue") {
  polyline = L.polyline(coordinates, { color: color }).addTo(mapName);
  return polyline;
}

// Display all cemetery data on map on load
cemeteryData.forEach((person) => {
  let marker = L.marker([person.lat, person.lon], { icon: tomb })
    .addTo(map)
    .bindPopup(
      `<b>${person.name}</b><br>Date of Death: ${person.dod}<br>Age: ${person.age}`,
      { className: "popup" }
    );

  marker.on("click", function () {
    marker.openPopup();
    map.setView([person.lat, person.lon], 19);
    var pointB = [person.lat, person.lon];
    if (polyline) map.removeLayer(polyline);

    addPolyline(map, [startingPoint, pointC, pointB]);
  });
});

// Focus on specific grave if search matches
function searchGrave() {
  let query = document.getElementById("search").value.toLowerCase();
  if (query.trim() === "")
    return alert("Please enter a name, date of death, or age.");

  let results = cemeteryData.filter(
    (person) =>
      person.name.toLowerCase().includes(query) ||
      person.dod.includes(query) ||
      person.age.toString() === query
  );

  if (results.length > 0) {
    results.forEach((person) => {
      let marker = L.marker([person.lat, person.lon], {
        icon: invisibleIcon,
      })
        .addTo(map)
        .bindPopup(
          `<b>${person.name}</b><br>Date of Death: ${person.dod}<br>Age: ${person.age}`,
          { className: "popup" }
        )
        .openPopup();

      map.setView([person.lat, person.lon], 19); // Zoom to found location
      pointB = [person.lat, person.lon];
      if (polyline) map.removeLayer(polyline);

      addPolyline(map, [startingPoint, pointC, pointB]);
    });
  } else {
    alert("No matching records found.");
  }
}

function resetMap() {
  map.setView([14.48829245842671, 120.98897736022812], 19);
  if (polyline) map.removeLayer(polyline);
  map.closePopup();
  // reset map
}
