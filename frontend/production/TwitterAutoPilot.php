<?php

require_once('lib/auth/twitterOAuth.php');

class TwitterAutoPilot {

	public function init($jobData, $email, $relativeLocation) {
		$jobData = json_encode($jobData);
		$jobData = json_decode($jobData);

		$twitterAuth = new TwitterOAuth($jobData->consumerKey, $jobData->consumerSecret, $jobData->oauthToken, $jobData->oauthSecret);
		date_default_timezone_set("Europe/Dublin");

		// TODO: Only follow people who are following more people than they’re being followed 

		// User Defined Constants Example (passed in $jobData)
		/////////////////////////////////////////////////////////
		// $users = array('GrowthHackers', 'TheNextWeb', 'bramk', 'GrantCardone', 'ProductHunt', 'NikkiElizDemere');
		// $maxFollow = 2; // Max amount of users to follow
		// $maxUnfollow = 4000; // Max amount of users to unfollow (in one run of this script)
		// $minUserFollowers = 1000; // Min amount of followers a user needs to be worth of following
		// $minUserTweets = 250; // Min amount of tweets a user needs to be worth of following
		// $searchQueryToFavourite = "@joeytawadrous"; // Query to search for tweets to favourite
		// $maxTweetsToFavourite = 12; // Max tweets to retrieve with query, and finally favourite
		// $searchQueryToReply = "@joeytawadrous"; // Query to search for tweets to reply
		// $maxTweetsToReply = 12; // Max tweets to retrieve with query, and finally reply to
		// $tweetReplyMessage = "Thanks for the share, ";
		// $maxMessagesToSend = 50; // Max amount of msgs to send
		// $directMessage = "Focus. Make money. Achieve. I can show you how - http://www.joeyt.net/blog";



		$credentials = $twitterAuth->get('account/verify_credentials');
		$currentUser = $credentials->screen_name;
		$users = explode(",", $jobData->users);
		$user = $users[mt_rand(0, count($users) - 1)]; // Set the user who's followers you would like to follow

		$followings = $twitterAuth->get('friends/ids'); // User's I'm following
		$followings = $followings->ids;
		$followings = array_reverse($followings); // Array reversed so oldest user's followed are first

		$followers = $twitterAuth->get('followers/ids'); // User's following me
		$followers = $followers->ids;

		$usersFollowers = $twitterAuth->get('followers/ids', array('screen_name' => $user));
		$usersFollowers = $usersFollowers->ids;

		$followersCount = $this->getFollowersCountForUser($currentUser, $twitterAuth);
		$followingCount = $this->getFollowingCountForUser($currentUser, $twitterAuth);

		
		// Cron job will not always start at the exact same time its scheduled
        sleep(rand(3, 7));



		// Follow
		////////////////////////////////////////////////
		if($jobData->followScript == "true") {
			if($followersCount - $followingCount > -600) {
	            // can't follow any more if followed 2000 and under 2000 followers
	            if($followersCount < 2000 && $followingCount > 1950) {
	                $this->unfollowUsersNotFollowingMe($twitterAuth, $followersCount, $followingCount, $followings, $followers, $jobData, $email, $relativeLocation);
	            }
	            else {
				    $this->followUsersOfUser($twitterAuth, $followersCount, $followingCount, $usersFollowers, $followings, $user, $jobData, $email, $relativeLocation);
	            }
			}
			else {
				$this->unfollowUsersNotFollowingMe($twitterAuth, $followersCount, $followingCount, $followings, $followers, $jobData, $email, $relativeLocation);
			}
		}


		// Unfollow
		////////////////////////////////////////////////
		if($jobData->unfollowScript == "true") {
			$this->unfollowUsersNotFollowingMe($twitterAuth, $followersCount, $followingCount, $followings, $followers, $jobData, $email, $relativeLocation);
		}


		// Follow back people who are already following you but you are not following
		////////////////////////////////////////////////
		if($jobData->followbackScript == "true") {
			$this->followbackUsersFollowingMe($twitterAuth, $followersCount, $followingCount, $followers, $email, $relativeLocation);
		}



		// Send replies to tweeters of tweets that match a search query
		////////////////////////////////////////////////
		if($jobData->sendReplyScript == "true") {
			$this->sendReplies($twitterAuth, $jobData, $email, $relativeLocation);
		}



		// Favourite tweets that match a search query
		////////////////////////////////////////////////
		if($jobData->favouriteScript == "true") {
			$this->favouriteTweets($twitterAuth, $jobData, $email, $relativeLocation);
		}



		// Send msgs to users following me
		////////////////////////////////////////////////
		if($jobData->sendMessageScript == "true") {
			$this->sendMsgs($twitterAuth, $followers, $jobData, $email, $relativeLocation);
		}
	}



