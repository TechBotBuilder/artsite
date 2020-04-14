// allow progress-bar file upload
// source https://www.sitepoint.com/tracking-upload-progress-with-php-and-javascript/

function toggleBarVisibility(){
	var e = document.getElementById("upload_bar_blank");
	e.style.visibility = (e.style.visibility == 'visible') ? 'hidden' : 'visible';
	var f = document.getElementById('progress_form_controls');
	f.disabled = !f.disabled;
}

function createRequestObject(){
	var http;
	if(navigator.appName == "Microsoft Internet Explorer") {
		http = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		http = new XMLHttpRequest();
	}
	return http;
}

function sendRequest(){
	var http = createRequestObject();
	http.open('GET', 'upload_progress.php');
	http.onreadystatechange = function () { handleResponse(http); };
	http.send(null);
}

function handleResponse(http){
	var response;
	if(http.readyState == 4){
		response = http.responseText;
		document.getElementById('upload_bar_color').style.width = response + '%';
		document.getElementById('upload_bar_color').style.backgroundColor = 'rgb(0,200,'+200-2*Number.parseInt(response)+')';
		document.getElementById('upload_status').innerHTML = response + '%';
		
		if(response < 100) {
			setTimeout('sendRequest()', 500);
		}
		else{
			toggleBarVisibility();
			document.getElementById('upload_status').innerHTML = 'Upload complete!';
		}
	}
}

function startUpload(){
	toggleBarVisibility();
	document.getElementById('upload_status').innerHTML = 'Uploading...';
	setTimeout('sendRequest()', 500);
}

(function() {
	document.getElementById('progressForm').onsubmit = startUpload;
})();
