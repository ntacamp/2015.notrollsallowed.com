$(function() {

	String.prototype.interpolate = function (o) {
	    return this.replace(/{([^{}]*)}/g,
	        function (a, b) {
	            var r = o[b];
	            return typeof r === 'string' || typeof r === 'number' ? r : a;
	        }
	    );
	};

	Array.prototype.groupBy = function(key) {
	  return this.reduce(function(rv, x) {
	    (rv[x[key]] = rv[x[key]] || []).push(x);
	    return rv;
	  }, {});
	};

	$.getJSON('/lt/timetable/json', function( data ) {

		var template = $('#talk-template').html();
		var container = $('.talks');

		var days = data.groupBy('day');
		
		Object.keys(days).forEach(function(day) {

			container.append('<h2>Day ' + day + '</h2>')

			days[day].forEach(function(talk) {
				container.append(template.interpolate(talk))
			})
		})

	});
})