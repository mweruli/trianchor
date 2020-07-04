<?php
define('INSTALLFILE', 'contact-form.install.php');
define('CONFIGFILE', 'fcf-assets/contact-form.config.php');
define('FORMFILE', 'contact-form.htm');
define('ABSPATH', dirname(__FILE__) . '/');

error_reporting(E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);

if (!isset($_POST['LicenseKey'])) {
    echo '<!DOCTYPE html>
    <head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>contact form installer</title>
    <link href="fcf-assets/css/contact-form.css" rel="stylesheet">
    </head>
    <body>';
}

if (file_exists(ABSPATH . CONFIGFILE)) {
    installAlreadyCompleted();
}

$fields = array(
    "LicenseKey",
    "EmailTo",
    "EmailToName",
    "EmailFrom",
    "EmailFromName",
    "EmailSubject",
    "UseSMTP",
    "SMTPHost",
    "SMTPUser",
    "SMTPPass",
    "SMTPPort",
    "SMTPSecure"
);

$config_template = "<?php
// ************************************
// This file is part of a package from:
// www.freecontactform.com
// See license for details
// ************************************


// ***********
// LICENSE KEY
// ***********
define('KEY', '{LicenseKey}');


// *********************
// FORM FIELD VALIDATION
// *********************
" . '$validate' . " = array(
    'Name' => 'NOT_EMPTY,2,60',
    'Email' => 'EMAIL',
    'Message' => 'NOT_EMPTY,15,3000'
);


// ******************
// FORM FIELD MAPPING
// ******************
" . '$mapping' . " = array(
    'Name' => 'Your name',
    'Email' => 'Your email address',
    'Message' => 'Your message'
);


// **************************
// EMAIL TEMPLATES - INCOMING
// **************************
define('EMAIL_TEMPLATE_IN_HTML', 'contact-form.email-in.htm');
define('EMAIL_TEMPLATE_IN_TEXT', 'contact-form.email-in.txt');


// *************
// EMAIL MESSAGE
// *************
define('EMAIL_TO', '{EmailTo}');
define('EMAIL_TO_NAME', '{EmailToName}');

define('EMAIL_TO_CC', '');
define('EMAIL_TO_CC_NAME', '');

define('EMAIL_TO_BCC', '');
define('EMAIL_TO_BCC_NAME', '');

define('EMAIL_FROM', '{EmailFrom}');
define('EMAIL_FROM_NAME', '{EmailFromName}');

define('EMAIL_REPLY_TO', 'FIELD:Email');
define('EMAIL_REPLY_TO_NAME', 'FIELD:Name');

define('EMAIL_SUBJECT_BEFORE', '');
define('EMAIL_SUBJECT', '{EmailSubject}');
define('EMAIL_SUBJECT_AFTER', '');


// ***************
// EMAIL TRANSPORT
// ***************
define('USE_SMTP', '{UseSMTP}'); // YES or NO
define('SMTP_HOST', '{SMTPHost}');
define('SMTP_USER', '{SMTPUser}');
define('SMTP_PASS', '{SMTPPass}');
define('SMTP_SECURE', '{SMTPSecure}'); // STARTTLS or SMTPS (port 465)
define('SMTP_PORT', '{SMTPPort}');
define('SMTP_DEBUG', 'NO'); // YES or NO



// **************************
//    DON'T CHANGE BELOW
// USED FOR VALIDATION CHECKS
// **************************
define('A', 'Rm9ybSBwcm92aWRlZCBieSB3d3cuZnJlZWNvbnRhY3Rmb3JtLmNvbQ==');
define('B', 'Rm9ybSBwcm92aWRlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5mcmVlY29udGFjdGZvcm0uY29tIj5GcmVlQ29udGFjdEZvcm0uY29tPC9hPg==');
define('C', 'Rm9ybSBwcm92aWRlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5mcmVlY29udGFjdGZvcm0uY29tIiB0YXJnZXQ9Il9ibGFuayI+RnJlZUNvbnRhY3RGb3JtLmNvbTwvYT4=');
define('D', 'Y29uZ3JhdHVsYXRpb25zIGZvciBiZWluZyBjbGV2ZXIh');
define('E', 'OGZlR3dSYkh3MjhGbg==');
define('F', 'RlJFRQ==');";


$form_template = '<!--
************************************
This file is part of a package from:
www.freecontactform.com
See license for details
************************************
-->
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>contact form</title>
</head>

<body>

<link href="fcf-assets/css/contact-form.css" rel="stylesheet">

<div class="fcf-body">

<div id="fcf-form">
<h3 class="fcf-h3">Contact us</h3>

