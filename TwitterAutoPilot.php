<?php
require_once('twitterOAuth.php');
require_once('myTwitterAuthTokens.php');

$twitterAuth = new TwitterOAuth ( YOUR_TWITTER_APP_CONSUMER_KEY, YOUR_TWITTER_APP_CONSUMER_SECRET, YOUR_TWITTER_APP_OAUTH_TOKEN, YOUR_TWITTER_APP_OAUTH_SECRET);

date_default_timezone_set("Europe/Dublin");
$maxDelayTime = 7; // Set the max delay in seconds between api requests (following or unfollowing)
$maxUnfollow = 3000; // Set the max amount of users to unfollow in one run of this script
$maxFollow = 973; // Set the max amount of users to follow in one run of this script
$user = "tferris"; // Set the user who's followers you would like to follow


$followings = $twitterAuth->get('friends/ids'); // User's I'm following
$followings = $followings->ids;
$followings = array_reverse($followings); // Array reversed so oldest user's followed are first

$followers = $twitterAuth->get('followers/ids'); // User's following me
$followers = $followers->ids;

$usersFollowers = $twitterAuth->get('followers/ids', array('screen_name' => $user));
$usersFollowers = $usersFollowers->ids;


followUsersOfUser($twitterAuth, $usersFollowers, $followings, $maxDelayTime, $maxFollow);
// unfollowUsersNotFollowingMe($twitterAuth, $followings, $followers, $maxDelayTime, $maxUnfollow);


function followUsersOfUser($twitterAuth, $usersFollowers, $followings, $maxDelayTime, $maxFollow)
{
	writeToLogs("\n\n\nFollowing User's [" . date("Y-m-d h:i:sa", time()) . "]");
	writeToLogs("\n----------------------------------------");

	foreach( $usersFollowers as $usersFollower )
	{
		$alreadyFollowingUser = in_array( $usersFollower, $followings ); // Check if I'm already following this user

		if( !$alreadyFollowingUser && $maxFollow > 0 )
		{
			followUser($usersFollower, $twitterAuth);
	 		$delayTime = rand(3, $maxDelayTime);
	 		sleep($delayTime);

	 		writeToLogs("\nFollowed User. Sleeping for " . $delayTime . " seconds."); 
	 		writeToLogs("\n");
	 		$maxFollow--;
		}
	 	if( !($maxFollow > 0) )
	 	{
	 		break;
	 	}
	}
}

function unfollowUsersNotFollowingMe($twitterAuth, $followings, $followers, $maxDelayTime, $maxUnfollow)
{
	writeToLogs("\n\n\nUnfollowing User's Who Do Not Follow Me [" . date("Y-m-d h:i:sa", time()) . "]");
	writeToLogs("\n----------------------------------------");

	foreach( $followings as $following )
	{
		$userIsFollowingMeBack = in_array( $following, $followers ); // Check if user I'm following, is following me

	 	if( !$userIsFollowingMeBack && $maxUnfollow > 0 )
		{
			unfollowUser($following, $twitterAuth);
	 		$delayTime = rand(3, $maxDelayTime);
	 		sleep($delayTime);

	 		writeToLogs("\nUnfollowed User. Sleeping for " . $delayTime . " seconds."); 
	 		writeToLogs("\n");
	 		$maxUnfollow--;
	 	}
	 	if( !($maxUnfollow > 0) )
	 	{
	 		break;
	 	}
	}
}

function followUsersFollowingMe()
{
	foreach( $followers as $follower )
	{
		followUser($follower);
	}
}

function followUser($user, $twitterAuth)
{
	$parameters = array( 'user_id' => $user );
	$status = $twitterAuth->post('friendships/create', $parameters);
}

function unfollowUser($user, $twitterAuth)
{
	$parameters = array( 'user_id' => $user );
	$status = $twitterAuth->post('friendships/destroy', $parameters);
}

function writeToLogs($textToWrite)
{
	$currentfile = "logs.txt";
	$updatedFile = file_get_contents($currentfile);
	$updatedFile .= $textToWrite;
	file_put_contents($currentfile, $updatedFile);
}

?>