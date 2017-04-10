var content = document.getElementById("noticias").innerHTML;
var html = "<pre>";
var first_dl_node = true;

html += "{\n";
html += "\t\"title\": \"" + ((val = header("Título")) !== null ? val : "") + "\",\n";
html += "\t\"japanese\": \"" + ((val = header("Alternativo")) !== null ? val : "") + "\",\n";
html += "\t\"episodes_total\": " + ((val = header("Episódios")) !== null ? val : "") + ",\n";
html += "\t\"premiered\": \"" + ((val = header("(?:Ano de lançamento|Lançado)")) !== null ? val : "") + "\",\n";
html += "\t\"synopsis\": \"" + ((val = header("SINOPSE")) !== null ? val : "") + "\",\n";
html += "\t\"status\": \"Concluído\",\n";
html += "\t\"genres\": \"" + ((val = header("Gênero")) !== null ? val : "") + "\",\n";
html += "\t\"studio\": \"" + ((val = header("Produtora")) !== null ? val : "") + "\",\n";
html += "\t\"director\": \"" + ((val = header("Diretor")) !== null ? val : "") + "\",\n";
html += "\t\"website\": \"" + ((val = header("Site Oficial")) !== null ? val : "") + "\",\n\n";

html += "\t\"episodes\": {";
downloads("Episódio", "Episódio");
downloads("Especial", "Especial");
downloads("(?:OVA|OAD|EX)", "OVA");
downloads("Filme", "Filme");
html += "\n\t}\n";
html += "}\n";
html += "</pre>";

document.body.innerHTML = html;

function header(keyword) {
	var regex = new RegExp(keyword + ".*?> (.*?)<", "");
	var match = regex.exec(content);
	return match == null ? null : match[1];
}

function downloads(keyword, json) {
	var regex = new RegExp(keyword + " (\\d+).*?>(.*?)<(br|\\/p)", "gi");
	var regex_dl = /href="(.*?)".*?>(?:<strong>){0,1}(.*?)</g;

	if(!first_dl_node) html += ",";
	html += "\n\t\t\"" + json + "\": [\n";

	var match_ep = regex.exec(content);
	var first_ep = true;
	while (match_ep != null) {
		if(!first_ep) html += ",\n";
		html += "\t\t\t{\n\t\t\t\t\"num\": " + parseInt(match_ep[1], 10) + ",\n\t\t\t\t\"title\": \"\",\n\t\t\t\t\"dl\": [\n";

		var match_dl = regex_dl.exec(match_ep[2]);
		var first_dl = true;
		while(match_dl != null) {
			var type = match_dl[2];
			if(type.indexOf('(') > 0) type = type.substring(0, type.indexOf('('));
			var link = match_dl[1];
			if(!first_dl) html += ",\n";
			html += "\t\t\t\t\t{ \"quality\": \"" + type + "\", \"link\": \"" + link + "\" }";
			match_dl = regex_dl.exec(match_ep[2]);
			first_dl = false;
		}
		html += "\n\t\t\t\t]\n\t\t\t}";	
		match_ep = regex.exec(content);
		first_ep = false;
	}

	html += "\n\t\t]";
	first_dl_node = false;
}