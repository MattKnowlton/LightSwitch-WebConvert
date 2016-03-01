<?php
require_once('ajax.class.php');

$accountsRegistered = array(
    'test@example.com',
    'example@test.com',
);

$ajaxCon->addModule('CheckEmail', function($params) use ($accountsRegistered){
    $email = strtolower($params['Email']);
    if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) return array('valid' => false);
    if(in_array($email, $accountsRegistered)) return array('valid' => true, 'hasAccount' => true);
    return array('valid' => true, 'hasAccount' => false);
});

?>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="ajax.class.js"></script>
    <script>
        $(document).ready(function(){

            $('button').click(function(){
                Email = $('#Email').val();

                ajaxCon.call('CheckEmail', {'Email':Email}, function(r){
                    if(r.return.valid == false) return $('#EmailStatus').text('Input was not a valid email.');
                    if(r.return.hasAccount == true) return $('#EmailStatus').text('This email is already registered.');
                    return $('#EmailStatus').text('Success! The email address is not in our system.');
                });
            });
        });
    </script>
</head>
<body>
    <p>Email Address Checker Example</p>
    <input id="Email"/><button>Check</button>
    <div id="EmailStatus"></div>
    <br/>
    <i>Note: test@example.com and example@test.com are already "registered" in the system</i>
</body>
</html>