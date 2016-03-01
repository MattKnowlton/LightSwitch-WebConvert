<?php
require_once('util/startup.php');
$_SESSION['UID'] = false;


if(isset($_POST['action'])){
    //check $_POST['UserName'] && $_POST['Password'];
    $_SESSION['UID'] = -1;
    header('Location: index.php');
}

?>
<html>
<head>
    <?= INCLUDE_DEFAULT_JS; ?>
    <script>
        $(document).ready(function(){

        });
    </script>

    <?= INCLUDE_DEFAULT_CSS; ?>
    <style>
        br {
            clear:both;
        }
        input {
            width: 100%;
        }
    </style>
</head>
<body>
<div>

<div style="width:300px; margin: 0px auto;">
    <table style="height:100%;">
        <tr>
            <td>
                <form method="post" >
                    <input type="hidden" name="action" value="1" />
                    <table>
                        <tr>
                            <td colspan="2">
                                <img src="images/logoText.png" style="width:315px; margin-left: -27px; margin-right: -45px;">
                                <br/><br/>
                            </td>
                        </tr>
                        <tr>
                            <td>User Name &nbsp;</td>
                            <td><input type="text" name="UserName" /></td>
                        </tr>
                        <tr>
                            <td>Password </td>
                            <td><input type="password" name="Password" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button style="float:right;">Log In</button></td>
                        </tr>
                    </table>
                </form>
                <br/><br/><br/><br/>
                <br/><br/><br/><br/>
            </td>
        </tr>
    </table>
</div>

</div>
</body>
</html>
