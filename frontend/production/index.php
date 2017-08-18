<?php
    include_once("utils/utils.php");
    include_once('utils/databaseUtils.php');
    include_once("utils/validation.php");

    $email = $_COOKIE["email"];
    $jobJSON = getJobJSON($email, "logs/GetJobJSON.txt");
    $runsPerDay = getRunsPerDay($email, "logs/GetJobJSON.txt");

    $consumerKey = $jobJSON->consumerKey;
    $consumerSecret = $jobJSON->consumerSecret;
    $oauthToken = $jobJSON->oauthToken;
    $oauthSecret = $jobJSON->oauthSecret;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php getHeaderRedirect() ?>
        <?php getHeader() ?>
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
                                    <h2>Global Configuration <small>to get you started</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class=""></i></a></li>
                                        <li><a class="collapse-link"><i class=""></i></a></li>
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            
                                <div class="x_content">
                                    <br />
                                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Consumer Key
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Please check the FAQ for simple steps on where to find this."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="consumerKey" class="form-control col-md-3 col-xs-6" value="<?php echo $consumerKey ?>">
                                            </div>

                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Consumer Secret
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Please check the FAQ for simple steps on where to find this."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="consumerSecret" class="form-control col-md-3 col-xs-6" value="<?php echo $consumerSecret ?>">
                                            </div>
                                        </div>
                                  
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Access Token
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Please check the FAQ for simple steps on where to find this."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="oauthToken" class="form-control col-md-3 col-xs-6" value="<?php echo $oauthToken ?>">
                                            </div>

                                            <label class="control-label col-md-3 col-sm-3 col-xs-6">
                                                Access Token Secret
                                                &nbsp;<a data-toggle="tooltip" data-placement="top" title="Please check the FAQ for simple steps on where to find this."><i class="fa fa-question-circle"></i></a>
                                            </label>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <input type="text" id="oauthSecret" class="form-control col-md-3 col-xs-6" value="<?php echo $oauthSecret ?>">
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-9" style="text-align: right; margin: 20px 0 0 0">
                                                <label class="control-label">
                                                    How many times shall we run your Twitter script per day?
                                                    &nbsp;<a data-toggle="tooltip" data-placement="top" title="Please see the FAQ for info on how many follows, favourites, sent messages etc you can expect with each run of the script."><i class="fa fa-question-circle"></i></a>
                                                </label>
                                                <select id="runsPerDay" class="form-control">
                                                    <option value="0">Zero (Please Select a Time of Day)</option>
                                                    <option value="1">Once (In the Morning)</option>
                                                    <option value="2">Twice (In the Morning & the Evening)</option>
                                                    <option value="3">Thrice (In the Morning, Evening & Night)</option>
                                                </select>
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

        <script type="text/javascript">
            function saveConfig() {
                var userPlan = getCookie("userplan");

                // if(userPlan == "Basic") {
                //     $(".payment-button").click();
                // }
                // else {
                    var consumerKey = document.getElementById('consumerKey').value;
                    var consumerSecret = document.getElementById('consumerSecret').value;
                    var oauthToken = document.getElementById('oauthToken').value;
                    var oauthSecret = document.getElementById('oauthSecret').value;
                    var runsPerDay = document.getElementById('runsPerDay').value;

                    $.ajax({
                        url: 'utils/databaseUtils.php',
                        type: 'post',
                        data: {saveConfig: true, type: "global", consumerKey: consumerKey, consumerSecret: consumerSecret, oauthToken: oauthToken, oauthSecret: oauthSecret, runsPerDay: runsPerDay},
                        success: function(echoeddData) {
                            ajaxFeedback(echoeddData);
                        }
                    });
                // }
            }

            $(document).ready(function() {
                var runsPerDay = "<?php echo $runsPerDay ?>";
                document.getElementById("runsPerDay").selectedIndex = runsPerDay;
            });
        </script>
    </body>
</html>
