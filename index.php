<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php Sprint File Manager</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>

 <?php
if (isset($_GET['action']) and $_GET['action'] == 'logout') {
    session_destroy();
    session_start();

    }
$msg = '';
if(isset($_POST['login']) and !empty($_POST['username']) and !empty($_POST['password'])) {
    if($_POST['username'] == 'root' and $_POST['password'] == '1234') {
        $_SESSION['logged_in'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $_POST['username'];
        $msg = 'Log in succesfully';
    } else {
        $msg = 'Wrong Login details';
    }
}

if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
    echo '';
} else {
    echo '<div class = container_log>
    <div class = cont_log>
    <div class = head_h1>
    <h1>File system browser</h1>
    <form class= form_log action="./index.php" method="post">
    <input class="inp" type="text" name="username" placeholder="Username = root">
    <input class="inp" type="password" name="password" placeholder="Password = 1234"></br>
    <h2 class = err_ex_log>'. $msg .'<h2>
    <button class="btn_inp" type="submit" name="login" >Log in</button>
    </form></div></div></div>';
}
if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true){
    $path = isset($_GET["path"]) ? './' . $_GET["path"] : './';
    $explore_files = scandir($path);
    echo '<div class=create_cont>
    <div class = create_form>
    <form class = create method="post" action=""> 
    <h2> Create a new file <h2>
    <input class = create_input_style type="text" name="createfile" placeholder="Enter file name" value="">
    <input class=create_submit_style type="submit" name="create" value="Submit">  
    </form>
    <form class = upload_form action="" method="POST" enctype="multipart/form-data">
    <h2> Upload file <h2>
    <input class = upl_style type="file" name="file">
    <button class= button_upl type="submit" name="submit">Upload</button></div></div>';
    echo '<div class=log_out><a href="index.php?action=logout">Log out </a></div>';
    if($path != "./"){
        print('<form action="" method="post">
        <input class = btn_back type="submit" name="back" value=' . str_replace(' ', '&nbsp;', 'Back') . '>
        </form>');
    }
    
       
    print ('<table><th>Type</th><th>Name</th><th>Actions</th>');
    foreach($explore_files as $find_files) {
        if ($find_files != ".." && $find_files != "."){
            print '<tr>';
            print ('<td>' . (is_dir($path . $find_files) ? "Folder" : "File") .' </td>');
            print ('<td>' . (is_dir($path . $find_files) ? '<div class = table_a><a href= "' . (isset($_GET["path"])
                    ?$_SERVER['REQUEST_URI'] . $find_files . '/'
                    :$_SERVER['REQUEST_URI'] . '?path=' . $find_files . '/') . '">' . $find_files . '</a></div>' : $find_files) . '</td>');
                    print ('<td>' . (is_dir($path . $find_files) ? '' : '<form method= "POST">
            <input type = "hidden" name="delete" value = ' . str_replace(' ', '&nbsp;', $find_files) . '>
            <input class = btn_opt type = "submit" name = "deleted" value="Delete">
            <input type = "hidden" name="downloadas" value = ' . str_replace(' ', '&nbsp;', $find_files) . '>
            <input class = btn_opt type = "submit" name = "download" value="Download">
            </form>'
            )
            . "</form></td>");
            print('</tr>');
        };
    };
}
 ?>

</body>
</html>