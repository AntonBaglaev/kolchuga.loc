function addLink() {
	var body_element = document.getElementsByTagName('body')[0];
	var selection = document.getSelection();
	var pagelink = "<p>" + text + " <a href='"+document.location.href+"'>"+document.location.href+"</a></p>";
	var copytext = selection + pagelink;
	var newdiv = document.createElement('div');
	body_element.appendChild(newdiv);
	newdiv.innerHTML = copytext;
	selection.selectAllChildren(newdiv);
	window.setTimeout( function() {
		body_element.removeChild(newdiv);
		}, 0);
}
document.oncopy = addLink;