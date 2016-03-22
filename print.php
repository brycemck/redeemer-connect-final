<?php    
    include("src/Google/autoload.php");
    include("src/Google/Spreadsheet/Autoloader.php");
    
    $client_email = 'redeemer@connect-2016.iam.gserviceaccount.com';
    $private_key = file_get_contents('assets/connect.p12');
    $scopes = array('https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/drive.readonly', 'https://www.googleapis.com/auth/drive.appfolder', 'https://www.googleapis.com/auth/drive.apps.readonly', 'https://www.googleapis.com/auth/drive.file', 'https://spreadsheets.google.com/feeds', 'https://docs.google.com/feeds');
    
    $user_to_impersonate = 'connect@redeemerpdx.com';
    $credentials = new Google_Auth_AssertionCredentials(
        $client_email,
        $scopes,
        $private_key
    );
    
    $client = new Google_Client();
    $client->setAssertionCredentials($credentials);
    if ($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion();
    }
    $accessToken = $client->getAccessToken();
    
    $accessTokenObj = json_decode($accessToken, true);
    
    $request = new Google\Spreadsheet\Request($accessTokenObj["access_token"]);
    $serviceRequest = new Google\Spreadsheet\DefaultServiceRequest($request);
    Google\Spreadsheet\ServiceRequestFactory::setInstance($serviceRequest);
    
    $spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
    $spreadsheetFeed = $spreadsheetService->getSpreadsheets();
    $spreadsheet = $spreadsheetFeed->getByTitle('Redeemer Church CG Dashboard');
    $worksheetFeed = $spreadsheet->getWorksheets();
    $worksheet = $worksheetFeed->getByTitle('COMMUNITY GROUPS');
    $listFeed = $worksheet->getListFeed();
    
    $thisCG = $listFeed->getEntries()[$_GET['id']]->getValues();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Redeemer Connect | Print</title>
        <link rel="stylesheet" href="assets/css/style.css" />
    </head>
    <body>
        <div class="cards">
			<div class="card">
                <div class="left">
                    <h4 class="left-title"><?php echo explode("|", $thisCG['printgroupname'])[0]; ?></h4>
                    <div class="content">
                        <h4 class="content-title">MEET TIME</h4>
                        <span><?php echo $thisCG['day']; ?>'s at <?php echo $thisCG['time']; ?></span>
						<h4 class="content-title">ADDRESS</h4>
                        <span><?php echo $thisCG['hosthomestreetaddress'] . "<br>" . $thisCG['hosthomecity'] . ", " . $thisCG['hosthomestate'] . " " . $thisCG['hosthomezipcode']; ?></span>
						<h4 class="content-title">LEADER PHONE #</h4>
                        <span><?php echo $thisCG['cgleaderphonenumber']; ?></span>
						<h4 class="content-title">LEADER EMAIL</h4>
                        <span><?php echo $thisCG['cgleaderemail']; ?></span>
                    </div>
                </div>
                <div class="logo"></div>
                <div class="right">
                    <h4 class="right-title"><?php echo explode("|", $thisCG['printgroupname'])[1]; ?></h4>
                    <div class="map-container">
                        <img class="map" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo urlencode($thisCG['hosthomestreetaddress'].", ".$thisCG['hosthomecity'].", ".$thisCG['hosthomestate']." ".$thisCG['hosthomezipcode']); ?>&zoom=15&size=230x333&maptype=roadmap&markers=color:red%7Clabel:%20%7C<?php echo urlencode($thisCG['hosthomestreetaddress'].", ".$thisCG['hosthomecity'].", ".$thisCG['hosthomestate']." ".$thisCG['hosthomezipcode']); ?>" />
                    </div>
                </div>
			</div>
            <div class="card">
                <div class="left">
                    <h4 class="left-title"><?php echo explode("|", $thisCG['printgroupname'])[0]; ?></h4>
                    <div class="content">
                        <h4 class="content-title">MEET TIME</h4>
                        <span><?php echo $thisCG['day']; ?>'s at <?php echo $thisCG['time']; ?></span>
						<h4 class="content-title">ADDRESS</h4>
                        <span><?php echo $thisCG['hosthomestreetaddress'] . "<br>" . $thisCG['hosthomecity'] . ", " . $thisCG['hosthomestate'] . " " . $thisCG['hosthomezipcode']; ?></span>
						<h4 class="content-title">LEADER PHONE #</h4>
                        <span><?php echo $thisCG['cgleaderphonenumber']; ?></span>
						<h4 class="content-title">LEADER EMAIL</h4>
                        <span><?php echo $thisCG['cgleaderemail']; ?></span>
                    </div>
                </div>
                <div class="logo"></div>
                <div class="right">
                    <h4 class="right-title"><?php echo explode("|", $thisCG['printgroupname'])[1]; ?></h4>
                    <div class="map-container">
                        <img class="map" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo urlencode($thisCG['hosthomestreetaddress'].", ".$thisCG['hosthomecity'].", ".$thisCG['hosthomestate']." ".$thisCG['hosthomezipcode']); ?>&zoom=15&size=230x333&maptype=roadmap&markers=color:red%7Clabel:%20%7C<?php echo urlencode($thisCG['hosthomestreetaddress'].", ".$thisCG['hosthomecity'].", ".$thisCG['hosthomestate']." ".$thisCG['hosthomezipcode']); ?>" />
                    </div>
                </div>
			</div>
            <div class="card">
                <div class="left">
                    <h4 class="left-title"><?php echo explode("|", $thisCG['printgroupname'])[0]; ?></h4>
                    <div class="content">
                        <h4 class="content-title">MEET TIME</h4>
                        <span><?php echo $thisCG['day']; ?>'s at <?php echo $thisCG['time']; ?></span>
						<h4 class="content-title">ADDRESS</h4>
                        <span><?php echo $thisCG['hosthomestreetaddress'] . "<br>" . $thisCG['hosthomecity'] . ", " . $thisCG['hosthomestate'] . " " . $thisCG['hosthomezipcode']; ?></span>
						<h4 class="content-title">LEADER PHONE #</h4>
                        <span><?php echo $thisCG['cgleaderphonenumber']; ?></span>
						<h4 class="content-title">LEADER EMAIL</h4>
                        <span><?php echo $thisCG['cgleaderemail']; ?></span>
                    </div>
                </div>
                <div class="logo"></div>
                <div class="right">
                    <h4 class="right-title"><?php echo explode("|", $thisCG['printgroupname'])[1]; ?></h4>
                    <div class="map-container">
                        <img class="map" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo urlencode($thisCG['hosthomestreetaddress'].", ".$thisCG['hosthomecity'].", ".$thisCG['hosthomestate']." ".$thisCG['hosthomezipcode']); ?>&zoom=15&size=230x333&maptype=roadmap&markers=color:red%7Clabel:%20%7C<?php echo urlencode($thisCG['hosthomestreetaddress'].", ".$thisCG['hosthomecity'].", ".$thisCG['hosthomestate']." ".$thisCG['hosthomezipcode']); ?>" />
                    </div>
                </div>
			</div>
            <div class="card">
                <div class="left">
                    <h4 class="left-title"><?php echo explode("|", $thisCG['printgroupname'])[0]; ?></h4>
                    <div class="content">
                        <h4 class="content-title">MEET TIME</h4>
                        <span><?php echo $thisCG['day']; ?>'s at <?php echo $thisCG['time']; ?></span>
						<h4 class="content-title">ADDRESS</h4>
                        <span><?php echo $thisCG['hosthomestreetaddress'] . "<br>" . $thisCG['hosthomecity'] . ", " . $thisCG['hosthomestate'] . " " . $thisCG['hosthomezipcode']; ?></span>
						<h4 class="content-title">LEADER PHONE #</h4>
                        <span><?php echo $thisCG['cgleaderphonenumber']; ?></span>
						<h4 class="content-title">LEADER EMAIL</h4>
                        <span><?php echo $thisCG['cgleaderemail']; ?></span>
                    </div>
                </div>
                <div class="logo"></div>
                <div class="right">
                    <h4 class="right-title"><?php echo explode("|", $thisCG['printgroupname'])[1]; ?></h4>
                    <div class="map-container">
                        <img class="map" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo urlencode($thisCG['hosthomestreetaddress'].", ".$thisCG['hosthomecity'].", ".$thisCG['hosthomestate']." ".$thisCG['hosthomezipcode']); ?>&zoom=15&size=230x333&maptype=roadmap&markers=color:red%7Clabel:%20%7C<?php echo urlencode($thisCG['hosthomestreetaddress'].", ".$thisCG['hosthomecity'].", ".$thisCG['hosthomestate']." ".$thisCG['hosthomezipcode']); ?>" />
                    </div>
                </div>
			</div>
		</div>
        
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/scripts.js"></script>
    </body>
</html>