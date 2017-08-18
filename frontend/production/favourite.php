<?php
    include_once("utils/utils.php");
    include_once('utils/databaseUtils.php');
    include_once("utils/validation.php");

    $email = $_COOKIE["email"];
    $jobJSON = getJobJSON($email, "logs/GetJobJSON.txt");

    $favouriteScript = "unchecked";
    $favouriteScriptBool = $jobJSON->favouriteScript;
    $searchQueryToFavourite = $jobJSON->searchQueryToFavourite;
    $maxTweetsToFavourite = $jobJSON->maxTweetsToFavourite;

    if($favouriteScriptBool == "true") {
        $favouriteScript = "checked";
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
                                    <h2>Favourite Configuration <small>be the nicest person on the Twittersphere!</small></h2>
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
                                                Favourite Script
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Turning on this script will allow you to favourite tweets according to your provided (below) parameters."><i class="fa fa-question-circle"></i></a>
                                            </label> 
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="js-switch favouriteScript" <?php echo $favouriteScript ?> onclick="favouriteScriptClicked()"/>
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
                                                <input type="text" id="searchQueryToFavourite" class="form-control col-md-3 col-xs-6" value="<?php echo $searchQueryToFavourite ?>">
                                            </div>

                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Max Tweets to Favourite
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Maximum number of Tweets to favourite in each run of the script (up to 3 runs per day - configurable from your Dashboard -> Global Configuration menu item)."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="maxTweetsToFavourite" class="form-control col-md-3 col-xs-6" value="<?php echo $maxTweetsToFavourite ?>">
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
                    var favouriteScript = $(".favouriteScript").attr("checked");
                    if(favouriteScript == undefined) { favouriteScript = false; }
                    else if(favouriteScript == "checked") { favouriteScript = true; }

                    var searchQueryToFavourite = document.getElementById('searchQueryToFavourite').value;
                    var maxTweetsToFavourite = document.getElementById('maxTweetsToFavourite').value;

                    // TODO: remove non numbers from applicable fields above

                    $.ajax({
                        url: 'utils/databaseUtils.php',
                        type: 'post',
                        data: {saveConfig: true, type: "favourite", favouriteScript: favouriteScript, searchQueryToFavourite: searchQueryToFavourite, maxTweetsToFavourite: maxTweetsToFavourite},
                        success: function(echoeddData) {
                            ajaxFeedback(echoeddData);
                        }
                    });
                // }
            }

            function favouriteScriptClicked() {
                var elem = $(".favouriteScript");
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
