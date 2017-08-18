<?php
    include_once("utils/utils.php");
    include_once('utils/databaseUtils.php');
    include_once("utils/validation.php");
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
                                    <h2>FAQ <small>frequently asked questions</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class=""></i></a></li>
                                        <li><a class="collapse-link"><i class=""></i></a></li>
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            
                                <div class="x_content">
                                    <?php getNotice() ?>

                                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                    	<div class="panel">
				                       		<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				                         		<h4 class="panel-title">How many new followers will I get using TweetPal?</h4>
				                        	</a>
				                        	<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
				                          		<div class="panel-body">
				                          			Our users have seen anywhere from 300 - 3000 new followers a week using TweetPal.
				                            	</div>
				                          	</div>
				                      	</div>

				                     	<div class="panel">
				                       		<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				                         		<h4 class="panel-title">What can I do with TweetPal?</h4>
				                        	</a>
				                        	<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
				                          		<div class="panel-body">
				                          			TweetPal.io allows you to automate common Twitter activities such as following & unfollowing Twitter accounts, following users back, favoriting tweets that match a search query, sending messages to users who are following you. 
				                          			<br><ul>
				                            			<li>Follow users of a certain user.</li> 
														<li>Follow users of a certain user, with a minimum amount of followers.</li>
														<li>Follow users of a certain user, with a minimum amount of tweets.</li>
														<li>Follow back users who are following you.</li>
														<li>Unfollow users who are not following you back.</li>
														<li>Favourite tweets that match a search query.</li>
														<li>Send messages to users who are following you.</li>
														<li>Send replies to tweeters of tweets that match a search query.</li>
														<li>Set the amoount of times to run your scripts each day.</li>
														<li>Set the Twitter accounts you like to use as the source of Twitter accounts to follow? i.e. you will follow people who follow the source accounts.</li>
														<li>Set the max delay in seconds between api requests.</li>
														<li>Set the max amount of users to unfollow in one run of this script.</li>
														<li>Set the max amount of users to follow in one run of this script.</li>
														<li>Set the max minimum number of followers a Twitter account must have in order to be followed. </li>
														<li>Set the max minimum number of tweets a Twitter account must have in order to be followed. </li>
														<li>Set the max amount of replies to Tweets in one run of this script.</li>
														<li>Set the max amount of messages to send to users you are following in one run of this script.</li>
														<li>Set the max amount of Tweets to favourite in one run of this script.</li>
														<li>Set the search query to be used when finding certain Tweets to be favourited.</li>
														<li>Set the search query to be used when finding certain Tweets to be replied to.</li>
														<li>The message to send to users who are following you.</li>
														<li>The message to send to Tweets that you are replying to.</li>
													</ul>
				                            	</div>
				                          	</div>
				                      	</div>

				                      	<div class="panel">
				                       		<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				                         		<h4 class="panel-title">Will Twitter penalise me for using TweetPal?</h4>
				                        	</a>
				                        	<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
				                          		<div class="panel-body">
				                          			Absolutely not. The scripts associated with this tool have been used by countless Twitter users already and 0 of them have been banned.
				                          			<br>
				                          			Each script will carry out your desired actions while always staying inside Twitters limits.
				                            	</div>
				                          	</div>
				                      	</div>

				                      	<div class="panel">
				                       		<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				                         		<h4 class="panel-title">How do I get my App Consumer Key / App Consumer Secret / OAuth Token / OAuth Secret?</h4>
				                        	</a>
				                        	<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
				                          		<div class="panel-body">
				                          			To get any of the aforementioned values, you must simply register an app on your Twitter account. The values you require will then be available. As simple as it may seem, the following are links that will provide you with a step by step guide on how you can register your Twitter app & retrieve the two keys and two secrets that are required to run your scrips on Tweet Pal.
													<ul>
														<li><a href="https://themepacific.com/how-to-generate-api-key-consumer-token-access-key-for-twitter-oauth/994/" target="_blank"</a>Article</li>
														<li><a href="https://www.youtube.com/watch?v=svoUK2DmGmw" target="_blank"</a>Youtube Video</li>
														<li><a href="https://twittercommunity.com/t/how-do-i-find-my-consumer-key-and-secret/646/7" target="_blank"</a>Article</li>
														<li><a href="https://iag.me/socialmedia/how-to-create-a-twitter-app-in-8-easy-steps/" target="_blank"</a>Twitter Documentation</li>
													</ul>
				                            	</div>
				                          	</div>
				                      	</div>

				                      	<div class="panel">
				                       		<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				                         		<h4 class="panel-title">What types of search query can I have for my favourite & tweet reply scripts?</h4>
				                        	</a>
				                        	<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
				                          		<div class="panel-body">
				                          			There are many formats you can use to search e.g. @joeytawadrous will search for all tweets made by user joeytawadrous. A search query of startups will search for all tweets containing the word or hashtag startups. A query can also have operators that modify its behaviour. For a full list of all the types of search queries, check out <a href="https://dev.twitter.com/rest/public/search">Twitter's search documentation.</a>
				                            	</div>
				                          	</div>
				                      	</div>

				                      	<div class="panel">
				                       		<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
				                         		<h4 class="panel-title">How do I get the best out of Tweet Pal?</h4>
				                        	</a>
				                        	<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
				                          		<div class="panel-body">
				                          			For best results, only select two scripts to run at any given time. For example, follow & favourite, unfollow and send messages etc. Also note that each Twitter action taken on your account (follow, favourite etc) through your script will have a random delay of 15 - 90 seconds in between each action. This is to stay well inside Twitter’s limits and to ensure that your activity looks as normal as it would be if you were carrying out each follow, favourite etc yourself.
				                            	</div>
				                          	</div>
				                      	</div>
				                    </div>
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
