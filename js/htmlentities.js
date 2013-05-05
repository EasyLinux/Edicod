function HTMLentities(texte) {
texte = texte.replace(/\"/g,'&quot;'); // 34 22
texte = texte.replace(/&/g,'&amp;'); // 38 26
texte = texte.replace(/\'/g,'&#39;'); // 39 27
texte = texte.replace(/</g,'&lt;'); // 60 3C
texte = texte.replace(/>/g,'&gt;'); // 62 3E
texte = texte.replace(/à/g,'&aacute;'); // 224 E0
texte = texte.replace(/â/g,'&acirc;'); // 226 E2
texte = texte.replace(/ç/g,'&ccedil;'); // 231 E7
texte = texte.replace(/è/g,'&egrave;'); // 232 E8
texte = texte.replace(/é/g,'&eacute;'); // 233 E9
texte = texte.replace(/ê/g,'&ecirc;'); // 234 EA
texte = texte.replace(/ë/g,'&euml;'); // 235 EB
texte = texte.replace(/ô/g,'&ocirc;'); // 244 F4
texte = texte.replace(/ù/g,'&ugrave;'); // 249 F9
texte = texte.replace(/û/g,'&ucirc;'); // 251 FB
return texte;
}

//Décode une chaîne
function html_entity_decode(texte) {
	texte = texte.replace(/&quot;/g,'"'); // 34 22
	texte = texte.replace(/&amp;/g,'&'); // 38 26	
	texte = texte.replace(/&#39;/g,"'"); // 39 27
	texte = texte.replace(/&lt;/g,'<'); // 60 3C
	texte = texte.replace(/&gt;/g,'>'); // 62 3E
	texte = texte.replace(/&nbsp;/g,' '); // 160 A0
	texte = texte.replace(/&agrave;/g,'à'); // 224 E0
	texte = texte.replace(/&egrave;/g,'è'); // 232 E8
	texte = texte.replace(/&eacute;/g,'é'); // 233 E9
	texte = texte.replace(/&ecirc;/g,'ê'); // 234 EA
	texte = texte.replace(/&euml;/g,'ë'); // 235 EB
	texte = texte.replace(/&ocirc;/g,'ô'); // 244 F4
	texte = texte.replace(/&ugrave;/g,'ù'); // 249 F9
	return texte;
}