<form id="fcf-form-id" class="fcf-form-class" method="post" action="fcf-assets/contact-form.process.php">
    
    <div class="fcf-form-group">
        <label for="Name" class="fcf-label">Your name</label>
        <div class="fcf-input-group">
            <input type="text" id="Name" name="Name" class="fcf-form-control" data-validate-field="Name">
        </div>
    </div>

    <div class="fcf-form-group">
        <label for="Email" class="fcf-label">Your email address</label>
        <div class="fcf-input-group">
            <input type="email" id="Email" name="Email" class="fcf-form-control" data-validate-field="Email">
        </div>
    </div>

    <div class="fcf-form-group">
        <label for="Message" class="fcf-label">Your message</label>
        <div class="fcf-input-group">
            <textarea id="Message" name="Message" class="fcf-form-control" rows="6" data-validate-field="Message" maxlength="3000"></textarea>
        </div>
    </div>

    <div id="fcf-status" class="fcf-status"></div>

    <div class="fcf-form-group">
        <button type="submit" id="fcf-button" class="fcf-btn fcf-btn-primary fcf-btn-lg fcf-btn-block">Send Message</button>
    </div>

    <div class="fcf-credit" id="fcf-credit">
        <!-- do not remove below unless you have an valid unbranded license -->
        <a href="https://www.freecontactform.com" target="_blank">FreeContactForm</a>
    </div>

</form>
</div>


<div id="fcf-thank-you">

    <!-- Thank you message goes below -->
    <h3 class="fcf-h3">Thank you for getting in touch</h3>
    <p>We appreciate you contacting us. We will get back in touch with you soon.</p>
    <!-- Thank you message goes above -->

</div>


</div>

<script src="fcf-assets/js/fcf-just-validate.js"></script>
<script src="fcf-assets/js/contact-form.js"></script>

</body>
</html>';



$error_strings = array();

if (isset($_POST['LicenseKey'])) {
    installForm($config_template, $form_template, $fields);
    exit();
}


function installForm($config_template, $form_template, $fields) {

    global $error_strings;

    if ($_POST['UseSMTP'] == "false") {
        $_POST['UseSMTP'] = "NO";
        $_POST['SMTPHost'] = "";
        $_POST['SMTPUser'] = "";
        $_POST['SMTPPass'] = "";
        $_POST['SMTPPort'] = "";
    } else {
        $_POST['UseSMTP'] = "YES";
        if ($_POST['SMTPPort'] == 465) {
            $_POST['SMTPSecure'] = "SMTPS";
        } else {
            $_POST['SMTPSecure'] = "STARTTLS";
        }
    }

    // Create Config
    setDefaults($fields);
    $search = getSearch($fields);
    $replace = getReplace($fields);
    createFile($search, $replace, $config_template, ABSPATH . CONFIGFILE);

    // Create Form
    createFile("", "", $form_template, ABSPATH . FORMFILE);

    if (count($error_strings) > 0) {
        echo "Fail:<br><ul>";
        foreach ($error_strings as $es) {
            echo "<li>$es</li>";
        }
        echo "</ul>";
        exit();
    } else {
        installCompleted();
    }
}


function createFile($search, $replace, $template, $filename) {
    global $error_strings;
    if($search == "") {
        $file_contents = $template;
    } else {
        $file_contents = str_replace($search, $replace, $template);
    }
    
    if (!$handler = fopen($filename, "wb")) {
        $error = true;
    } else {
        if (!fwrite($handler, trim($file_contents))) {
            $error = true;
        }
        fclose($handler);
    }
    if ($error) {
        $viewable_code = nl2br(str_replace("<", "&lt;", $file_contents));
        $error_strings[] = "Cannot write your file to: $filename - Please change the directory permissions to allow write access.<br /><br /> 
      If you prefer, you can create the file using the code below:<br /><br />" . $viewable_code . "<br /><br />Save the above code to a new file at: $filename";
    }
}


function setDefaults($fields) {
    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            $_POST[$field] = "";
        }
    }
}

function getSearch($fields) {
    $search = array();
    foreach ($fields as $field) {
        $search[] = '{' . $field . '}';
    }
    return $search;
}

function getReplace($fields) {
    $replace = array();
    foreach ($fields as $field) {
        $replace[] = $_POST[$field];
    }
    return $replace;
}

function installCompleted() {
    echo "Success";
    exit();
}

function installAlreadyCompleted() {
    echo '<div style="text-align: center;">
            <p>&nbsp;</p>
            <h3 class="fcf-h3">Your form has already been installed</h3>
            <p>&nbsp;</p>
            <p>To install again, delete your forms configuration file (fcf-assets/contact-form.config.php) then run again.</p>
            <p>&nbsp;</p>
            <p><a href="contact-form.htm" class="fcf-btn fcf-btn-primary fcf-btn-lg">View your form</a></p>
            <p>&nbsp;</p>
        </div>
        </body>
        </html>';
    exit();
}
?>


