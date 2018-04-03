<!DOCTYPE html>  

<?php 
  require('debugging.php');
  require('session.php');

  if ($_GET["argument"]=='signOut'){
    logout();
  }

  //redirectIfNot('taskee');

  function showUser() {
    if (isLoggedIn()) {
      echo '
      <div class="ui dropdown inverted button">Hello, '. $_SESSION['userName'] . '</div>
      <div class="ui dropdown inverted button" id="signOut" formaction="/demo/signup.php">Sign Out</div>
      ';
    } else {
      echo "<a class='ui inverted button' href='/demo/login.php'>Log in</a>
      <a class='ui inverted button' href='/demo/signup.php'>Sign Up</a>";
    }
  }


  function showBidders() {
      // Connect to the database. Please change the password in the following line accordingly
  $db = pg_connect("host=127.0.0.1 port=5432 dbname=project1 user=postgres password=1234") or die('Could not connect ' . pg_last_error()); 
    $userEmail = $_SESSION['userEmail'];
    $result = pg_query($db, "SELECT * FROM tasks WHERE taskeeemail = '$userEmail' ");
    while ($row = pg_fetch_assoc($result)) {
      echo "
          <div class='card'>
            <div class='content'>
              <a class='header'>$row[ttype]</a>
              <div class='meta'>
                <p class='description'> Status: $row[status]</p>
              </div>
              <br>
              <div class='description'> Location: $row[loc]</div>
              <br>
              <div class='description'> created by: $row[taskeeemail]</div>
              <br>
              <div class='meta'>
               <span class='date'>Created in $row[createddatetime]</span>
              </div>
            </div>
          </div>

          <div id='taskDetailModal' class='ui modal'>
            <i class = 'close icon'></i>
            <div class='center header'>
              $row[ttype]
            </div>
            <div class='image content'>
              <div class='ui small left floated image'> 
                <img src='/demo/steve.jpg'>
              </div>
              <div>
                $row[task_details]
              </div>
            </div>
            <div class='actions'>
              <button class='ui primary blue button' onclick=\"editTask('$row[task_id]');\">
              Edit
              </button>
              <button class='ui primary blue button' onclick=\"viewBid('$row[task_id]');\">
              View bidders
              </button>
              <div class='ui approve red icon button' type='button' id='deleteTask' value='$row[task_id]'> 
                Delete Task 
              </div>
            </div>
          </div>
";
    }
    pg_close($db);
  }
?>

