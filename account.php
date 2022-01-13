<?php
    $currentPage="account";
    $title="Account | VD Training";
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    include("res/php/header.php"); 
    include("res/php/navbar.php");
    include("res/php/functions.inc.php");
    $user=getLoggedInUser($mysqli);
?>


<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="row h-25">
                <div class="col-8">
                    <h1><?=htmlspecialchars($user["FirstName"]." ".$user["LastName"]); ?></h1>
                </div>
                <div class="col-4">
                        <img src="https://proficon.stablenetwork.uk/api/identicon/<?=$user["UserID"];?>.svg" alt="Profile Icon" class="h-50">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Content -->


<?php
    include("res/php/footer.php");
?>