	/* MARK: Core Actions          */
	/*******************************/
	function followUsersOfUser($twitterAuth, $followersCount, $followingCount, $usersFollowers, $followings, $user, $jobData, $email, $relativeLocation) {
		$this->writeToLogs($relativeLocation, $email, "\n\n\nFollowing User's of {$user} [" . date("Y-m-d h:i:sa", time()) . "]");
		$this->writeToLogs($relativeLocation, $email, "\n----------------------------------------");
		$this->writeToLogs($relativeLocation, $email, "\nCurrent followers count: {$followersCount} ");
		$this->writeToLogs($relativeLocation, $email, "\nCurrent following count: {$followingCount} ");

		foreach($usersFollowers as $usersFollower) {
			$alreadyFollowingUser = in_array($usersFollower, $followings); // Check if I'm already following this user

			if(!$alreadyFollowingUser && $jobData->maxFollow > 0) {
				$userObj = $this->getUser($twitterAuth, $usersFollower);
				$usersFollowerFollowerCount = $userObj->followers_count;
				$usersFollowerTweetCount = $userObj->statuses_count;
				$usersFollowerScreenName = $userObj->screen_name;

				if($usersFollowerFollowerCount >= $jobData->minUserFollowers && $usersFollowerTweetCount >= $jobData->minUserTweets) {
					$this->followUser($usersFollower, $twitterAuth);
			 		$this->writeToLogs($relativeLocation, $email, "\nFollowed User: {$usersFollowerScreenName} ");
			 		
			 		$jobData->maxFollow--;
		 			$this->delay();
			 	}
			}
		 	if(!($jobData->maxFollow > 0)) {
		 		break;
		 	}
		}
	}

	function followbackUsersFollowingMe($twitterAuth, $followersCount, $followingCount, $followers, $email, $relativeLocation) {
		$this->writeToLogs($relativeLocation, $email, "\n\n\nFollowing Back Users Who I Don't Follow But Who Follow Me [" . date("Y-m-d h:i:sa", time()) . "]");
		$this->writeToLogs($relativeLocation, $email, "\n----------------------------------------");
		$this->writeToLogs($relativeLocation, $email, "\nCurrent followers count: {$followersCount} ");
		$this->writeToLogs($relativeLocation, $email, "\nCurrent following count: {$followingCount} ");

		foreach($followers as $follower) {
			$userObj = $this->getUser($twitterAuth, $follower);
			$followerScreenName = $userObj->screen_name;

			$this->followUser($follower, $twitterAuth);
			$this->writeToLogs($relativeLocation, $email, "\nFollowed User: {$followerScreenName} ");
			$this->delay();
		}
	}

	function unfollowUsersNotFollowingMe($twitterAuth, $followersCount, $followingCount, $followings, $followers, $jobData, $email, $relativeLocation) {
		$this->writeToLogs($relativeLocation, $email, "\n\n\nUnfollowing User's Who Do Not Follow Me [" . date("Y-m-d h:i:sa", time()) . "]");
		$this->writeToLogs($relativeLocation, $email, "\n----------------------------------------");
		$this->writeToLogs($relativeLocation, $email, "\nCurrent followers count: {$followersCount} ");
		$this->writeToLogs($relativeLocation, $email, "\nCurrent following count: {$followingCount} ");

		foreach($followings as $following) {
			$userIsFollowingMeBack = in_array($following, $followers); // Check if user I'm following, is following me
	 		$userObj = $this->getUser($twitterAuth, $following);
			$followingScreenName = $userObj->screen_name;

		 	if(!$userIsFollowingMeBack && $jobData->maxUnfollow > 0) {
				$this->unfollowUser($following, $twitterAuth);
		 		$this->writeToLogs($relativeLocation, $email, "\nUnfollowed User: {$followingScreenName} ");
		 		
		 		$jobData->maxUnfollow--;
		 		$this->delay();
		 	}
		 	if(!($jobData->maxUnfollow > 0)) {
		 		break;
		 	}
		}
	}

	function favouriteTweets($twitterAuth, $jobData, $email, $relativeLocation) {
		$this->writeToLogs($relativeLocation, $email, "\n\n\nFavouriting tweets that match search query '{$jobData->searchQueryToFavourite}'. [" . date("Y-m-d h:i:sa", time()) . "]");
		$this->writeToLogs($relativeLocation, $email, "\n----------------------------------------");

		$tweets = $twitterAuth->get('search/tweets', array('q' => $jobData->searchQueryToFavourite, 'count' => $jobData->maxTweetsToFavourite));

		foreach($tweets->statuses as $tweet) {
			$this->favouriteTweet($twitterAuth, $tweet->id);
			$this->writeToLogs($relativeLocation, $email, "\nFavourited tweet with ID: {$tweet->id} and text: {$tweet->text} ");

			$this->delay();
		}
	}

