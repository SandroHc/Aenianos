$input = $('#input');
if(!$input)
	throw new Error("No input found!")

timer = 0

delay = () ->
	return (callback, ms) ->
		clearTimeout(timer);
		timer = setTimeout(callback, ms)

$input.keyup(() ->
  delay(search, 5000)
);

search() ->
	val = $input.val()
	if(!val)
		return;

	console.log("Seaching for: " + val)

	username = "user"
	password = "pass"

	$.ajax
	({
		method: "GET",
		url: "https://myanimelist.net/api/anime/search.xml",
		dataType: 'xml',
    #	async: false,
		data: {
			q: val
		},
		headers: {
			"Authorization": "Basic " + btoa(username + ":" + password)
		},
		success: (data, textStatus, xhr) ->
			# xhr.responseXML

			alert('Success!')
		,
		error: (xhr, textStatus, errorThrown) ->
			alert('Error ' + textStatus + '! ' + errorThrown)
	});