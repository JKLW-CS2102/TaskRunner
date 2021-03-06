
<!DOCTYPE html>

<!-- PHP Portions -->
<?php
  require('debugging.php');
  require('session.php');
  require('sanitize.php');

  function isUserUnique(&$emailError) {    
    $email = "";
    
    $email = $_POST['email'];
    $email = getValidEmail($email);
      
    $db = pg_connect("host=127.0.0.1 port=5432 dbname=project1 user=postgres password=1234") or die('Could not connect: ' . pg_last_error()); 
    
    $emailQuery = "SELECT email FROM Taskees WHERE email='$email'";
    $emailResult = pg_query($db, $emailQuery);

    if (pg_num_rows($emailResult) > 0) {
      $emailError = "Sorry... email is already taken";  
    }

    return empty($emailError);
  }

  if (isset($_POST['register'])) {
    $nameError = "";
    $emailError = "";
    if (isUserUnique($emailError)) {
      $email = $_POST['email'];
      $firstName = getValidString($_POST['first-name']);
      $lastName = getValidString($_POST['last-name']);
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);    
      $contact = getValidNumeral($_POST['contact']);
      $creditNum = getValidNumeral($_POST['creditNum']);
      $creditSecurity =getValidNumeral($_POST['creditSecurity']);
      $creditExpiry = date($_POST['expiryYear'] . '-' . $_POST['expiryMonth'] . '-01');
      $zipcode = getValidNumeral($_POST['zipcode']);      

      $db = pg_connect("host=127.0.0.1 port=5432 dbname=project1 user=postgres password=1234") or die('Could not connect: ' . pg_last_error()); 

      $insertQuery = "INSERT INTO Taskees Values('$email', '$firstName', '$lastName', '$password', '$contact', $creditNum, $creditSecurity, '$creditExpiry', $zipcode)";     
      $result = pg_query($db, $insertQuery);

      if ($result) {
        consoleLog($firstName);
        $taskee = 'taskee';
        $res = pg_query($db, "SELECT 1 FROM Taskees WHERE email='$email' and isadmin ='true' ");
        if(pg_num_rows($res) > 0) {
          $isAdmin = 't';
        } else {
          $isAdmin = 'f';
        }   
        $isStaff = pg_query($db, "SELECT isStaff FROM Taskees WHERE email='$email'");
        if($_SESSION['isAdmin'] == 't'){
          header('Location: /demo/admin.php');
        } else {
          login($firstName, $taskee, $email, $isAdmin, $isStaff);
          header('Location: /demo/index.php');
        }
      }     
    }
  }
?>

<!-- HTML Portions -->
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Signup</title>
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/reset.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/site.css">

  <link rel="stylesheet" type="text/css" href="semantic/dist/components/container.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/grid.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/header.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/image.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/menu.css">

  <link rel="stylesheet" type="text/css" href="semantic/dist/components/divider.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/segment.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/form.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/input.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/checkbox.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/button.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/list.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/message.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/icon.css">
  <link rel="stylesheet" type="text/css" href="semantic/dist/components/dropdown.css">  

  <script src="assets/jquery-3.3.1.min"></script>
  <script src="semantic/dist/components/form.js"></script>
  <script src="semantic/dist/components/transition.js"></script>
  <script src="semantic/dist/components/dropdown.js"></script>  

  <style type="text/css">
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
  </style>
  
  <script>
  
  $(document).ready(function() {
    $('.ui.form').form({
      fields: {        
        
        email: {
          identifier  : 'email',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your e-mail'
            },
            {
              type   : 'email',
              prompt : 'Please enter a valid e-mail'
            }
          ]
        },

        password: {
          identifier  : 'password',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your password'
            },
            {
              type   : 'length[6]',
              prompt : 'Your password must be at least 6 characters'
            }
          ]
        },

        // "-", "$" and spaces are not allowed in key names for Javascript.
        first_name: {
          identifier  : 'first-name',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your first name'
            }
          ]
        }, 

        last_name: {
          identifier  : 'last-name',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your last name'
            }
          ]
        },

        zipcode: {
          identifier  : 'zipcode',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your zipcode'
            },
            {
              type   : 'length[6]',
              prompt : 'Your zipcode must be 6 characters'
            }
          ]
        },

        creditNum: {
          identifier  : 'creditNum',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your card number'
            },
            {
              type   : 'length[16]',
              prompt : 'Your card number must be 16 characters'
            }
          ]
        },

        creditSecurity: {
          identifier  : 'creditSecurity',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your CVC'
            },
            {
              type   : 'length[3]',
              prompt : 'Your CVC must be 3 characters'
            }
          ]
        },

        contact: {
          identifier  : 'contact',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your contact number'
            }
          ]
        }, 

        expiryYear: {
          identifier  : 'expiryYear',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your Expiry Year'
            }
          ]
        }, 

        expiryMonth: {
          identifier  : 'expiryMonth',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please select Expiry Month'
            }
          ]
        }, 

        occupation: {
          identifier  : 'occupation',
          rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your occupation'
            },
          ]
        },

        tncs: {
          identifier  : 'tnc',
          rules: [
            {
              type   : 'checked',
              prompt : 'Please accept the Terms and Conditions'
            }
          ]
        }
      
      
      }
    });
  });
  
  </script>
