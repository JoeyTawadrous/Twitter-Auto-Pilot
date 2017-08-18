<?php 
    ob_start();
?>

<script type="text/javascript">
	function showError(errorText, errorDivID) {
        var errorDiv = document.getElementById(errorDivID);
    	errorDiv.innerHTML = errorText;
        errorDiv.style.display = "block";
    }

    function showSuccess(successText, successDivID) {
        var successDiv = document.getElementById(successDivID);
        successDiv.innerHTML = successText;
        successDiv.style.display = "block";
        successDiv.style.color = "#31708f";
        successDiv.style.backgroundColor = "#d9edf7";
        successDiv.style.borderColor = "#bce8f1";
    }
</script>


<?php
	function getNotice() {
	?>
		<div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>PS: For best results</strong>, select two scripts to run at any given time. For example, follow & favourite, unfollow & send messages etc. Also note that each Twitter action taken on your account (follow, favourite etc) through your script will have a random delay of 15 - 90 seconds in between each action. This is to stay well inside Twitter’s limits and to ensure that your activity looks as normal as it would be if you were carrying out each follow, favourite etc yourself. 
        </div>
	<?php	
	}

	function getSave() {
	?>
		<div class="form-group">
            <div class="col-md-1 col-sm-1 col-xs-2 col-md-offset-11">
                <a class="btn btn-success" onclick="saveConfig()">Save</a>
            </div>

            <button type="button" class="btn btn-primary payment-button" data-toggle="modal" data-target=".payment-modal" style="display: none">Payment button</button>

            <div class="modal fade payment-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Upgrade Please!</h4>
                        </div>
                        <div class="modal-body">
                            <h4>Apply Coupon</h4>
                            <p>Please apply your coupon below in order to save your configuration and run your scripts.</p>
                            <input type="text" id="coupon-input" class="form-control col-md-3 col-xs-6" placeholder="Coupon code">
                        </div>
                        <div class="modal-footer">
                            <br><button type="button" class="btn btn-default" data-dismiss="modal" style="margin-bottom: 5px !important">Close</button>
                            <button type="button" class="btn btn-primary" onclick="validateApplyCouponForm()">Apply Coupon</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php	
	}

	function getHeader() {
	?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <!-- Meta, title, CSS, favicons, etc. -->
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta charset="utf-8">
        <meta name="description" content="TweetPal allows you to easily automate your Twitter marketing. Follow, unfollow, favourite, tweet, reply.">
        <meta name="keywords" content="HTML,CSS,JavaScript,app,mobile,marketing,follow,unfollow,favourite,tweet, reply,page,website,design,ios,apple,android,google,windows,phone,success,inspiration">
        <meta name="author" content="Joey Tawadrous">
    	<link rel="shortcut icon" href="images/twitter.png">

	    <title>TweetPal | Automate your Twitter marketing</title>

	    <!-- Bootstrap -->
	    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	    <!-- Font Awesome -->
	    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	    <!-- NProgress -->
	    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	    <!-- bootstrap-wysiwyg -->
	    <link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	    <!-- PNotify -->
	    <link href="vendors/pnotify/dist/pnotify.css" rel="stylesheet">
	    <link href="vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
	    <link href="vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

	    <!-- Custom styling plus plugins -->
	    <link href="build/css/custom.min.css" rel="stylesheet">
	<?php
	}


	function getHeaderRedirect() {
		// HOST CONFIG
		if(!isset($_COOKIE["email"])) {
			header("Location: login.php");
		}
	}


	function getSideMenu() {
	?>
		<div class="col-md-3 left_col">
          	<div class="left_col scroll-view">
            	<div class="navbar nav_title" style="border: 0;">
              		<a href="index.php" class="site_title">
              			<img src="images/twitter.png" alt="" style="width: 48px">
              			<span>Tweet Pal</span>
              		</a>
            	</div>

            	<div class="clearfix"></div>

            	<!-- menu profile quick info -->
            	<div class="profile clearfix">
              		<div class="profile_pic">
                		<img src="images/terminal.png" alt="Tweet Pal" style="width: 65px; margin: 20px 0 0 10px">
              		</div>
              		<div class="profile_info">
                		<span>Welcome,</span>
                		<h2><?php echo $_COOKIE["fullName"] ?></h2>
              		</div>
            	</div>
            	<!-- /menu profile quick info -->

            	<br />

	            <!-- sidebar menu -->
	            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	              	<div class="menu_section">
	                	<ul class="nav side-menu">
	                		<li><a><i class="fa fa-dashboard"></i> Dashboard <span class="fa fa-chevron-down"></span></a>
	                    		<ul class="nav child_menu">
	                      			<li><a href="index.php">Global Configuration</a></li>
	                      			<li><a href="#">Log <span class="label label-success pull-right">Coming Soon</span></a></li>
	                      			<li><a href="#">Profile <span class="label label-success pull-right">Coming Soon</span></a></li>
	                    		</ul>
	                  		</li> 
	                  		<li><a><i class="fa fa-users"></i> Follow & Unfollow <span class="fa fa-chevron-down"></span></a>
	                    		<ul class="nav child_menu">
	                      			<li><a href="follow.php">Configuration</a></li>
	                      			<li><a href="#">Analytics <span class="label label-success pull-right">Coming Soon</span></a></li>
	                    		</ul>
	                  		</li>  
	                  		<li><a><i class="fa fa-star"></i> Favourite <span class="fa fa-chevron-down"></span></a>
	                    		<ul class="nav child_menu">
	                      			<li><a href="favourite.php">Configuration</a></li>
	                      			<li><a href="#">Analytics <span class="label label-success pull-right">Coming Soon</span></a></li>
	                    		</ul>
	                  		</li>  
	                  		<li><a><i class="fa fa-reply"></i> Send Tweet Replies <span class="fa fa-chevron-down"></span></a>
	                    		<ul class="nav child_menu">
	                      			<li><a href="sendReplies.php">Configuration</a></li>
	                      			<li><a href="#">Analytics <span class="label label-success pull-right">Coming Soon</span></a></li>
	                    		</ul>
	                  		</li> 
	                  		<li><a><i class="fa fa-envelope"></i> Send Messages <span class="fa fa-chevron-down"></span></a>
	                    		<ul class="nav child_menu">
	                      			<li><a href="sendMessages.php">Configuration</a></li>
	                      			<li><a href="#">Analytics <span class="label label-success pull-right">Coming Soon</span></a></li>
	                    		</ul>
	                  		</li> 
	                  		<li><a href="faq.php"><i class="fa fa-question"></i> FAQ </a></li>
	                	</ul>
	              	</div>
	            </div>
	            <!-- /sidebar menu -->
          	</div>
        </div>
	<?php
	}


	function getTopNavigation() {
	?>	
		<!-- top navigation -->
        <div class="top_nav">
          	<div class="nav_menu">
            	<nav>
              		<div class="nav toggle">
                		<a id="menu_toggle"><i class="fa fa-bars"></i></a>
              		</div>

              		<ul class="nav navbar-nav navbar-right">
                		<li class="">
                  			<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    			<img src="images/certificate.png" alt="Tweet Pal">
                    			<?php echo $_COOKIE["fullName"] ?>
                    			<span class=" fa fa-angle-down"></span>
                  			</a>
                  			<ul class="dropdown-menu dropdown-usermenu pull-right">
                    			<li><a href="faq.php">FAQ</a></li>
                    			<li><a onclick="logout()"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  			</ul>
                		</li>
                	</ul>
            	</nav>
          	</div>
        </div>
        <!-- /top navigation -->
	<?php
	}


	function getFooter() {
	?>
		<!-- footer content -->
        <footer>
          	<div class="pull-right">
            	All Rights Reserved. TweetPal ©2017.
          	</div>
          	<div class="clearfix"></div>
        </footer>
        <!-- /footer content -->


        <!-- Olark -->
        <script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
        f[z]=function(){
        (a.s=a.s||[]).push(arguments)};var a=f[z]._={
        },q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
        f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
        0:+new Date};a.P=function(u){
        a.p[u]=new Date-a.p[0]};function s(){
        a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
        hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
        return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
        b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
        b.contentWindow[g].open()}catch(w){
        c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
        var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
        b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
        loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
        /* custom configuration goes here (www.olark.com/documentation) */
        olark.identify('8112-112-10-6541');/*]]>*/</script><noscript><a href="https://www.olark.com/site/8112-112-10-6541/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
	<?php
	}


	function getFooterIncludes() {
	?>
		<!-- jQuery -->
	    <script src="vendors/jquery/dist/jquery.min.js"></script>
	    <!-- Bootstrap -->
	    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	    <!-- FastClick -->
	    <script src="vendors/fastclick/lib/fastclick.js"></script>
	    <!-- NProgress -->
	    <script src="vendors/nprogress/nprogress.js"></script>
	    <!-- bootstrap-progressbar -->
	    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	    <!-- iCheck -->
	    <script src="vendors/iCheck/icheck.min.js"></script>
	    <!-- bootstrap-daterangepicker -->
	    <script src="vendors/moment/min/moment.min.js"></script>
	    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	    <!-- bootstrap-wysiwyg -->
	    <script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	    <script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	    <script src="vendors/google-code-prettify/src/prettify.js"></script>
	    <!-- jQuery Tags Input -->
	    <script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	    <!-- Switchery -->
	    <script src="vendors/switchery/dist/switchery.min.js"></script>
	    <!-- Select2 -->
	    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
	    <!-- Parsley -->
	    <script src="vendors/parsleyjs/dist/parsley.min.js"></script>
	    <!-- Autosize -->
	    <script src="vendors/autosize/dist/autosize.min.js"></script>
	    <!-- jQuery autocomplete -->
	    <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	    <!-- starrr -->
	    <script src="vendors/starrr/dist/starrr.js"></script>
	    <!-- Custom Theme Scripts -->
	    <script src="build/js/custom.min.js"></script>
	    <!-- PNotify -->
	    <script src="vendors/pnotify/dist/pnotify.js"></script>
	    <script src="vendors/pnotify/dist/pnotify.buttons.js"></script>
	    <script src="vendors/pnotify/dist/pnotify.nonblock.js"></script>

	    <script type="text/javascript">
	    	$(function() {
		    	// hide annoying pnotify test
		    	$(".dark").remove();
		    });
	    </script>
	<?php
	}
?>