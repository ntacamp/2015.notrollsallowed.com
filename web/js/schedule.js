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

	var favorites = JSON.parse(localStorage.favorites || '[]')
	var activeTracks = JSON.parse(localStorage.activeTracks || '[1, 2]');
	var cachedData = [];


	activeTracks.forEach(function(trackId) {
		$('[data-track="' + trackId + '"]').parent().addClass('active');
	})

	function toggleTrack(trackId) {

		let trackIndex = activeTracks.indexOf(trackId);

		if (trackIndex === -1) {
			activeTracks.push(trackId);
		} else {
			activeTracks.splice(trackIndex, 1);
		}

		localStorage.activeTracks = JSON.stringify(activeTracks);

		setData(cachedData);

		$('[data-track="fav"]').parent().removeClass('active');
		$('[data-track="' + trackId + '"]').parent().toggleClass('active');
	}

	function setData(data) {

		var template = $('#talk-template').html();
		var container = $('.talks');

		data = data.filter(function(item) {
			return activeTracks.indexOf(item.trackId) !== -1;
		})

		data.sort(function(a, b) {

			var aTime = parseInt((a.day + a.time).replace(':', ''));
			var bTime = parseInt((b.day + b.time).replace(':', ''));

			return aTime - bTime;
		})

		var days = data.groupBy('day');

		container.empty();
		
		Object.keys(days).forEach(function(day) {

			container.append('<h2>Day ' + day + '</h2>')

			days[day].forEach(function(talk) {

				let talkElement = $(template.interpolate(talk))
				let timeElement = $(talkElement).find('.time');
				let isFavorite = favorites.find(function(favorite) {
					return favorite === talk.id
				}) 

				timeElement.click(function(event) {
					event.preventDefault();
					toggleFavorite(talk.id);
				})

				if (isFavorite) {
					timeElement.addClass('active')
				};

				container.append(talkElement)

			})
		})
	} 

	function toggleFavorite(talkId) {

		let favIndex = favorites.findIndex(function(favorite) {
			return favorite === talkId;
		})

		if (favIndex === -1) {

			var talk = cachedData.find(function(talk) {
				return talk.id === talkId;
			})

			favorites.push(talk.id);

			$('.talk[data-id="' + talkId + '"] .time').addClass('active');

		} else {

			favorites.splice(favIndex, 1);

			$('.talk[data-id="' + talkId + '"] .time').removeClass('active');
		}

		localStorage.favorites = JSON.stringify(favorites);
		
	}

	$.getJSON('/lt/timetable/json', function( data ) {
		setData(data || []);
		cachedData = data;
	});

	$('.nav li a').click(function(event) {

		event.preventDefault();

		var track = $(this).data().track;

		if (track === 'fav') {

			var data = cachedData.filter(function(talk) {
				return favorites.indexOf(talk.id) !== -1;
			})

			setData(data || []);

			$('[data-track]').parent().removeClass('active');
			$('[data-track="fav"]').parent().addClass('active');

			return;
		} 

		toggleTrack(track);

	})

})


