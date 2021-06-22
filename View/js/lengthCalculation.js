$(document).ready(function(){
    $('select').formSelect();


    $("#lengthCalculation").click(function() {
        var unitSelect = $("#unitSelect").val();
        var length = $("#length").val();
        var lengthInMeter = 0;

        if(unitSelect == "m") {
            lengthInMeter = length;
        } else if(unitSelect == "ft") {
            lengthInMeter = length/3.28084;
        } else if(unitSelect == "yd") {
            lengthInMeter = length/1.0936;
        } else if(unitSelect == "nm") {
            lengthInMeter = length/1000000000;
        } else if(unitSelect == "cm") {
            lengthInMeter = length/100;
        } else if(unitSelect == "mm") {
            lengthInMeter = length/1000;
        } else if(unitSelect == "in") {
            lengthInMeter = length/39.37;
        }




        var UnitHtml = '<h4>Meter : '+Math.round(lengthInMeter*100)/100+' m</h4>';
        UnitHtml = UnitHtml + '<h4>Yards : '+Math.round(lengthInMeter*1.0936*100)/100+' yd</h4>';
        UnitHtml = UnitHtml + '<h4>Feet : '+Math.round(lengthInMeter*3.28084*100)/100+' ft</h4>';
        UnitHtml = UnitHtml + '<h4>Nano Meter : '+Math.round(lengthInMeter*1000000000*100)/100+' nm</h4>';
        UnitHtml = UnitHtml + '<h4>Centy Meter : '+Math.round(lengthInMeter*100*100)/100+' cm</h4>';
        UnitHtml = UnitHtml + '<h4>Mili Meter : '+Math.round(lengthInMeter*1000*100)/100+' mm</h4>';
        UnitHtml = UnitHtml + '<h4>Inch : '+Math.round(lengthInMeter*39.37*100)/100+' in</h4>';
        $( "#UnitCalculatedValues" ).html(UnitHtml);
    });

});