	function sendReplies($twitterAuth, $jobData, $email, $relativeLocation) {
		$this->writeToLogs($relativeLocation, $email, "\n\nSending replies to tweeters of tweets that match a search query '{$jobData->searchQueryToReply}'. [" . date("Y-m-d h:i:sa", time()) . "]");
		$this->writeToLogs($relativeLocation, $email, "\n----------------------------------------");
		$orginalReply = $jobData->tweetReplyMessage;

		$tweets = $twitterAuth->get('search/tweets', array('q' => $jobData->searchQueryToReply, 'count' => $jobData->maxTweetsToReply));

		foreach($tweets->statuses as $tweet) {
			$tweeterID = $tweet->user->id;
			$statusToReply = $tweet->id;

			$userObj = $this->getUser($twitterAuth, $tweeterID);
			$screenName = $userObj->screen_name;
			$name = $userObj->name;
			$tweetReplyMessage = "@" . $screenName . " " . $orginalReply;

			$this->sendReply($twitterAuth, $tweetReplyMessage, $statusToReply);
			$this->writeToLogs($relativeLocation, $email, "\nReplied to tweet: {$tweetReplyMessage} ");

			$this->delay();
		}
	}

	function sendMsgs($twitterAuth, $followers, $jobData, $email, $relativeLocation) {
		$this->writeToLogs($relativeLocation, $email, "\n\nSending msgs to my followers. Max of {$jobData->maxMessagesToSend}. [" . date("Y-m-d h:i:sa", time()) . "]");
		$this->writeToLogs($relativeLocation, $email, "\n----------------------------------------");
		$orginalMessage = $jobData->directMessage;

		foreach($followers as $follower) {
			if($jobData->maxMessagesToSend > 0) { 
				// TODO: only send if have not recently sent a message
				$userObj = $this->getUser($twitterAuth, $follower);
				$screenName = $userObj->screen_name;
				$directMessage = "Hi " . $screenName . ". " . $orginalMessage;

				$this->sendMsg($twitterAuth, $screenName, $directMessage);
				$this->writeToLogs($relativeLocation, $email, "\nSent msg to user with id: {$screenName} and msg: {$directMessage} ");
			 	
			 	$jobData->maxMessagesToSend--;
				$this->delay();
		 	}
		 	else {
		 		break;
		 	}
		}
	}



	/* MARK: Util Methods          */
	/*******************************/
	function getFollowersCountForUser($user, $twitterAuth) {
		$usersFollowers = $twitterAuth->get('users/show', array('screen_name' => $user));
		return $usersFollowers->followers_count;
	}

	function getFollowingCountForUser($user, $twitterAuth) {
		$usersFollowers = $twitterAuth->get('users/show', array('screen_name' => $user));
		return $usersFollowers->friends_count;
	}

	function followUser($userID, $twitterAuth) {
		$twitterAuth->post('friendships/create', array('user_id' => $userID));
	}

	function unfollowUser($userID, $twitterAuth) {
		$twitterAuth->post('friendships/destroy', array('user_id' => $userID));
	}

	function getUser($twitterAuth, $userID) {
		$user = $twitterAuth->get('users/lookup', array('user_id' => $userID));

		// print "<pre>";
		// print_r($user);
		// print "</pre>";

		return $user[0];
	}

	function favouriteTweet($twitterAuth, $tweetID) {
		$twitterAuth->post('favorites/create', array('id' => $tweetID));
	}

	function sendReply($twitterAuth, $tweetReplyMessage, $statusToReply) {
		$result = $twitterAuth->post('statuses/update', array('status' => $tweetReplyMessage, 'in_reply_to_status_id' => $statusToReply));
	}

	function sendMsg($twitterAuth, $screen_name, $directMessage) {
		$result = $twitterAuth->post('direct_messages/new', array('screen_name' => $screen_name, 'text' => $directMessage));
	}

	function delay() {
		$delayTime = rand(3, 8);
		sleep($delayTime);
	}



	function writeToLogs($relativeLocation, $email, $textToWrite) {
		$currentfile = $relativeLocation . $email;
		$updatedFile = file_get_contents($currentfile);
		$updatedFile .= $textToWrite;
		file_put_contents($currentfile, $updatedFile);
	}
}

?>