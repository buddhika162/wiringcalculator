$(document).ready(function(){
    $('select').formSelect();

    $("#currentTypeSelect").on('change', function() {
        var inputs = new Array(3);
        
        inputs['AC Single Phase'] = new Array('Voltage/Current','Voltage/Power', 'Current/Power','Resistance');
        inputs['AC Three Phase'] = new Array('Voltage/Current','Voltage/Power', 'Current/Power','Resistance');
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
        inputs["Power"] = "Power (W)";
        inputs["Resistance"] = "Resistance (R)";
        inputs["Current"] = "Current (A)";
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

         if(currentType == "AC Single Phase") {
            if(inputSelect == "Voltage/Current"){
                calculatedValue = input1/input2;
            } else if(inputSelect == "Voltage/Power"){
                calculatedValue = (input1*input1*0.9)/input2;
            } else if(inputSelect == "Current/Power"){
                calculatedValue = input2/(input1*input1*0.9); 
            }  else if(inputSelect == "Resistance"){
                calculatedValue = (input1/0.9); 
            }
        } else if(currentType == "AC Three Phase") {
            if(inputSelect == "Voltage/Current"){
                calculatedValue = input1/input2;
            } else if(inputSelect == "Voltage/Power"){
                calculatedValue = (1.73*input1*input1*0.9)/input2;
            } else if(inputSelect == "Current/Power"){
                calculatedValue = input2/(input1*input1*0.9*1.73);
            } else if(inputSelect == "Resistance"){
                calculatedValue = input1/0.9;
            } 
        }

        var calculatedString = '<h4>Impedance is : '+calculatedValue+' ohm</h4>';
        $( "#currentCalculatedValue" ).html(calculatedString);
    });

});