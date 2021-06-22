$(document).ready(function(){
    $('select').formSelect();

    $("#currentTypeSelect").on('change', function() {
        var inputs = new Array(3);
        inputs['DC'] = new Array('Voltage/Current');
        inputs['AC Single Phase'] = new Array('Voltage/Current','Active power/Reactive power', 'Current/Impedance', 'Current/Resistance', 'Voltage/Impedance', 'Voltage/Resistance', 'Active power', 'Reactive power');
        inputs['AC Three Phase'] = new Array('Voltage/Current','Active power/Reactive power', 'Current/Impedance', 'Current/Resistance', 'Voltage/Impedance', 'Voltage/Resistance', 'Active power', 'Reactive power');
        var currentType = $("#currentTypeSelect").val();
        var selectString = "<option value=\"\" disabled selected>Choose your option</option>";
        for(var i = 0 ; i < inputs[currentType].length ; i++){
            selectString = selectString + '<option value="'+inputs[currentType][i]+'">'+inputs[currentType][i]+'</option>'
        }
        $( "#inputSelect" ).html(selectString);
        $('select').formSelect();
    });

    $("#inputSelect").on('change', function() {
        var inputs = [];
        inputs["Voltage"] = "Voltage (V)";
        inputs["Current"] = "Current (A)";
        inputs["Resistance"] = "Resistance (R)";
        inputs["Impedance"] = "Impedance (R)";
        inputs["Active power"] = "Active power (W)";
        inputs["Reactive power"] = "Reactive power (VAr)";
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

    $("#currentCalculation").click(function() {
        var inputSelect = $("#inputSelect").val();
        var currentType = $("#currentTypeSelect").val();
        var input1 = $("#input1").val();
        var input2 = $("#input2").val();
        var calculatedValue = 0;

        if(currentType == "DC") {
            if(inputSelect == "Voltage/Current"){
                calculatedValue = (input2*input1);
            } 
        } else if(currentType == "AC Single Phase") {
            if(inputSelect == "Voltage/Current"){
                calculatedValue = (input2*input1);
            } else if(inputSelect == "Active power/Reactive power"){
                calculatedValue = Math.sqrt((input1*input1)+(input2*input2)); //squireRoot
            } else if(inputSelect == "Current/Impedance"){
                calculatedValue = (input1*input1)*input2; 
            } else if(inputSelect == "Current/Resistance"){
                calculatedValue = ((input1*input1)*input2)/0.9;
            } else if(inputSelect == "Voltage/Impedance"){
                calculatedValue = (input1*input1)/input2;
            } else if(inputSelect == "Voltage/Resistance"){
                calculatedValue = (input1*input1*0.9)/input2;
            } else if(inputSelect == "Active power"){
                calculatedValue = (input1/0.9);
            } else if(inputSelect == "Reactive power"){
                calculatedValue = (input1/0.436);
            }
			
        } else if(currentType == "AC Three Phase") {
            if(inputSelect == "Voltage/Current"){
                calculatedValue = 1.73*(input2*input1);
            } else if(inputSelect == "Active power/Reactive power"){
                calculatedValue = Math.sqrt((input1*input1)+(input2*input2)); //squireRoot
            } else if(inputSelect == "Current/Impedance"){
                calculatedValue = 1.73*(input1*input1)*input2;
            } else if(inputSelect == "Current/Resistance"){
                calculatedValue = (1.73*(input1*input1)*input2)/0.9;
            } else if(inputSelect == "Voltage/Impedance"){
                calculatedValue = (1.73*input1*input1)/input2
            } else if(inputSelect == "Voltage/Resistance"){
                calculatedValue = (1.73*input1*input1*0.9)/input2;
            } else if(inputSelect == "Active power"){
                calculatedValue = (input1/0.9);
            } else if(inputSelect == "Reactive power"){
                calculatedValue = (input1/0.436);
            }
        }

        var calculatedString = '<h4>Apparent Power is : '+calculatedValue+' VA</h4>';
        $( "#currentCalculatedValue" ).html(calculatedString);
    });

});