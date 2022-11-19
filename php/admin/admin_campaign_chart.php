
<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == '1') {
    if (isset($_POST['ongoingCampaignInfoBtn'])) {
        $campaignId = $_POST['campaignId'];
        header("Location: admin.php?ongoingCampaignId=$campaignId");
    } else if (isset($_POST['completedCampaignInfoBtn'])) {
        $campaignId = $_POST['campaignId'];
        header("Location: admin.php?completedCampaignId=$campaignId");
    }
}