<style>
    #UseSMTPSettings {
        display: none;
    }
</style>


<div class="fcf-body" style="min-width:730px;width:730px">

    <div id="fcf-form">
        <h3 class="fcf-h3">Contact form installation</h3>

        <form id="fcf-form-id" class="fcf-form-class" method="post" action="contact-form.install.php">





            <!-- <div class="fcf-body"> -->

                <!-- LICENSE KEY -->
                <div class="fcf-form-group">
                    <label for="LicenseKey" class="fcf-label">License Key</label>
                    <div class="fcf-input-group">
                        <input type="text" id="LicenseKey" name="LicenseKey" class="fcf-form-control" data-validate-field="LicenseKey" value="FREE">
                    </div>
                </div>


                <h4>Email message:</h4>

                <div class="fcf-form-group">
                    <label for="EmailTo" class="fcf-label">To email address</label>
                    <div class="fcf-input-group">
                        <input type="text" id="EmailTo" name="EmailTo" class="fcf-form-control" data-validate-field="EmailTo" value="">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="EmailToName" class="fcf-label">To email name (optional)</label>
                    <div class="fcf-input-group">
                        <input type="text" id="EmailToName" name="EmailToName" class="fcf-form-control" data-validate-field="EmailToName" value="">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="EmailFrom" class="fcf-label">Email from</label>
                    <div class="fcf-input-group">
                        <input type="text" id="EmailFrom" name="EmailFrom" class="fcf-form-control" data-validate-field="EmailFrom" value="FIELD:Email">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="EmailFromName" class="fcf-label">Email from name (optional)</label>
                    <div class="fcf-input-group">
                        <input type="text" id="EmailFromName" name="EmailFromName" class="fcf-form-control" data-validate-field="EmailFromName" value="FIELD:Name">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="EmailSubject" class="fcf-label">Email subject</label>
                    <div class="fcf-input-group">
                        <input type="text" id="EmailSubject" name="EmailSubject" class="fcf-form-control" data-validate-field="EmailSubject" value="New contact form message">
                    </div>
                </div>

            <!-- </div> -->


            <!-- USE SMTP -->
            <div class="fcf-checkbox">
                <label>
                    <input name="UseSMTP" type="checkbox" data-validate-field="UseSMTP"><i class="helper"></i>
                    Use SMTP for email?
                </label>
            </div>


            <div class="fcf-body" id="UseSMTPSettings">
                <h4>Email transport:</h4>

                <div class="fcf-form-group">
                    <label for="SMTPHost" class="fcf-label">Host</label>
                    <div class="fcf-input-group">
                        <input type="text" id="SMTPHost" name="SMTPHost" class="fcf-form-control" data-validate-field="SMTPHost" value="">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="SMTPUser" class="fcf-label">Username</label>
                    <div class="fcf-input-group">
                        <input type="text" id="SMTPUser" name="SMTPUser" class="fcf-form-control" data-validate-field="SMTPUser" value="">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="SMTPPass" class="fcf-label">Password</label>
                    <div class="fcf-input-group">
                        <input type="text" id="SMTPPass" name="SMTPPass" class="fcf-form-control" data-validate-field="SMTPPass" value="">
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="SMTPPort" class="fcf-label">Port</label>
                    <div class="fcf-input-group">
                        <input type="number" id="SMTPPort" name="SMTPPort" class="fcf-form-control" data-validate-field="SMTPPort" value="">
                    </div>
                </div>

            </div><!-- /use smtp -->


            <div id="fcf-status" class="fcf-status"></div>

            <div class="fcf-form-group">
                <button type="submit" id="fcf-button" class="fcf-btn fcf-btn-primary fcf-btn-lg fcf-btn-block">Install
                    Form</button>
            </div>

        </form>
    </div>




    <div id="fcf-thank-you" style="text-align: center;">
        <p>&nbsp;</p>
        <h3 class="fcf-h3">Your form has been installed</h3>
        <p>&nbsp;</p>
        <p><a href="contact-form.htm" class="fcf-btn fcf-btn-primary fcf-btn-lg">View your form</a></p>
        <p>&nbsp;</p>
    </div>




</div>

<script src="fcf-assets/js/fcf-just-validate.js"></script>
<script src="fcf-assets/js/contact-form-install.js"></script>

<script>
    var UseSMTP = document.querySelector("input[name=UseSMTP]");
    UseSMTP.addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('UseSMTPSettings').style.display = 'block';
        } else {
            document.getElementById('UseSMTPSettings').style.display = 'none';
        }
    });
</script>
</body>

</html>