<?php
    // Include libraries
    include("src/Google/autoload.php");
    include("src/Google/Spreadsheet/Autoloader.php");
    
    // OATH Service account data
    $client_email = 'redeemer@connect-2016.iam.gserviceaccount.com';
    $private_key = file_get_contents('assets/connect.p12');
    $scopes = array('https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/drive.readonly', 'https://www.googleapis.com/auth/drive.appfolder', 'https://www.googleapis.com/auth/drive.apps.readonly', 'https://www.googleapis.com/auth/drive.file', 'https://spreadsheets.google.com/feeds', 'https://docs.google.com/feeds');
    
    // Authenticate via OAUTH 2.0
    $credentials = new Google_Auth_AssertionCredentials(
        $client_email,
        $scopes,
        $private_key
    );
    // Init Client
    $client = new Google_Client();
    // Authenticate
    $client->setAssertionCredentials($credentials);
    if ($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion();
    }
    // Get access token
    $accessToken = $client->getAccessToken();
    $accessTokenObj = json_decode($accessToken, true);
    
    // Make request
    $request = new Google\Spreadsheet\Request($accessTokenObj["access_token"]);
    $serviceRequest = new Google\Spreadsheet\DefaultServiceRequest($request);
    Google\Spreadsheet\ServiceRequestFactory::setInstance($serviceRequest);
    
    // Get sheets
    $spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
    $spreadsheetFeed = $spreadsheetService->getSpreadsheets();

    // Get specific file
    $spreadsheet = $spreadsheetFeed->getByTitle('Redeemer Church CG Dashboard');
    // Get specific sheet in file
    $worksheetFeed = $spreadsheet->getWorksheets();
    $worksheet = $worksheetFeed->getByTitle('COMMUNITY GROUPS');
    // Array of data
    $listFeed = $worksheet->getListFeed();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Redeemer Connect</title>
        <style>
            body {
                text-align: center;
            }
            .logo {
                width: 100px;
                height: 100px;
                background-image: url(img/logo.jpg);
                margin: 0 auto;
                position: relative;
                background-size: cover;
            }
            ul {
                list-style-type: none;
                padding: 0;
                font-family: sans-serif;
            }
            li {
                padding: 0;
                margin-top: 5px;
            }
            a {
                color: black;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="logo"></div>
        <ul class="list">
        <?php
            // LOOPING THROUGH THE ROWS
            $int = 0;
            foreach ($listFeed->getEntries() as $entry) {
                $values = $entry->getValues();
                echo "<li>";
                echo "<a href='print.php?id=".$int."'>";
                echo $values["printgroupname"];
                echo "</a>";
                echo "</li>";
                $int++;
            }
        ?>
        </ul>
        
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/scripts.js"></script>
    </body>
</html>