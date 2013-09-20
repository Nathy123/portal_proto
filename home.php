<!DOCTYPE html>
<html>

  <link href="styles/portal_home_style.css" rel="stylesheet"> </link>	
  <script src="scripts/portal_home_functions.js" type="text/javascript"></script>
  <script src="JQuery/jquery-2.0.2.min.js"></script>

  <?php include("scripts/general_functions.php"); ?>

  <header>
      <button id="pauseBtn"></button>
      <button id="prevBtn">Previous Feed</button>
      <button id="toolPanel">Panel</button>    
    <div id="pageInfo">
    </div>
  </header>

  <body>

    <div id="left_panel">

      <div id="lpHeader">
      </div>

      <div id="column_holder"> 
       <div id="col_one" class="column">
         Feed 1
       </div>
       <div id="col_two" class="column">
         Feed 2
       </div>
       <div id="col_three" class="column">
         Feed 3
       </div>
      </div>

    </div>

    <div id="right_panel">

      <div id="rpHeader">Videos</div>

      <div id="col_four" class="column">
        Feed 4
      </div>
    </div>

    <div id="central_panel">
      RSS Reader. Engadget. Reuters. FT.
      Weather Api.
      Playlist of trending YouTube Video's.
      Footie Tables - find an api.
      Sports news.
      203
      Test
      <a href="cms.php">Link</a>
      </br>
    </div>

    <script type="text/javascript">
     
    
 
      var address1 = "http://mf.feeds.reuters.com/reuters/UKWorldNews";   
      var address2 = "http://www.engadget.com/rss.xml"; 
      var address3 = "http://uk.finance.yahoo.com/news/category-international/?format=rss"; 
      var address4 = "http://mf.feeds.reuters.com/reuters/UKScienceNews";
      var address5 = "http://www.skysports.com/rss/0,20514,11661,00.xml"; //sky sports PL news  
      var address6 = "http://www.liverpoolfc.com/rss/news/latest";

      var rssFeeds = new Array (address1, address2, address3);  
      var columns = new Array ("col_one", "col_two", "col_three");
      var feedList = 1; 
      var transCompl = false;      


 
      function toggleFeedList(){
        if (feedList == 1){
          rssFeeds[0] = address4;
          rssFeeds[1] = address5;
          rssFeeds[2] = address6;
          feedList = 2;
        } else {
          rssFeeds[0] = address1;
          rssFeeds[1] = address2;
          rssFeeds[2] = address3;
          feedList = 1;
        }  
      }

    function refreshFeeds(){
    var response;
      for (var i = 0; i < 3; i++ ){
        response = makeAjaxCall('scripts/rssFunctions.php', rssFeeds[i]);
        if (response){
          updateDomElement(columns[i], response);
        }
      } 
      updatePT();
    } 

    //Premise is: Once toggle opacity finishes, refresh, redraw. check recursive.    

    function updateAllColumns(){
      if(transCompl === false){
        toggleFeedList();
        refreshFeeds();
        transCompl = true;
        document.getElementById("lpHeader").innerHTML = "News Feeds:";
        toggleOpacity("column_holder");
        //trans evt will fire when above setting to visibile ends so check the recursive 
      }
      else{
        //executed when the 'opacity = 1' completes  
        transCompl = false;
      }
    }



    //var feedRefresh = setInterval(repaintColumns, 250000);
    var feedRefresh; //= setInterval(repaintColumns, 50000);

    function initPauseBtn(){
      updateDomElement("pauseBtn", "Pause Feed Refresh");
      var pauseBtn = document.getElementById("pauseBtn");
      pauseBtn.onclick = pauseRefresh;
    }

    function initPrevBtn(){
      var prevBtn = document.getElementById("prevBtn");
      prevBtn.onclick = prevFeed;
    } 



    function pauseRefresh(eventObj){
      updateDomElement("pauseBtn", "Resume Feed Refresh");
      pauseBtn.onclick = resumeRefresh;
    }  

    function resumeRefresh(eventObj){
      initPauseBtn();
    }

    function prevFeed(){
      //Kill Intervals. Set page to Nought. Access Repo.
    }



    function setTransEvt() {  
      var colHolder = document.getElementById("column_holder");
      colHolder.addEventListener("transitionend", updateAllColumns, true);
    }   



    function initPage() {

      document.getElementById("column_holder").style.opacity = 1;  
      initPrevBtn();
      initPauseBtn();
      document.getElementById("lpHeader").innerHTML = "News Feeds:";
      refreshFeeds();
      setTransEvt();   
      feedRefresh = setInterval(repaintColumns, 50000);
    }

    function repaintColumns(){
      // when the transition completes updateAllColumns will execute.
      // opacity starts as 1. It is toggled to 0.
      // Ajax updates feeds. Once done. Toggles to 1.
      // Once TransEvt to opacity=1 completes updateAllColumns
      // Automatically called again. a flag is used for the second call
      // to handle and set up for the next refresh.  
      document.getElementById("lpHeader").innerHTML = "Updating Feeds";
      toggleOpacity("column_holder");    
    }   

    function myObject () 
    {
        //if you dont put this, name is assigned to global scope
        //only when the obj is created however.
    	this.name = "Nath";
    	gender = "male";
    }

    function testScope() 
    {
	//shoes us not defined within the global space
	shoes = "Nike";
    }


    //inheritance example
    function extendedType () 
    {
        var money = 5; 
    }
    // simply give the prototype a constructor to another
    // object prototype.	
    extendedType.prototype = new myObject();

    var prototypeObj = new extendedType(); 
    alert("Name is..." + prototypeObj.name);
    //as discussed below the following line has value undefined.
    alert("gender is..." + prototypeObj.gender);



    var myObj = new myObject();
 
    myObj.varName20 = "yay boobies";
    
    var myObj2 = new myObject(); 

    //below boobies is added to myObject.
    //this is to the prototype not the static constructor
    //thus all exisiting members get the variable.
    myObject.prototype.boobies = "happyPlace";

    //the above is also an example of differential inheritance.
    /* note that it saves space as the object is added
       in a single place - the constructor address space
       yet all derived objects will have access to it
    */

    var sandwhich = 
    {
	bread : "white",
        filling: "cheese"
    };
 
    var mySarnie = Object(sandwhich);

    var baconSarnie = Object(mySarnie);

    //illustrating changing prop value.
    baconSarnie.filling="bacon";
    alert(baconSarnie.filling);   

    //here the prototype is not required
    //as the was created using Object and nott a constructor.
    sandwhich.newFilling = "jalapeno";
    alert(baconSarnie.newFilling);


    function testJSC()
    {
        alert(myObj.varName20);
        alert(myObj.name);
        alert(gender);
        //varName20 is not available as it was added to an instance
	//not the object
        //alert(myObj2.varName20);

	//this now works:
        alert(myObj2.boobies);

        //below the statement does not add bum to the constructor
        //but to the function ?
        //thus the alert of bum has value undefined.
        myObject.jelly = "wibble wobble";
        var myObj3 = new myObject();
	alert(myObj3.jelly);

        //However this alert gives the true value 
        alert(myObject.jelly);
  

        alert(mySarnie.bread);
        //shoes doesnt exist as no testScope objs created.
        //alert(shoes);
 
        /*
	
	when the new keyword is used with a constructor
	the object returned contains a member
	called prototype. this is an object
	the value of this object is the memory address
	of the constructor being invoked.

	this means the new object can access all members
	of the:
		function object AKA
		constructor     AKA
		prototype

	upon which it is based. it contains the memory 
	locations of all those actual components. changing them 
	using the protoype. see example below.

	*/
	myObj2.name = "rodney";
	alert(myObj.name);
	alert(myObj2.name);

	//below wont change exisiting to Del 
	myObject.prototype.name = "Del";
	alert(myObj.name);
	alert(myObj2.name);
        /*
	This doesn't affect existing properties in derived 
 	objects.

	reason being the constructor has... this.name = nath;

	i can add new props which all derived inherit
	but cant change all of an existing prototype.
	*/
	var myObj4 = new myObject();
	alert("almost done: " + name);
	//no the above prints Nath indicating assignment above
	//not effective
	alert("done: " + myObj4.name);
        //above name resolves to Nath
        alert(myObject.prototype.name);
    }


    testJSC();

    initPage();  

    </script>

  </body>

<html>
