
var proportionHeadScent = document.getElementById("created_perfume_proportionHeadScent");
var proportionHeartScent = document.getElementById("created_perfume_proportionHeartScent");
var proportionBaseScent = document.getElementById("created_perfume_proportionBaseScent");

var ajustmentInHeightProportions=22/100*120*3;

function ajustmentInHeightProportionsHeadHeartBoxes(ajustment){
    if ((Number(proportionHeadScent.value) + Number(proportionHeartScent.value))<=45){
        document.getElementById("proportionHeadScentInput").style.bottom=ajustment.toString()+"px";
        /* document.getElementById("proportionHeartScentInput").style.top=ajustment.toString()+"px"; */
        document.getElementById("headScentInput").style.bottom=ajustment.toString()+"px";
        /* document.getElementById("heartScentInput").style.top=ajustment.toString()+"px"; */
    } else {
        document.getElementById("proportionHeadScentInput").style.bottom="0px";
        document.getElementById("proportionHeartScentInput").style.top="0px";
        document.getElementById("headScentInput").style.bottom="0px";
        document.getElementById("heartScentInput").style.top="0px";
    }
}

function ajustmentInHeightProportionsHeartBaseBoxes(ajustment){
    if ((Number(proportionBaseScent.value) + Number(proportionHeartScent.value))<=45){
        ajustmentBoolean = 1;
        /* document.getElementById("proportionHeartScentInput").style.top="-"+ajustment.toString()+"px"; */
        document.getElementById("proportionBaseScentInput").style.top=ajustment.toString()+"px";
        /* document.getElementById("heartScentInput").style.top="-"+ajustment.toString()+"px"; */
        document.getElementById("baseScentInput").style.top=ajustment.toString()+"px";
    } else if ((Number(proportionHeadScent.value) + Number(proportionHeartScent.value))<=45) {
        document.getElementById("proportionBaseScentInput").style.top="0px";
        document.getElementById("baseScentInput").style.top="0px";
    } else {
        document.getElementById("proportionHeartScentInput").style.top="0px";
        document.getElementById("heartScentInput").style.top="0px";
        document.getElementById("proportionBaseScentInput").style.top="0px";
        document.getElementById("baseScentInput").style.top="0px";
    }
}

proportionHeadScent.addEventListener('change', function(){
    let newHeightHead = proportionHeadScent.value/100*120*3;
    let newHeightHeadPx = newHeightHead + "px";
    document.getElementById("proportionHeadScent").style.height = newHeightHeadPx;
    proportionBaseScent.value = 100 - proportionHeadScent.value - proportionHeartScent.value;
    if (proportionBaseScent.value<0) {
        proportionBaseScent.value = 0;
        proportionHeartScent.value = 100 - proportionBaseScent.value - proportionHeadScent.value;
        let newHeightHeart = proportionHeartScent.value/100*120*3;
        let newHeightHeartPx = newHeightHeart + "px";
        document.getElementById("proportionHeartScent").style.height = newHeightHeartPx;
    } else {
        let newHeightBase = proportionBaseScent.value/100*120*3;
        let newHeightBasePx = newHeightBase + "px";
        document.getElementById("proportionBaseScent").style.height = newHeightBasePx;
    }

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
        proportionBaseScent.value = 100 - proportionHeadScent.value - proportionHeartScent.value;
        let newHeightBase = proportionBaseScent.value/100*120*3;
        let newHeightBasePx = newHeightBase + "px";
        document.getElementById("proportionBaseScent").style.height = newHeightBasePx;
    } else {
        let newHeightHead = proportionHeadScent.value/100*120*3;
        let newHeightHeadPx = newHeightHead + "px";
        document.getElementById("proportionHeadScent").style.height = newHeightHeadPx;
    }

    ajustmentInHeightProportionsHeadHeartBoxes(ajustmentInHeightProportions);
    ajustmentInHeightProportionsHeartBaseBoxes(ajustmentInHeightProportions);

}, false);

proportionBaseScent.addEventListener('change', function(){
    let newHeightBase = proportionBaseScent.value/100*120*3;
    let newHeightBasePx = newHeightBase + "px";
    document.getElementById("proportionBaseScent").style.height = newHeightBasePx;
    proportionHeartScent.value = 100 - proportionHeadScent.value - proportionBaseScent.value;
    if (proportionHeartScent.value<0) {
        proportionHeartScent.value = 0;
        proportionHeadScent.value = 100 - proportionBaseScent.value - proportionHeartScent.value;
        let newHeightHead = proportionHeadScent.value/100*120*3;
        let newHeightHeadPx = newHeightHead + "px";
        document.getElementById("proportionHeadScent").style.height = newHeightHeadPx;
    } else {
        let newHeightHeart = proportionHeartScent.value/100*120*3;
        let newHeightHeartPx = newHeightHeart + "px";
        document.getElementById("proportionHeartScent").style.height = newHeightHeartPx;
    }

    ajustmentInHeightProportionsHeadHeartBoxes(ajustmentInHeightProportions);
    ajustmentInHeightProportionsHeartBaseBoxes(ajustmentInHeightProportions);

}, false);

