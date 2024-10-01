<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
         header {
        background: rgb(2,0,36);
        background: linear-gradient(90deg, rgba(2,0,36,1) 5%, rgba(9,9,121,1) 34%, rgba(5,102,183,1) 61%, rgba(3,142,209,1) 88%, rgba(0,212,255,1) 100%);
        color: white;
        height: 100px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 50px;
        box-shadow: 0 4px 8px 0 rgba(202, 202, 202, 0.2);
        
        
        }
        body {
                background-color: #e3f2fd; /* Warna biru langit */
                margin: 0;
                font-family: Arial, sans-serif;
            }
        

        .login-container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 40px;
            padding-right: 60px;
            width: 300px;
            
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .form-group button {
            width: 107.2%;
            padding: 10px 0;
            background: #007eff;
            border: none;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            border-radius: 3px;
        }
        .form-group button:hover {
            width: 107.2%;
            padding: 10px 0;
            background: #004b99;
            border: none;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            border-radius: 3px;
        }

        .content {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #007eff;
            color: white;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000; /* Ensure it's above other content */
            display: flex;
            justify-content:space-between;
        }

        .logo {
            float: left;
            
        }

        img{
            width: 30px;
            height: 30px;
        }

        .menu {
            float: right;
            margin-right: 5%;
            color: #ffffff;
            padding-top: 10px;
        }

        .menu a {
            text-decoration: none;
            color: white;
            padding-top: 40px;
            padding-bottom: 31px;
            padding-left: 25px;
            padding-right: 25px;
            margin: 0;
            /*transition: background-color 0.3s ease;*/
        }

        .menu a:hover {
            color: #ffffff;
            background-color: #0074EB;
            transition: background-color 0.3s ease;
            
        }

        #login{
            padding: 15px 30px;
            background-color: #007EFF;
            color: white;
            border-radius: 8px;
            border-style: solid;
            border-color: #ffffff;
            border-width: 3px;
            margin-left: 25px;
        }
        #login:hover{
            background-color: #0062C6;
            padding: 15px 30px;
            color: white;
            border-color: #ffffff;
        }
   
    </style>
</head>
<body>
    <div class="header">
            <div class="logo">
                <!-- Your logo image or text -->
                <a href="index.php">
                    <img src="assets/logo.png" alt="Logo">
                </a>
                
            </div>
            <div class="menu">
                <!-- Menu links -->
                <a href="cek_penyakit.php">Cek Penyakit</a>
                <a href="login.php" id="login">Login</a>
            </div>
    </div>
    <div class="content">
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="proses_login.php">
            <div class="form-group">
                <label for="user">Username:</label>
                <input type="text" id="user" name="user" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" id="pass" name="pass" placeholder="Masukkan password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
                
            </div>
        </form>
</div>
</div>
</body>
</html>
