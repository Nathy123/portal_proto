
  function hello(message) {
    alert("Hello Nath: " + message);
  }

  //Update PageTime

  function updatePT(){
    var currDate = new Date();
    document.getElementById("pageInfo").innerHTML = "Last Update at: " + currDate;
  }

  function toggleVisible(panelElem){
    var portalElem = document.getElementById(panelElem);
    if (portalElem.style.visibility === "hidden"){
      portalElem.style.visibility = "visible";
    } else {
      portalElem.style.visibility = "hidden";
    }
  }

  function toggleOpacity(panelElem){
    var portalElem = document.getElementById(panelElem);
    if (portalElem.style.opacity == 0 ){
      portalElem.style.opacity = 1;
    } else {
      portalElem.style.opacity = 0;
    }
  }

  function makeAjaxCall(serviceUrl, data) {
    var httpRequest;
    var returnObj = null;
    if (window.XMLHttpRequest) 
       httpRequest = new XMLHttpRequest();
    else if (window.ActiveXObject) {
      try {
        httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
      }
      catch (e) {
        //As the variable is not set, an error message will be 
        //displayed from the else below.
      }
    }

    if (httpRequest) {
      httpRequest.onreadystatechange = submitRequest;  
      httpRequest.open('GET', serviceUrl+"?url="+data, false); 
      httpRequest.send();
    } else {
        alert("An error occurred whilst attempting to contact the server.");
    }

    function submitRequest() {
      if (httpRequest.readyState === 4) {
        if (httpRequest.status === 200) {
          var serverResponse = httpRequest.responseText;
          returnObj = serverResponse;
        } 
        else {
          returnObj = "The server did not respond. Attempting again in 50s.";
        }
      }
    }
    return returnObj;
  }

  function updateDomElement(elemId, elemContent) {
    var domElement = document.getElementById(elemId);
    if (domElement) {
      domElement.innerHTML = (elemContent);
    }
  }

  function JSONHandler(panelElem, responseObj){
    var jsonObj = JSON.parse(responseObj);
    var info = jsonObj.a; 
    updateDomElement(panelElem, info);
  }

  function XMLHandler(panelElem, xmlObj){
    null;
  }

