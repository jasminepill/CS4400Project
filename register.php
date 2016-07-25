<?php
   include("config.php");
   session_start();

   $error = "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
   		$count = 0;
   		$mang_pass_sql = "SELECT * FROM SYSTEM_INFO";
   		// $mang_pass_result = mysqli_query($db, '$mang_pass_sql');
   		// $mang_pass = $mang_pass_result[2];
      $mang_pass_result = mysqli_query($db, $mang_pass_sql);
      $row = mysqli_fetch_assoc($mang_pass_result);
      $mang_pass = $row["Manager_password"];

      
      if ($_POST['password'] == "" || $_POST['conf_password'] == "" || $_POST['email'] == "" || $_POST['username'] == "") {
      		$error = "Please provide input to all fields";
      } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          $error = "Please provide a valid email address";
      } else if ($_POST['mymang_password'] != "" && $_POST['mymang_password'] != $mang_pass) {
      		$error = "Manager password is incorrect";
      } else if ($_POST['password'] != $_POST['conf_password']) {
      		$error = "Password and Confirm Password did not match";
      } else if ($_POST['mymang_password'] != "" && $_POST['mymang_password'] == $mang_pass) {
            $new_username = $_POST['username'];
            $new_email = $_POST['email'];
            $new_password = $_POST['password'];
            $new_user_qu = "SELECT * FROM MANAGER WHERE Username ='$new_username' or Email ='$new_email' ";
            $new_user_result = mysqli_query($db, $new_user_qu);
            $numb_rows = mysqli_num_rows($new_user_result);
            if ($numb_rows == 0) {
               $sql = "INSERT INTO MANAGER (Email, Username, Password) VALUES ('$new_email', '$new_username', '$new_password')";
               $result = mysqli_query($db, $sql);
               $error = "";
               header("location: login.php");
            } else {
               $error = "Username and Password already exists";
            }
      } else {
  
      		$new_username = $_POST['username'];
      		$new_email = $_POST['email'];
      		$new_password = $_POST['password'];
      		$new_user_qu = "SELECT * FROM CUSTOMER WHERE Username ='$new_username' or Email ='$new_email' ";
      		$new_user_result = mysqli_query($db, $new_user_qu);
      		$numb_rows = mysqli_num_rows($new_user_result);
      		if ($numb_rows == 0) {
      			$sql = "INSERT INTO CUSTOMER (Email, Username, Password) VALUES ('$new_email', '$new_username', '$new_password')";
				   $result = mysqli_query($db, $sql);
               $error = "";
					header("location: login.php");
				} else {
      			$error = "Username and Password already exists";
      		}
         

      }		

   }
?>
<html>
   
   <head>
      <title>Registeration Page</title>
      
      <style type = "text/css">
         h1 {
            font-style: italic;
            font-size: 30px;
            text-align: center;
            margin-top: 80px;
         }

         hr {
          width: 70%;
         }
         
         input[type=text], input[type=password]{
             width: 100%;
             padding: 10px 10px;
             margin-bottom: 8px;
             box-sizing: border-box;
             border: 1px solid #ccc;
             -webkit-transition: 0.5s;
             transition: 0.5s;
             outline: none;
             border-radius: 2px;
             font-family: Georgia;
             font-size: 15px;
         }

         input[type=text]:focus, input[type=password]:focus {
             border: 1px solid black;
         }

         input[type=submit] {
            width: 100%;
            font-size: 15px;
            background-color: black;
            color: white;
            padding: 10px;
            border: none;
            font-family: Georgia;
            cursor: hand;
         }

         .backbutton {
            margin-top: 0px;
            border-collapse: separate;
        
            height: 50px;
            border: none;
            border-spacing: 20px;
          }

          table {
            margin-top: 10px;
            border-collapse: separate;
            width: 100%;
            border: none;
            border-spacing: 10px;
          }

          th, td {
          border: 1px solid black;
          }

          td {
          /*  height: 40px;*/
            text-align: center;
            width: 100%;
            font-family: Georgia;
            font-size: 15px;
          }

          a {
            display: block;
            width: 100%;
            padding: 8px 0px;
          }
          
          td:hover {
            background-color:#f5f5f5
          }

          a:link {
            color: black;
            text-decoration: none;
          }

          a:visited {
            color: black;
            text-decoration: none;
          }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
     
     <h1> Sign Up </h1>
      <div align = "center">
         <div style = "width:300px; border: none; margin-top:30px" align = "left">
            
				
            <div style = "margin:20px">
               
               <form action = "" method = "post">
                  <input type = "text" name = "username" placeholder="Username" autofocus/>
                  <input type = "text" name = "email" placeholder="Email Address"/>
                  <input type = "password" name = "password" placeholder="Password" />
                  <input type = "password" name = "conf_password" placeholder="Confirm Password" />
                  <input type = "password" name = "mymang_password" placeholder="Manager Password (optional)" />
                  <input type = "submit" value = " Create"/>
               </form>
               <table align="center" class="backbutton">
                  <tr>
                    <td>
                      <a href="login.php"> Cancel </a>
                    </td>
                  </tr>
                </table>


               <div style = "font-size:11px; color:#cc0000; margin-top:10px"> <?php echo "$error" ?> </div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>