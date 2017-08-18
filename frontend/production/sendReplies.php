<?php
    include_once("utils/utils.php");
    include_once('utils/databaseUtils.php');
    include_once("utils/validation.php");

    $email = $_COOKIE["email"];
    $jobJSON = getJobJSON($email, "logs/GetJobJSON.txt");

    $sendReplyScript = "unchecked";
    $sendReplyScriptBool = $jobJSON->sendReplyScript;
    $tweetReplyMessage = $jobJSON->tweetReplyMessage;
    $searchQueryToReply = $jobJSON->searchQueryToReply;
    $maxTweetsToReply = $jobJSON->maxTweetsToReply;

    if($sendReplyScriptBool == "true") {
        $sendReplyScript = "checked";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php getHeaderRedirect() ?>
        <?php getHeader() ?>

        <!-- Switchery -->
        <link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php getSideMenu() ?>

                <?php getTopNavigation() ?>

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Send Tweet Replies Configuration <small>it pays to be nice to everyone!</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class=""></i></a></li>
                                        <li><a class="collapse-link"><i class=""></i></a></li>
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            
                                <div class="x_content">
                                    <?php getNotice() ?>
                                    
                                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Send Replies Script
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Turning on this script will allow you to send replies to Tweeets according to your provided (below) parameters."><i class="fa fa-question-circle"></i></a>
                                            </label> 
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="js-switch sendReplyScript" <?php echo $sendReplyScript ?> onclick="sendReplyScriptClicked()"/>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                  
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Search Query
                                                &nbsp;<a data-toggle="tooltip" data-placement="bottom" title="Twitter search query your script will use to find the Tweets you will favourite. Note: There are many formats you can use to search e.g. @joeytawadrous will search for all tweets made by user joeytawadrous. startups will search for all tweets containing the word or hashtag startups. For a full list of all the types of search queries, please check out the FAQ."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="searchQueryToReply" class="form-control col-md-3 col-xs-6" value="<?php echo $searchQueryToReply ?>">
                                            </div>
                                        </div>
                                  
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Tweet to Reply With
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="What message would you like to use to reply to Tweets that match your search query? Note: Your reply message here will be prefixed with the username of the user who made the Tweet you are replying to e.g. '@joeytawadrous' & suffixed with the full name of the user who made the Tweet you are replying to e.g. 'Joey Rodriguez'"><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="tweetReplyMessage" class="form-control col-md-3 col-xs-6" value="<?php echo $tweetReplyMessage ?>">
                                            </div>

                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Max Tweets to Reply To
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Maximum number of Tweets to reply to in each run of the script (up to 3 runs per day - configurable from your Dashboard -> Global Configuration menu item)."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="maxTweetsToReply" class="form-control col-md-3 col-xs-6" value="<?php echo $maxTweetsToReply ?>">
                                            </div>
                                        </div>
                                  
                                        <div class="ln_solid"></div>
                                        
                                        <?php getSave() ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->

                <?php getFooter() ?>
            </div>
        </div>

        <?php getFooterIncludes() ?>

        <!-- Switchery -->
        <script src="vendors/switchery/dist/switchery.min.js"></script>

        <script type="text/javascript">
            function saveConfig() {
                var userPlan = getCookie("userplan");

                // if(userPlan == "Basic") {
                //     $(".payment-button").click();
                // }
                // else {
                    var sendReplyScript = $(".sendReplyScript").attr("checked");
                    if(sendReplyScript == undefined) { sendReplyScript = false; }
                    else if(sendReplyScript == "checked") { sendReplyScript = true; }

                    var tweetReplyMessage = document.getElementById('tweetReplyMessage').value;
                    var searchQueryToReply = document.getElementById('searchQueryToReply').value;
                    var maxTweetsToReply = document.getElementById('maxTweetsToReply').value;

                    // TODO: remove non numbers from applicable fields above

                    $.ajax({
                        url: 'utils/databaseUtils.php',
                        type: 'post',
                        data: {saveConfig: true, type: "reply", sendReplyScript: sendReplyScript, tweetReplyMessage: tweetReplyMessage, searchQueryToReply: searchQueryToReply, maxTweetsToReply: maxTweetsToReply},
                        success: function(echoeddData) {
                            ajaxFeedback(echoeddData);
                        }
                    });
                // }
            }

            function sendReplyScriptClicked() {
                var elem = $(".sendReplyScript");
                var checked = elem.attr("checked");

                if(checked) {
                    elem.attr("checked", false);
                }
                else {
                    elem.attr("checked", true);
                }
            }
        </script>
    </body>
</html>
