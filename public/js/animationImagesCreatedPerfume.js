var headScent = document.getElementById("created_perfume_headScent");
var heartScent = document.getElementById("created_perfume_heartScent");
var baseScent = document.getElementById("created_perfume_baseScent");

var headScentBox = document.getElementById("proportionHeadScent");
var heartScentBox = document.getElementById("proportionHeartScent");
var baseScentBox = document.getElementById("proportionBaseScent");

headScent.addEventListener('change', function(){
    headScentBox.style.backgroundImage = "url(" + headScentsImagesJs[headScent.value-1] + ")";
})

heartScent.addEventListener('change', function(){
    heartScentBox.style.backgroundImage = "url(" + heartScentsImagesJs[heartScent.value-1] + ")";
})

baseScent.addEventListener('change', function(){
    baseScentBox.style.backgroundImage = "url(" + baseScentsImagesJs[baseScent.value-9] + ")";
})