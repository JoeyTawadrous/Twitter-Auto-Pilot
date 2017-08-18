<?php
include_once('../utils/databaseUtils.php');


class BaseCron {

	public function init($runsPerDay) {
		$conn = connectToDB();
	    $now = date("Y-m-d h:i:sa", time());


		// Get file data
		////////////////////////////////////
		writeToLogs("logs/PilotsCronJob.txt", "\n\nRunning PilotsCronJob.php! [" . date("Y-m-d h:i:sa", time()) . "]");
	    writeToLogs("logs/PilotsCronJob.txt", "\n----------------------------------------");

	    $runsPerDaySQL = "";
	    if($runsPerDay == "1") { $runsPerDaySQL = "runsPerDay = '1'"; }
	    if($runsPerDay == "2") { $runsPerDaySQL = "runsPerDay = '2'"; }
	    if($runsPerDay == "3") { $runsPerDaySQL = "runsPerDay = '3'"; }
	    if($runsPerDay == "5") { $runsPerDaySQL = "runsPerDay = '5'"; }

		$sql = "SELECT email FROM users WHERE {$runsPerDaySQL}";
	    $result = mysqli_query($conn, $sql);


	    $numRows = mysqli_num_rows($result);
	    if($numRows > 0) {
	        writeToLogs("logs/PilotsCronJob.txt", "\nRetrieved email(s) for ({$numRows}) user(s) that selected {$runsPerDay} run(s) per day.");

	        $files = array();
	        $i = 0;


	        // Generate files
			////////////////////////////////////
	        while($row = mysqli_fetch_array($result)) {
	        	$email = $row["email"];

				$file = "scripts/" . $email . ".php";
				copy("baseScript.php", $file);
				file_put_contents($file,str_replace('usersEmail', $email, file_get_contents($file)));

				$files[$i] = $file;
				$i++;
			}


		    $localhost = array(
		        '127.0.0.1',
		        '::1'
		    );
		    if(in_array($_SERVER['REMOTE_ADDR'], $localhost)){
		        $baseLocation = "http://localhost:8888/Medieval/SocialAutoPilots/TweetPal/frontend/production/pilots/";
		    }
		    else {
				// HOST CONFIG
		        $baseLocation = "http://www.tweetpal.io/pilots/";
		    }


		    for($i = 0; $i < sizeof($files); $i++) {
			  	$curl = curl_init();
			  	curl_setopt($curl, CURLOPT_URL, $baseLocation . $files[$i]);
			  	curl_setopt($curl, CURLOPT_USERAGENT, 'api');
			    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
			    curl_setopt($curl, CURLOPT_HEADER, 0);
			    curl_setopt($curl,  CURLOPT_RETURNTRANSFER, false);
			    curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
			    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
			    curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10); 
			    curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
			  	curl_exec($curl);
			}


			// Execute files
		    ////////////////////////////////////
		    ?>
		    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
			<script type="text/javascript">
				var files = <?php echo json_encode($files ) ?>;
				var baseLocation = '<?php echo $baseLocation ?>';

				for(var i = 0; i < files.length; i++) {
					$.ajax({
				        url: baseLocation + files[i],
				        type: 'get',
				        error: function(error) {
				        	console.log(error);
				        }
				    });
				}
			</script> -->
		    <?php
	    }
	    else {
	        writeToLogs("logs/PilotsCronJob.txt", "\nCould not retrieve email(s) for users (maybe there are no users with {runsPerDay} runs per day) that selected {$runsPerDay} run(s) per day, at [{$now}]");
	    }
	}
}
?>