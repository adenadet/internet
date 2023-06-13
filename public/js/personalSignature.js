
	var imgWidth;
	var imgHeight;
	function StartSign()
	 {   
	    var isInstalled = document.documentElement.getAttribute('SigPlusExtLiteExtension-installed');  
	    if (!isInstalled) {
	        alert("SigPlusExtLite extension is either not installed or disabled. Please install or enable extension.");
			return;
	    }	
	    var canvasObj = document.getElementById('cnv');
		canvasObj.getContext('2d').clearRect(0, 0, canvasObj.width, canvasObj.height);
		document.FORM1.sigStringData.value = "SigString: ";
		document.FORM1.sigRawData.value = "Base64 String: ";
		imgWidth = canvasObj.width;
		imgHeight = canvasObj.height;
		var message = { "firstName": "", "lastName": "", "eMail": "", "location": "", "imageFormat": 1, "imageX": imgWidth, "imageY": imgHeight, "imageTransparency": false, "imageScaling": false, "maxUpScalePercent": 0.0, "rawDataFormat": "ENC", "minSigPoints": 25 };
			
		top.document.addEventListener('SignResponse', SignResponse, false);
		var messageData = JSON.stringify(message);
		var element = document.createElement("MyExtensionDataElement");
		element.setAttribute("messageAttribute", messageData);
		document.documentElement.appendChild(element);
		var evt = document.createEvent("Events");
		evt.initEvent("SignStartEvent", true, false);				
		element.dispatchEvent(evt);		
    }
	function SignResponse(event)
	{	
		var str = event.target.getAttribute("msgAttribute");
		var obj = JSON.parse(str);
		SetValues(obj, imgWidth, imgHeight);
	}
	function SetValues(objResponse, imageWidth, imageHeight)
	{
        var obj = null;
		if(typeof(objResponse) === 'string'){
			obj = JSON.parse(objResponse);
		} else{
			obj = JSON.parse(JSON.stringify(objResponse));
		}		
		
	    var ctx = document.getElementById('cnv').getContext('2d');

			if (obj.errorMsg != null && obj.errorMsg!="" && obj.errorMsg!="undefined")
			{
                alert(obj.errorMsg);
            }
            else
			{
                if (obj.isSigned)
				{
                    document.FORM1.sigRawData.value += obj.imageData;
					document.FORM1.sigStringData.value += obj.sigString;
					var img = new Image();
					img.onload = function () 
					{
						ctx.drawImage(img, 0, 0, imageWidth, imageHeight);
					}
					img.src = "data:image/png;base64," + obj.imageData;
                }
            }
    }
    function ClearFormData()
	{
	     document.FORM1.sigStringData.value = "SigString: ";
	     document.FORM1.sigRawData.value = "Base64 String: ";
	     document.getElementById('SignBtn').disabled = false;
    }