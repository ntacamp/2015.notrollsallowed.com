$(function() {

	String.prototype.interpolate = function (o) {
		return this.replace(/{([^{}]*)}/g,
			function (a, b) {
				var r = o[b];
				return typeof r === 'string' || typeof r === 'number' ? r : a;
			}
			);
	};

	String.prototype.replaceAt = function(index, replacement) {
	    return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
	}

	Array.prototype.groupBy = function(key) {
		return this.reduce(function(rv, x) {
			(rv[x[key]] = rv[x[key]] || []).push(x);
			return rv;
		}, {});
	};

	var favorites = JSON.parse(localStorage.favorites || '[]')
	var activeTracks = JSON.parse(localStorage.activeTracks || '[1, 2, 3]');
	var cachedData = [];

	var eventDates = {
		'1': new Date('2019-07-26'),
		'2': new Date('2019-07-27'),
		'3': new Date('2019-07-28'),
	}


	activeTracks.forEach(function(trackId) {
		$('[data-track="' + trackId + '"]').parent().addClass('active');
	})

	function scrollToAnchor(aid){
	    var aTag = $("[name='"+ aid +"']");
	    $('html,body').animate({scrollTop: aTag.offset().top},'fast');
	}

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

	function setData(data, noFilter) {

		var template = $('#talk-template').html();
		var container = $('.talks');

		if (!noFilter) {
			data = data.filter(function(item) {
				return activeTracks.indexOf(item.trackId) !== -1;
			})
		}

		data.sort(function(a, b) {

			var aHour = a.time.replace(':', '');
			var bHour = b.time.replace(':', '');

			if (aHour.startsWith('0')) {
				aHour = aHour.replaceAt(0, '3');
			}

			if (bHour.startsWith('0')) {
				bHour = bHour.replaceAt(0, '3');
			}

			var aTime = a.day + aHour;
			var bTime = b.day + bHour;

			return parseInt(aTime) - parseInt(bTime);
		})

		var days = data.groupBy('day');

		container.empty();

		Object.keys(days).forEach(function(day) {

			container.append('<h2 name="day' + day + '">Day ' + day + '</h2>')

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

		var dayIndex = Object.keys(eventDates).find(function(day) {
			var today = new Date()
			return (today.toDateString() === eventDates[day].toDateString());
		})

		scrollToAnchor('day' + dayIndex);
		
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

	function scrollListener(event) {

		let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

		if (scrollTop > 60) {
			document.body.classList.add('fixed')
		} else {
			document.body.classList.remove('fixed')
		}

	}

	$.getJSON('/lt/timetable/json', function( data ) {
		setData(data || []);
		cachedData = data;
	});

	$('.schedule .nav li a').click(function(event) {

		event.preventDefault();

		var track = $(this).data().track;

		if (track === 'fav') {

			var data = cachedData.filter(function(talk) {
				return favorites.indexOf(talk.id) !== -1;
			})

			setData(data || [], true);

			$('[data-track]').parent().removeClass('active');
			$('[data-track="fav"]').parent().addClass('active');

			activeTracks = [];

			return;
		} 

		toggleTrack(track);
	})


	window.addEventListener('scroll', scrollListener);

})


