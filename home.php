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


    initPage();  

    </script>

  </body>

<html>
