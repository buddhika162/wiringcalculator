$(document).ready(function(){
    $('select').formSelect();

    $("#currentTypeSelect").on('change', function() {
        var inputs = new Array(3);
        inputs['DC'] = new Array('Current/Power','Current/Resistance', 'Power/Resistance');
        inputs['AC Single Phase'] = new Array('Current/Power','Current/Resistance', 'Current/Impedance', 'Power/Resistance', 'Power/Impedance');
        inputs['AC Three Phase'] = new Array('Current/Power','Current/Resistance', 'Current/Impedance', 'Power/Resistance', 'Power/Impedance');
        var voltageType = $("#currentTypeSelect").val();
        var selectString = "<option value=\"\" disabled selected>Choose your option</option>";
        for(var i = 0 ; i < inputs[voltageType].length ; i++){
            selectString = selectString + '<option value="'+inputs[voltageType][i]+'">'+inputs[voltageType][i]+'</option>'
        }
        $( "#inputSelect" ).html(selectString);
        $('select').formSelect();
    });

    $("#inputSelect").on('change', function() {
        var inputs = [];
        inputs["Current"] = "Current (A)";
        inputs["Power"] = "Power (W)";
        inputs["Resistance"] = "Resistance (R)";
        inputs["Impedance"] = "Impedance (R)";
        var inputSelect = $("#inputSelect").val();
        var inputsItems = inputSelect.split("/");
        console.log(inputsItems);
        var input1string = '<input id="input1" type="text" class="validate">\n' +
            '                                        <label for="input1">'+inputs[inputsItems[0]]+'</label>';

        var input2string = '<input id="input2" type="text" class="validate">\n' +
            '                                        <label for="input2">'+inputs[inputsItems[1]]+'</label>';

        $( "#input1Div" ).html(input1string);
        $( "#input2Div" ).html(input2string);
    });

    $("#voltageCalculation").click(function() {
        var inputSelect = $("#inputSelect").val();
        var voltageType = $("#currentTypeSelect").val();
        var input1 = $("#input1").val();
        var input2 = $("#input2").val();
        var calculatedValue = 0;

        if(voltageType == "DC") {
            if(inputSelect == "Current/Power"){
                calculatedValue = input2/input1;
            } else if(inputSelect == "Current/Resistance"){
                calculatedValue = (input1*input2);
            } else if(inputSelect == "Power/Resistance"){
                calculatedValue = Math.sqrt(input1*input2); // squireroot
            }
        } else if(voltageType == "AC Single Phase") {
            if(inputSelect == "Current/Power"){
                calculatedValue = input2/(input1*0.9);
            } else if(inputSelect == "Current/Resistance"){
                calculatedValue = (input1*input2)/(0.9);
            } else if(inputSelect == "Power/Resistance"){
                calculatedValue = (Math.sqrt(input1*input2))/0.9; //squireRoot
            } else if(inputSelect == "Current/Impedance"){
                calculatedValue = input1*input2;
            } else if(inputSelect == "Power/Impedance"){
                calculatedValue = Math.sqrt((input1*input2)/0.9); //squaroot
            }
        } else if(voltageType == "AC Three Phase") {
            if(inputSelect == "Current/Power"){
                calculatedValue = input2/(input1*0.9*1.73);
            } else if(inputSelect == "Current/Resistance"){
                calculatedValue = (input1*input2)/0.9;
            } else if(inputSelect == "Power/Resistance"){
                calculatedValue = Math.sqrt((input1*input2)/3*0.9); //squireRoot
            } else if(inputSelect == "Current/Impedance"){
                calculatedValue = input1*input2;
            } else if(inputSelect == "Power/Impedance"){
                calculatedValue = Math.sqrt(input1*input2/(1.73*0.9)); //squaroot
            }
        }

        var calculatedString = '<h4>Voltage is: '+calculatedValue+' V</h4>';
        $( "#voltageCalculatedValue" ).html(calculatedString);
    });

});