<?php
    include_once("utils/utils.php");
    include_once('utils/databaseUtils.php');
    include_once("utils/validation.php");

    $email = $_COOKIE["email"];
    $jobJSON = getJobJSON($email, "logs/GetJobJSON.txt");

    $sendMessageScript = "unchecked";
    $sendMessageScriptBool = $jobJSON->sendMessageScript;
    $directMessage = $jobJSON->directMessage;
    $maxMessagesToSend = $jobJSON->maxMessagesToSend;

    if($sendMessageScriptBool == "true") {
        $sendMessageScript = "checked";
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
                                    <h2>Send Messages Configuration <small>let them know what you can do</small></h2>
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
                                                Send Messages Script
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Turning on this script will allow you to send messages to users you are following according to your provided (below) parameters."><i class="fa fa-question-circle"></i></a>
                                            </label> 
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="js-switch sendMessageScript" <?php echo $sendMessageScript ?> onclick="sendMessageScriptClicked()"/>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                  
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Message to Send
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="What message would you like to use to send messages to Twitter users you are following."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="directMessage" class="form-control col-md-3 col-xs-6" value="<?php echo $directMessage ?>">
                                            </div>

                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Max Messages to Send
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Maximum number of messages to send in each run of the script (up to 3 runs per day - configurable from your Dashboard -> Global Configuration menu item)."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="maxMessagesToSend" class="form-control col-md-3 col-xs-6" value="<?php echo $maxMessagesToSend ?>">
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
                    var sendMessageScript = $(".sendMessageScript").attr("checked");
                    if(sendMessageScript == undefined) { sendMessageScript = false; }
                    else if(sendMessageScript == "checked") { sendMessageScript = true; }

                    var directMessage = document.getElementById('directMessage').value;
                    var maxMessagesToSend = document.getElementById('maxMessagesToSend').value;

                    // TODO: remove non numbers from applicable fields above

                    $.ajax({
                        url: 'utils/databaseUtils.php',
                        type: 'post',
                        data: {saveConfig: true, type: "sendMessage", sendMessageScript: sendMessageScript, directMessage: directMessage, maxMessagesToSend: maxMessagesToSend},
                        success: function(echoeddData) {
                            ajaxFeedback(echoeddData);
                        }
                    });
                // }
            }

            function sendMessageScriptClicked() {
                var elem = $(".sendMessageScript");
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
