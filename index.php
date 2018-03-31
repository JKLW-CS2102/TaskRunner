
<!DOCTYPE html>

<?php
  require('debugging.php');
  require('session.php');

  if ($_GET["argument"]=='signOut'){
    logout();
  }
  
  redirectIfNot(null);


  function showUser() {
    if (isLoggedIn()) {
      echo '
      <div class="ui dropdown inverted button">Hello, '. $_SESSION['userName'] . '</div>
      <div class="ui dropdown inverted button" id="signOut" formaction="/demo/taskeesignup.php">Sign Out</div>
      ';
      consoleLog($_SESSION['userEmail']);
      consoleLog($_SESSION['userType']);
    } else {
      echo "<a class='ui inverted button' href='/demo/taskeelogin.php'>Log in as Taskee</a>
      <a class='ui inverted button' href='/demo/taskerlogin.php'>Log in as Tasker</a>";
    }
  }
  
?>

<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Homepage - Semantic</title>
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/reset.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/site.css">

  <link rel="stylesheet" type="text/css" href="semantic/dist/components/container.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/grid.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/header.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/image.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/menu.css">

  <link rel="stylesheet" type="text/css" href="semantic/dist/components/divider.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/dropdown.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/segment.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/button.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/list.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/icon.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/sidebar.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/transition.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/label.css">

  <script src="assets/jquery-3.3.1.min"></script>
  <script src="semantic/dist/components/transition.js"></script>
  <script src="semantic/dist/components/dropdown.js"></script>

  <script>
    // performs sign out functionality.
    $(document).ready(function() {
      $('#signOut').click(function() {
        $.ajax({
          url: '/demo/index.php?argument=signOut',
          success: function(html){
            location.reload();
          }
        });
      });
    })
  </script>


  <style type="text/css">

    .hidden.menu {
      display: none;
    }

    .masthead.segment {
      min-height: 700px;
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

<!-- Page Contents -->
<div class="pusher">  
  <div class="ui inverted vertical masthead center aligned segment">
    
    <div class="ui container">
      <div class="ui large secondary inverted pointing menu">
        <a class="toc item">
          <i class="sidebar icon"></i>
        </a>
        <a class="active item">Home</a>        
        <div class="right item">
          <?php showUser(); ?> 
        </div>
      </div>
    </div>

    <div class="ui text container">
      <h1 class="ui inverted header">
        Task Sourcing
      </h1>
      <h2>Do whatever you want when you want to.</h2>
      <a href="/demo/taskersignup.php"><div class="ui huge primary button">Become a Tasker <i class="right arrow icon"></i></div></a>
    </div>

  </div>

  <!-- How to Get Started -->
  <div class="ui vertical stripe segment">
    <div class="ui left aligned stackable fourteen column grid container">
      
    	<div class="two wide column"></div>
      <div class="five wide column">
        <h3 class="ui header" style="color: grey;">How to Get Started</h3>          
	    </div>	      		
			
		  <div class="seven wide column">					        
        <h2>
          <div class="ui big grey circular label">1</div> 
          Become a Tasker
        </h2>				
        <p> Create a Task and Match a Tasker to complete the job for you</p> 			  	
        <div class="row">
          <div class="center aligned column">
            <a class="ui huge button" href='/demo/taskersignup.php'>Sign up to become a Tasker</a> 
          </div>
        </div>      
        
        <br><br>

        <h2>			
  			  <div class="ui big grey circular label aligned left ">2</div> 
  			  Become a Taskee
  			</h2>
  			<p> You'll be able to select from Tasks to bid for and wait to be Matched </p>   			
        <div class="row">
          <div class="center aligned column">
            <a class="ui huge button" href='/demo/taskeesignup.php'>Sign up to become a Taskee</a>
          </div>
      	</div>                    
      </div>

    </div>
  </div>  

  <div class="ui vertical stripe segment">  
    <div class="ui text container">
      <h3 class="ui header">Easily book and manage tasks with Task Sourcing</h3>
      <p>Instead of worrying about the lack of time or inadequate skills to complete a task, why not choose someone qualified enough to do it for you?</p>
      <a class="ui large button" href='/demo/taskeesignup'>Sign up now!</a>
    </div>    
  </div>


  <div class="ui inverted vertical footer segment">
    <div class="ui container">
      <div class="ui stackable inverted divided equal height stackable grid">
        <div class="three wide column">
          <h4 class="ui inverted header">Discover</h4>
          <div class="ui inverted link list">
            <a href='/demo/taskersignup.php' class="item">Become a Tasker</a>
            <a href='/demo/taskeesignup.php' class="item">Sign up to Create Tasks</a>
          </div>
        </div>
        <div class="three wide column">
          
        </div>
        <div class="seven wide column">          
          <h4 class="ui inverted header">Navigate</h4>
          <div class="ui inverted link list">
            <a href='/demo/viewbids.php' class="item">My Bids</a>            
            <a href='/demo/viewcreatedtasks.php' class="item">My Tasks</a>            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>

</html>