<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>View Tasks - Semantic</title>
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/reset.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/site.css">

  <link rel="stylesheet" type="text/css" href="semantic/dist/components/container.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/grid.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/header.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/image.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/menu.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/card.css">

  <link rel="stylesheet" type="text/css" href="semantic/dist/components/divider.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/dropdown.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/segment.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/button.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/list.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/icon.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/sidebar.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/transition.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/modal.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/dimmer.css">

  <script src="assets/jquery-3.3.1.min"></script>
  <script src="semantic/dist/components/transition.js"></script>
  <script src="semantic/dist/components/dropdown.js"></script>
  <script src="semantic/dist/components/modal.js"></script>
  <script src="semantic/dist/components/dimmer.js"></script>

  <script>

    var taskID = "";


    function editTask(taskId) {
      taskID = taskId;
        $.ajax({
          url: '/demo/storetask.php',
          type: "POST",
          data: { taskid: taskId },
          success: function(data){
            alert("yay");
            var obj = JSON.parse(data);
            console.log(obj);
            console.log(obj.abc);
          }
        });
    }
    
    function viewBid(taskId) {
      taskID = taskId;
        $.ajax({
          url: '/demo/storetask.php',
          type: "POST",
          data: { taskid: taskId },
          success: function(data){
            alert("yay");
            var obj = JSON.parse(data);
            console.log(obj);
            console.log(obj.abc);
          }
        });
    }

    // performs sign out functionality.
    $(document).ready(function() {
      $('#signOut').click(function() {
        $.ajax({
          url: '/demo/viewtasks.php?argument=signOut',
          success: function(html){
            window.location.replace("/demo/index.php");
          }
        });
      });
    })

  $(document).ready(function() {
    $('#showTaskDetails').click(function(){
      $('#taskDetailModal').modal({
        onApprove: function() {
        }
      }).modal('show');
    });
  })

  </script>

  <style type="text/css">

    .my_container {
      margin: 50px;
    }

    .masthead.segment {
      min-height: 200px;
      padding: 1em 0em;
    }
    .masthead .logo.item img {
      margin-right: 1em;
    }
    .masthead .ui.menu .ui.button {
      margin-left: 0.5em;
    }
    .masthead h1.ui.header {
      margin-top: 3em;
      margin-bottom: 0em;
      font-size: 4em;
      font-weight: normal;
    }
    .masthead h2 {
      font-size: 1.7em;
      font-weight: normal;
    }

    .ui.vertical.stripe {
      padding: 8em 0em;
    }
    .ui.vertical.stripe h3 {
      font-size: 2em;
    }
    .ui.vertical.stripe .button + h3,
    .ui.vertical.stripe p + h3 {
      margin-top: 3em;
    }
    .ui.vertical.stripe .floated.image {
      clear: both;
    }
    .ui.vertical.stripe p {
      font-size: 1.33em;
    }
    .ui.vertical.stripe .horizontal.divider {
      margin: 3em 0em;
    }

    .quote.stripe.segment {
      padding: 0em;
    }
    .quote.stripe.segment .grid .column {
      padding-top: 5em;
      padding-bottom: 5em;
    }

    .footer.segment {
      padding: 5em 0em;
    }

    .secondary.pointing.menu .toc.item {
      display: none;
    }

    @media only screen and (max-width: 700px) {
      .ui.fixed.menu {
        display: none !important;
      }
      .secondary.pointing.menu .item,
      .secondary.pointing.menu .menu {
        display: none;
      }
      .secondary.pointing.menu .toc.item {
        display: block;
      }
      .masthead.segment {
        min-height: 350px;
      }
      .masthead h1.ui.header {
        font-size: 2em;
        margin-top: 1.5em;
      }
      .masthead h2 {
        margin-top: 0.5em;
        font-size: 1.5em;
      }
    }

  </style>
</head>



<body>

  <!-- Top menu -->
  <div class="pusher">
  <div class="ui inverted vertical masthead center aligned segment">

    <div class="ui container">
      <div class="ui large secondary inverted pointing menu">
        <a class="toc item">
          <i class="sidebar icon"></i>
        </a>
        <a class="item" href="/demo/index.php">Home</a>
          <a class ="item" href="/demo/viewcreatedtasks.php"> View Created Tasks</a>
          <a class ="item" href="/demo/viewrunningtasks.php"> View tasks I am running</a>
        <div class="right item">
          <?php showUser(); ?> 
        </div>
      </div>
    </div>
  </div>

<div class="my_container">
  <div class='ui link two cards' id='showTaskDetails'>
    <?php showBidders(); ?> 
  </div>
</div>



  <!-- Footer -->
  <div class="ui inverted vertical footer segment">
    <div class="ui container">
      <div class="ui stackable inverted divided equal height stackable grid">
        <div class="three wide column">
          <h4 class="ui inverted header">About</h4>
          <div class="ui inverted link list">
            <a href="#" class="item">Sitemap</a>
            <a href="#" class="item">Contact Us</a>
          </div>
        </div>
        <div class="three wide column">
          <h4 class="ui inverted header">Services</h4>
          <div class="ui inverted link list">
            <a href="#" class="item">DNA FAQ</a>
            <a href="#" class="item">How To Access</a>
          </div>
        </div>
        <div class="seven wide column">
          <h4 class="ui inverted header">Footer Header</h4>
          <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
