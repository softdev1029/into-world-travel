(function($){
	ymaps.ready(function () {
		myMap = new ymaps.Map('constructor', {
            center: [54.25724103699681,56.08945740770236],
            zoom: $("#mapzoom").val(),
			type:  "yandex#publicMap",
			controls: ['smallMapDefaultSet']
        });
		mySearchControl = new ymaps.control.SearchControl({
            options: {
                noPlacemark: true
            }
        }),
    // Результаты поиска будем помещать в коллекцию.
        mySearchResults = new ymaps.GeoObjectCollection(null, {
            hintContentLayout: ymaps.templateLayoutFactory.createClass('$[properties.name]'),
			draggable: true,
			preset:'islands#redIcon'
        });
	myResults = new ymaps.GeoObjectCollection();
    myMap.controls.add(mySearchControl);
	myMap.geoObjects.add(myResults);
    myMap.geoObjects.add(mySearchResults);

	$.each($("#placemarks").val().split('|'),function(index,value){
			if (value != '')	{
			  myResults.add(new ymaps.Placemark(value.split(','),{},{draggable:true}));
			  myMap.setCenter(value.split(','));
			}
		 });

    // Выбранный результат помещаем в коллекцию.
    mySearchControl.events.add('resultselect', function (e) {
        var index = e.get('index');
        mySearchControl.getResult(index).then(function (res) {
           mySearchResults.add(res);
        });
    }).add('submit', function () {
           mySearchResults.removeAll();
        })
		
		
    myMap.geoObjects.events.add('dblclick', function (e) {
		coords = e.get('target').geometry.getCoordinates();
		data = $("#placemarks").val().split('|');
		
		$.each(data,function(index,value){
				if (value == coords.join(',')) {
					data.splice(index,1);
				}
			});
		$("#placemarks").val(data.join('|'));
		myResults.removeAll();
		mySearchResults.removeAll();
		$.each(data,function(index,value){
		  myResults.add(new ymaps.Placemark(value.split(','),{},{draggable:true}));
		});
	});	
	
	
	myMap.geoObjects.events.add("dragstart", function (e) {
		coords = e.get('target').geometry.getCoordinates();
		data = $("#placemarks").val().split('|');
		$.each(data,function(index,value){
			if (value == coords.join(',')) {
				data.splice(index,1);
			}
		});
		$("#placemarks").val(data.join('|'));
	});
	myMap.geoObjects.events.add("dragend", function (e) {
        coords = e.get('target').geometry.getCoordinates()
		data = $("#placemarks").val().split('|');
		ndata = data.concat(coords.join(','));
		   
		 $("#placemarks").val(ndata.join('|')); 
		 mySearchResults.removeAll();
		 myResults.removeAll();
		 $.each(ndata,function(index,value){
			  myResults.add(new ymaps.Placemark(value.split(','),{},{draggable:true}));
		 });
	});
	myMap.events.add(['boundschange'], function() {
		 $("#mapzoom").val(myMap.getZoom())
	});
	});
})(jQuery);