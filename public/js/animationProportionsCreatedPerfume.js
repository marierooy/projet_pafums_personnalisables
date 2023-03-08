
var proportionHeadScent = document.getElementById("created_perfume_proportionHeadScent");
var proportionHeartScent = document.getElementById("created_perfume_proportionHeartScent");
var proportionBaseScent = document.getElementById("created_perfume_proportionBaseScent");

var ajustmentInHeightProportions=15/100*120*3;

function ajustmentInHeightProportionsHeadHeartBoxes(ajustment){
    if ((Number(proportionHeadScent.value) + Number(proportionHeartScent.value))<=45){
        ajustedNumber = ajustment;
        document.getElementById("proportionHeadScentInput").style.bottom=ajustedNumber.toString()+"px";
        /* document.getElementById("proportionHeartScentInput").style.top=ajustment.toString()+"px"; */
        document.getElementById("headScentInput").style.bottom=ajustedNumber.toString()+"px";
        /* document.getElementById("heartScentInput").style.top=ajustment.toString()+"px"; */
    } else if ((Number(proportionBaseScent.value) + Number(proportionHeartScent.value))<=45) {
        document.getElementById("proportionHeartScentInput").style.top="auto";
        document.getElementById("heartScentInput").style.top="auto"; 
    } else {
        document.getElementById("proportionHeadScentInput").style.bottom="auto";
        document.getElementById("proportionHeartScentInput").style.top="auto";
        document.getElementById("headScentInput").style.bottom="auto";
        document.getElementById("heartScentInput").style.top="auto";
    }
}

function ajustmentInHeightProportionsHeartBaseBoxes(ajustment){
    if ((Number(proportionBaseScent.value) + Number(proportionHeartScent.value))<=45){
        /* document.getElementById("proportionHeartScentInput").style.top="-"+ajustment.toString()+"px"; */
        ajustedNumber = ajustment;
        document.getElementById("proportionBaseScentInput").style.top=ajustedNumber.toString()+"px";
        /* document.getElementById("heartScentInput").style.top="-"+ajustment.toString()+"px"; */
        document.getElementById("baseScentInput").style.top=ajustedNumber.toString()+"px";
    } else if ((Number(proportionHeadScent.value) + Number(proportionHeartScent.value))<=45) {
        document.getElementById("proportionBaseScentInput").style.top="auto";
        document.getElementById("baseScentInput").style.top="auto";
    } else {
        document.getElementById("proportionHeartScentInput").style.top="auto";
        document.getElementById("heartScentInput").style.top="auto";
        document.getElementById("proportionBaseScentInput").style.top="auto";
        document.getElementById("baseScentInput").style.top="auto";
    }
}

proportionHeadScent.addEventListener('change', function(){
    let newHeightHead = proportionHeadScent.value/100*120*3;
    document.getElementById("proportionHeadScent").style.height = newHeightHead+'px';
    proportionBaseScent.value = 100 - proportionHeadScent.value - proportionHeartScent.value;
    if (proportionBaseScent.value<0) {
        proportionBaseScent.value = 0;
    }
    proportionHeartScent.value = 100 - proportionBaseScent.value - proportionHeadScent.value;
    let newHeightHeart = proportionHeartScent.value/100*120*3;
    let newHeightHeartPx = newHeightHeart + "px";
    document.getElementById("proportionHeartScent").style.height = newHeightHeartPx;
    //} else {
    let newHeightBase = proportionBaseScent.value/100*120*3;
    let newHeightBasePx = newHeightBase + "px";
    document.getElementById("proportionBaseScent").style.height = newHeightBasePx;
    //}

    ajustmentInHeightProportionsHeartBaseBoxes(ajustmentInHeightProportions);
    ajustmentInHeightProportionsHeadHeartBoxes(ajustmentInHeightProportions);

}, false);

proportionHeartScent.addEventListener('change', function(){
    let newHeightHeart = proportionHeartScent.value/100*120*3;
    let newHeightHeartPx = newHeightHeart + "px";
    document.getElementById("proportionHeartScent").style.height = newHeightHeartPx;
    proportionHeadScent.value = 100 - proportionBaseScent.value - proportionHeartScent.value;
    if (proportionHeadScent.value<0) {
        proportionHeadScent.value = 0;
    }
    proportionBaseScent.value = 100 - proportionHeadScent.value - proportionHeartScent.value;
    let newHeightBase = proportionBaseScent.value/100*120*3;
    let newHeightBasePx = newHeightBase + "px";
    document.getElementById("proportionBaseScent").style.height = newHeightBasePx;
    let newHeightHead = proportionHeadScent.value/100*120*3;
    let newHeightHeadPx = newHeightHead + "px";
    document.getElementById("proportionHeadScent").style.height = newHeightHeadPx;

    ajustmentInHeightProportionsHeartBaseBoxes(ajustmentInHeightProportions);
    ajustmentInHeightProportionsHeadHeartBoxes(ajustmentInHeightProportions);

}, false);

proportionBaseScent.addEventListener('change', function(){
    let newHeightBase = proportionBaseScent.value/100*120*3;
    let newHeightBasePx = newHeightBase + "px";
    document.getElementById("proportionBaseScent").style.height = newHeightBasePx;
    proportionHeartScent.value = 100 - proportionHeadScent.value - proportionBaseScent.value;
    if (proportionHeartScent.value<0) {
        proportionHeartScent.value = 0;
    }
    proportionHeadScent.value = 100 - proportionBaseScent.value - proportionHeartScent.value;
    let newHeightHead = proportionHeadScent.value/100*120*3;
    let newHeightHeadPx = newHeightHead + "px";
    document.getElementById("proportionHeadScent").style.height = newHeightHeadPx;
    let newHeightHeart = proportionHeartScent.value/100*120*3;
    let newHeightHeartPx = newHeightHeart + "px";
    document.getElementById("proportionHeartScent").style.height = newHeightHeartPx;

    ajustmentInHeightProportionsHeartBaseBoxes(ajustmentInHeightProportions, newHeightHeart, newHeightBase);
    ajustmentInHeightProportionsHeadHeartBoxes(ajustmentInHeightProportions, newHeightHeart, newHeightHead);

}, false);

