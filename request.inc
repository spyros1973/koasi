function makeRequest(page,action, p1, p2,loader) {
		var xmlhttp = new XMLHttpRequest();
		if (loader) 
			document.getElementById(loader).innerHTML = "<img src='images/camberwait.gif'/>";
		else
			if (document.getElementById("dimOverlay"))
				document.getElementById("dimOverlay").style.display = "block";
		var tmpUrl = page + "?p1=" + p1 + "&p2=" + p2 + "&action=" + action + "&unique=" + (new Date()).getTime(); 		
		console.log(tmpUrl);
		xmlhttp.onreadystatechange = function () {
			try {
				if (xmlhttp.readyState == 4) {
					if (loader) 
						document.getElementById(loader).innerHTML = "";
					else
						if (document.getElementById("dimOverlay"))
							document.getElementById("dimOverlay").style.display = "none";
					if ((xmlhttp.status == 200) || (xmlhttp.status == 202)) {						
						var res = JSON.parse(xmlhttp.responseText);						
						processRequestResults(action,res,p1,p2);
					}
				}
			}
			catch (e) {
				var res={};
				res.info="1";
				res.message="There was an error accessing KOASI.";
				processRequestResults(action,res,p1,p2);
			}
		}

		xmlhttp.open("GET", tmpUrl, true);
		xmlhttp.send();
    }