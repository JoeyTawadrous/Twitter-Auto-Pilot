<?php
    include_once("utils/utils.php");
    include_once('utils/databaseUtils.php');
    include_once("utils/validation.php");

    $email = $_COOKIE["email"];
    $jobJSON = getJobJSON($email, "logs/GetJobJSON.txt");

    $followScript = "unchecked";
    $followScriptBool = $jobJSON->followScript;
    $followbackScript = "unchecked";
    $followbackScriptBool = $jobJSON->followbackScript;
    $unfollowScript = "unchecked";
    $unfollowScriptBool = $jobJSON->unfollowScript;
    $users = $jobJSON->users;
    $maxFollow = $jobJSON->maxFollow;
    $minUserFollowers = $jobJSON->minUserFollowers;
    $minUserTweets = $jobJSON->minUserTweets;

    if($followScriptBool == "true") {
        $followScript = "checked";
    }
    if($followbackScriptBool == "true") {
        $followbackScript = "checked";
    }
    if($unfollowScriptBool == "true") {
        $unfollowScript = "checked";
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
                                    <h2>Follow Configuration <small>you can make it to 10,000 followers and beyond!</small></h2>
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
                                                Follow Script
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Turning on this script will allow you to follow Twitter users according to your provided (below) parameters."><i class="fa fa-question-circle"></i></a>
                                            </label> 
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="js-switch followScript" <?php echo $followScript ?> onclick="followScriptClicked()"/>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Followback Script
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Turning on this script will allow you to follow back Twitter users (who are following you but who you are not following)."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="js-switch followbackScript" <?php echo $followbackScript ?> onclick="followbackScriptClicked()"/>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Unfollow Script
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Turning on this script will allow you to unfollow Twitter users (who are not following you back). Note: the oldest Twiiter accounts that you have followed (who have not followed you back) will be unfollowed first."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="js-switch unfollowScript" <?php echo $unfollowScript ?> onclick="unfollowScriptClicked()"/>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                    Source Accounts
                                                    &nbsp;<a data-toggle="tooltip" data-placement="top" title="What Twitter accounts would you like to use as the source of Twitter accounts to follow? i.e. you will be following people who follow the source accounts you provide here."><i class="fa fa-question-circle"></i></a>
                                                </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input id="tags_1" type="text" class="tags form-control" value="<?php echo $users ?>" />
                                                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Follow Limit
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Maximum Twitter accounts to follow in each run of the script (up to 3 runs per day - configurable from your Dashboard -> Global Configuration menu item)."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="maxFollow" class="form-control col-md-3 col-xs-6" value="<?php echo $maxFollow ?>">
                                            </div>
                                        </div>
                                  
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Min User Followers
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Minimum number of followers a Twitter account must have in order to be followed."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="minUserFollowers" class="form-control col-md-3 col-xs-6" value="<?php echo $minUserFollowers ?>">
                                            </div>

                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Min User Tweets
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Minimum number of tweets a Twitter account must have in order to be followed."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="minUserTweets" class="form-control col-md-3 col-xs-6" value="<?php echo $minUserTweets ?>">
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

        <!-- jQuery Tags Input -->
        <script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
        <!-- Switchery -->
        <script src="vendors/switchery/dist/switchery.min.js"></script>

        <script type="text/javascript">
            function saveConfig() {
                var userPlan = getCookie("userplan");

                // if(userPlan == "Basic") {
                //     $(".payment-button").click();
                // }
                // else {
                    var followScript = $(".followScript").attr("checked");
                    if(followScript == undefined) { followScript = false; }
                    else if(followScript == "checked") { followScript = true; }

                    var followbackScript = $(".followbackScript").attr("checked");
                    if(followbackScript == undefined) { followbackScript = false; }
                    else if(followbackScript == "checked") { followbackScript = true; }

                    var unfollowScript = $(".unfollowScript").attr("checked");
                    if(unfollowScript == undefined) { unfollowScript = false; }
                    else if(unfollowScript == "checked") { unfollowScript = true; }

                    var users = document.getElementById('tags_1').value;
                    var maxFollow = document.getElementById('maxFollow').value;
                    var minUserFollowers = document.getElementById('minUserFollowers').value;
                    var minUserTweets = document.getElementById('minUserTweets').value;

                    // TODO: remove non numbers from applicable fields above

                    $.ajax({
                        url: 'utils/databaseUtils.php',
                        type: 'post',
                        data: {saveConfig: true, type: "follow", followScript: followScript, followbackScript: followbackScript, unfollowScript: unfollowScript, users: users, maxFollow: maxFollow, minUserFollowers: minUserFollowers, minUserTweets: minUserTweets},
                        success: function(echoeddData) {
                            ajaxFeedback(echoeddData);
                        }
                    });
                // }
            }

            function followScriptClicked() {
                var elem = $(".followScript");
                var checked = elem.attr("checked");

                if(checked) {
                    elem.attr("checked", false);
                }
                else {
                    elem.attr("checked", true);
                }
            }

            function followbackScriptClicked() {
                var elem = $(".followbackScript");
                var checked = elem.attr("checked");

                if(checked) {
                    elem.attr("checked", false);
                }
                else {
                    elem.attr("checked", true);
                }
            }

            function unfollowScriptClicked() {
                var elem = $(".unfollowScript");
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
