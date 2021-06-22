 var projectData = {};
 projectData.areas = {};
 
 $(document).ready(function(){
    $('.modal').modal();
    $('select').formSelect();
	$('.tooltipped').tooltip();
	$('#areaRow').hide();
	var itemId = 0;

	 $("#addAreaButton").click(function() {
		 resetModalForm()
	 });

	 $("#areaSelect").on('change', function() {
		 var electricItems = new Array(5);
		 electricItems['Bed Room'] = new Array('Inverter air condition','Laptop','Iron','Wifi router','Phone charger','Vacuum cleaner ','Home internet router');
		 electricItems['Tv Lobby'] = new Array('Radio','Desktop computer','Dvd player','Door bell','Home internet router','4G router','Phone charger','Av receiver','Aqurium pump','Home phone','Vacuum cleaner ');
		 electricItems['Kitchen'] = new Array('Refrigerator','Rice cooker','Electric kettle','Microwave oven','Pressure cooker','Toaster','Coffee maker','Cooker hood','Vacuum cleaner','Kitchen extractor fan','Blender','Hot plate');
		 electricItems['Dining Area'] = new Array('Refrigerator','Electric kettle','Toaster','Coffee maker','Vacuum cleaner','Water filter and cooler','Blender');
		 electricItems['Garage/Workshop'] = new Array('Electric garage door opener','Electric vehicle home charger',);
		 electricItems['Bathroom'] = new Array('Water heater','Towel heater','Exhaust fan','Hair bolw dryer','Domestic water pump','Washing Machine');
		 electricItems['Varendar'] = new Array('Test');
		 electricItems['Laundry Room'] = new Array('Washing Machine','Iron');
		 var areaType = $("#areaSelect").val();
		 var checkBoxString = "";
		 for(var i = 0 ; i < electricItems[areaType].length ; i++){
			 checkBoxString = checkBoxString + '<label>\n' +
				 '                      <input name="'+electricItems[areaType][i]+'" class="electricItemCheckBoxes" type="checkbox" />\n' +
				 '                      <span>'+electricItems[areaType][i]+'</span>\n' +
				 '                  </label>';
		 }
		 $( "#electricItemCheckBoxes" ).html(checkBoxString);
	 });

	 $("#bulbSelect").on('change', function() {
		 var bulbWatts = new Array(5);
		 bulbWatts['Incandescent'] = new Array('40','60','75','100');
		 bulbWatts['LED'] = new Array('6','9','10','13','16','18');
		 bulbWatts['Flourescent'] = new Array('8','9','13','14','18','19','23');
		 bulbWatts['Tube Light'] = new Array('8','12','16');
		 bulbWatts['Night Light'] = new Array('5');
		 var bulbType = $("#bulbSelect").val();
		 var OptionString = "";
		 for(var i = 0 ; i < bulbWatts[bulbType].length ; i++){
			 OptionString = OptionString + '<option value="' +bulbWatts[bulbType][i]+'">'+bulbWatts[bulbType][i]+'W</option>';
		 }
		 $( "#bulbWattSelect" ).html(OptionString);
		 $('select').formSelect();
	 });

  
  $("#addComponentAction").click(function() {
	  var newItem = {};
	  
	  var width = $("#width").val();
	  var length = $("#length").val();
	  var height = $("#height").val();
	  var type = $("#areaSelect").val();
	  var bulbType = $("#bulbWattSelect").val();
	  var bulbModel = $("#bulbSelect").val();
	  var fanType = $("#fanSelect").val();
	  var tvSize = $("#tvSelect").val();
	  var area = width * length;
	  newItem['width'] = width;
	  newItem['length'] = length;
	  newItem['height'] = height;
	  newItem['area'] = area;
	  newItem['type'] = type;
	  newItem['bulbType'] = bulbType;
	  newItem['bulbModel'] = bulbModel;
	  newItem['fanType'] = fanType;
	  newItem['tvSize'] = tvSize;
	  newItem['electricItems'] = new Array();
		var i =0;
	  $('#electricItemCheckBoxes input:checked').each(function() {
		  newItem['electricItems'][i] = $(this).attr('name');
		  i++;
	  });

	  projectData.areas[itemId]= newItem;
	  $('#areaRow').show();
	  $( "#itemsAdded" ).append( $( '<div class="row col m3" id="' +itemId+ '"><div class="col s12 m12"><div class="card" style="background-color:#FFCB00; border-radius: 10px;"><div class="card-content white-text" style="color:#240046 !important;"><span class="card-title">' + type +'</span><p>Width -: ' +width+ '</p><p>Length -: ' +length+ '</p><p>Height -: ' +height+ '</p><p>Area -: ' +area+ '</p> <p>Bulb -: ' +bulbType+ 'W</p></div></div></div></div>' ) );
	  itemId++;
});

	$("#calculateButton").click(function() {
		sendCalculationRequest(projectData);
		console.log(projectData);
	});
	
	$("#savProject").click(function() {
		var projectInfo = {};
		projectInfo['name'] = $("#name").val();
		projectInfo['description'] = $("#description").val();
		projectInfo['projectType'] = $("#projectTypeSelect").val();
		projectInfo['phase'] = $("input[name=phase]:checked").val();
		projectInfo['email'] = $("#email").val();
		projectInfo['housePlanFile'] = document.getElementById('housePlanFile').files[0];
		saveProjectData(projectInfo);
	});


});

function sendCalculationRequest(projectData) {
	console.log(projectData);
  $.ajax({
      url: 'Calculate.php',
      type: 'POST',
	  data: projectData,
      success: function(data){
		  console.log("calculated");
		  location.href = 'ResultesSummary.php?projectId=' + projectData['projectId'];
        //code to open in new window comes here
      }
  });
}

function saveProjectData(projectInfo) {
	console.log(projectInfo);
	
	var formData = new FormData()
    formData.append('name', projectInfo['name'])
    formData.append('description', projectInfo['description'])
    formData.append('projectType', projectInfo['projectType'])
    formData.append('phase', projectInfo['phase'])
    formData.append('email', projectInfo['email'])
    formData.append('housePlanFile', projectInfo['housePlanFile'])
	
  $.ajax({
      url: 'saveProjectInfo',
      type: 'POST',
	  data: formData,
	  contentType: false,
	  processData: false,
      success: function(data){
		  projectData['projectId'] = data;
		 M.toast({html: 'Successfully Saved', classes: 'green rounded'})
		  console.log(projectData);
        //code to open in new window comes here
      }
  });
}

function myFunction(){
	console.log("test log");
}

 function resetModalForm(){
	 $("#width").val('');
	$("#length").val('');
	 $("#height").val('');
	$("#areaSelect").val('');
	 $("#bulbWattSelect").val('');
	 $("#bulbSelect").val('');
	 $("#fanSelect").val('');
	 $("#tvSelect").val('');
	 $('select').formSelect();
 }