</head>
<body class='ui'>

<div class="ui middle aligned center aligned grid inverted">
  <div class="ui container"></div> <br>
  <div class="six wide column">
    <form class="ui form" action="/demo/taskeesignup.php" method="POST" >
      <h2 class="ui dividing header">Sign Up To Create Tasks!</h2>

      <div class="two field">
        <label>Account Details</label>
        <div class="fields">
          <div class="eight wide field">
            <input type="text" name="email" placeholder="Email" value='<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>'>
              <?php if (!empty($emailError)): ?>
                <span><?php echo $emailError; ?></span>
              <?php endif ?>
          </div>          

          <div class="eight wide field">
            <input type="password" name="password" placeholder="Password" value='<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>'>
          </div>
        </div>
      </div>

      <div class="field">
        <label>Contact Details</label>
        <div class="two fields">
          <div class="field">
            <input type="text" name="first-name" placeholder="First Name" value='<?php echo isset($_POST['first-name']) ? $_POST['first-name'] : ''; ?>'>
          </div>
          <div class="field">
            <input type="text" name="last-name" placeholder="Last Name" value='<?php echo isset($_POST['last-name']) ? $_POST['last-name'] : ''; ?>'>
          </div>
        </div>        
        
        <div class="fields">                       
                    
          <div class="eight wide field">
            <input type="text" name="contact" placeholder="Phone" value='<?php echo isset($_POST['contact']) ? $_POST['contact'] : ''; ?>'>
          </div>        
      
          <div class="eight wide field">
            <input type="text" name="zipcode" maxlength="6" placeholder="Address Zipcode" value='<?php echo isset($_POST['zipcode']) ? $_POST['zipcode'] : ''; ?>'>
          </div>  
        </div>                                        
      </div>      

      <h4 class="ui dividing header">Billing Information</h4>
      <div class="fields">
        <div class="seven wide field">
          <label>Card Number</label>
          <input type="text" name="creditNum" maxlength="16" placeholder="Card Number" value='<?php echo isset($_POST['creditNum']) ? $_POST['creditNum'] : ''; ?>'>
        </div>
        <div class="three wide field">
          <label>CVC</label>
          <input type="text" name="creditSecurity" maxlength="3" placeholder="CVC" value='<?php echo isset($_POST['creditSecurity']) ? $_POST['creditSecurity'] : ''; ?>'>
        </div>
        <div class="six wide field">
          <label>Expiration</label>
          <div class="two fields">
            <div class="field">
              <select class="ui fluid search dropdown" name="expiryMonth" value='<?php echo isset($_POST['expiryMonth']) ? $_POST['expiryMonth'] : ''; ?>'>
                <option value="">Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
            </div>
            <div class="field">
              <input type="text" name="expiryYear" maxlength="4" placeholder="Year" value='<?php echo isset($_POST['expiryYear']) ? $_POST['expiryYear'] : ''; ?>'>
            </div>
          </div>
        </div>
      </div>

      <div class="ui segment">
        <div class="field">
          <div class="ui checkbox">
            <input type="checkbox" name="tnc" tabindex="0">
            <label>I agree to the <a href="#">Terms and Conditions</a></label>
          </div>
        </div>
      </div>
      <input type="submit" name="register" value="Register" class="ui button primary" tabindex="0" />

      <div class="ui error message"></div>
    </form>

  </div>
</div>
</body>

</html>
