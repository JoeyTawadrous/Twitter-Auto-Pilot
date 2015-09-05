<?php

require_once('lib/twitterOAuth.php');

class TwitterAutoPilot {

	/* MARK: Main Logic            */
	/*******************************/
	public function init($APP_CONSUMER_KEY, $APP_CONSUMER_SECRET, $APP_OAUTH_TOKEN, $APP_OAUTH_SECRET) {
		$twitterAuth = new TwitterOAuth($APP_CONSUMER_KEY, $APP_CONSUMER_SECRET, $APP_OAUTH_TOKEN, $APP_OAUTH_SECRET);

		date_default_timezone_set("Europe/Dublin");
		$maxDelayTime = 8; // Set the max delay in seconds between api requests (following or unfollowing)
		$maxUnfollow = 4000; // Set the max amount of users to unfollow in one run of this script
		$maxFollow = 984; // Set the max amount of users to follow in one run of this script

		$credentials = $twitterAuth->get('account/verify_credentials');
		$currentUser = $credentials->screen_name;

		$users = array('tferris', 'TechCrunch', 'CNET', 'leanstartup');
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

		if($followersCount - $followingCount > -600) {
			$this->followUsersOfUser($twitterAuth, $followersCount, $followingCount, $usersFollowers, $followings, $maxDelayTime, $maxFollow, $user);
		}
		else {
			$this->unfollowUsersNotFollowingMe($twitterAuth, $followersCount, $followingCount, $followings, $followers, $maxDelayTime, $maxUnfollow);
		}
	}


	/* MARK: Util Methods          */
	/*******************************/
	function getFollowersCountForUser($user, $twitterAuth) {
		$usersFollowers = $twitterAuth->get('users/show', array('screen_name' => $user));

		$followersCount = $usersFollowers->followers_count;
		return $followersCount;
	}

	function getFollowingCountForUser($user, $twitterAuth) {
		$usersFollowers = $twitterAuth->get('users/show', array('screen_name' => $user));

		$followingCount = $usersFollowers->friends_count;
		return $followingCount;
	}

	function followUsersOfUser($twitterAuth, $followersCount, $followingCount, $usersFollowers, $followings, $maxDelayTime, $maxFollow, $user) {
		$this->writeToLogs("\n\n\nFollowing User's of " . $user . ". [" . date("Y-m-d h:i:sa", time()) . "]");
		$this->writeToLogs("\n----------------------------------------");
		$this->writeToLogs("\nCurrent followers count: " . $followersCount);
		$this->writeToLogs("\nCurrent following count: " . $followingCount);

		foreach($usersFollowers as $usersFollower) {
			$alreadyFollowingUser = in_array($usersFollower, $followings); // Check if I'm already following this user

			if(!$alreadyFollowingUser && $maxFollow > 0) {
				$this->followUser($usersFollower, $twitterAuth);
		 		$delayTime = rand(3, $maxDelayTime);
		 		sleep($delayTime);

		 		$this->writeToLogs("\nFollowed User. Sleeping for " . $delayTime . " seconds.");
		 		$maxFollow--;
			}
		 	if(!($maxFollow > 0)) {
		 		break;
		 	}
		}
	}

	function unfollowUsersNotFollowingMe($twitterAuth, $followersCount, $followingCount, $followings, $followers, $maxDelayTime, $maxUnfollow) {
		$this->writeToLogs("\n\n\nUnfollowing User's Who Do Not Follow Me [" . date("Y-m-d h:i:sa", time()) . "]");
		$this->writeToLogs("\n----------------------------------------");
		$this->writeToLogs("\nCurrent followers count: " . $followersCount);
		$this->writeToLogs("\nCurrent following count: " . $followingCount);

		foreach($followings as $following) {
			$userIsFollowingMeBack = in_array($following, $followers); // Check if user I'm following, is following me

		 	if(!$userIsFollowingMeBack && $maxUnfollow > 0) {
				$this->unfollowUser($following, $twitterAuth);
		 		$delayTime = rand(3, $maxDelayTime);
		 		sleep($delayTime);

		 		$this->writeToLogs("\nUnfollowed User. Sleeping for " . $delayTime . " seconds.");
		 		$maxUnfollow--;
		 	}
		 	if(!($maxUnfollow > 0)) {
		 		break;
		 	}
		}
	}

	function followUsersFollowingMe() {
		foreach($followers as $follower) {
			$this->followUser($follower);
		}
	}

	function followUser($user, $twitterAuth) {
		$twitterAuth->post('friendships/create', array('user_id' => $user));
	}

	function unfollowUser($user, $twitterAuth) {
		$twitterAuth->post('friendships/destroy', array('user_id' => $user));
	}

	function writeToLogs($textToWrite) {
		$currentfile = "logs.txt";
		$updatedFile = file_get_contents($currentfile);
		$updatedFile .= $textToWrite;
		file_put_contents($currentfile, $updatedFile);
	}
}

?>