<?php
    include_once("utils/utils.php");
    include_once("utils/validation.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php getHeader() ?>
        
        <!-- Animate.css -->
        <link href="vendors/animate.css/animate.min.css" rel="stylesheet">
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <p>TweetPal.io allows you to automate common Twitter activities such as following & unfollowing Twitter accounts, following users back, favoriting tweets that match a search query, sending messages to users who are following you and much much more...</p>
                        <form>
                            <h1>Login Form</h1>
                            <div class="alert alert-danger" id="login-form-feedback" style="display:none"></div>
                            <div>
                                <input type="text" class="form-control" id="login-form-email" placeholder="Email" required="" />
                            </div>
                            <div>
                                <input type="password" class="form-control" id="login-form-password" placeholder="Password" required="" />
                            </div>
                            <div>
                                <a class="btn btn-default submit" onclick="validateLoginForm()">Log in</a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">New to site?
                                    <a href="#signup" class="to_register"> Create Account </a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><img src="images/twitter.png" alt="" style="width: 48px"> TweetPal</h1>
                                    <p>All Rights Reserved. TweetPal ©2017.</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>

                <div id="register" class="animate form registration_form">
                    <section class="login_content">
                        <form>
                            <h1>Create Account</h1>
                            <div class="alert alert-danger" id="signup-form-feedback" style="display:none"></div>
                            <div>
                                <input type="text" class="form-control" id="signup-form-full-name" placeholder="Full Name" required="" />
                            </div>
                            <div>
                                <input type="email" class="form-control" id="signup-form-email" placeholder="Email" required="" />
                            </div>
                            <div>
                                <input type="password" class="form-control" id="signup-form-password" placeholder="Password" required="" />
                            </div>
                            <div>
                                <a class="btn btn-default submit" onclick="validateSignUpForm()" >Submit</a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">Already a member ?
                                    <a href="#signin" class="to_register"> Log in </a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div><h1>
                                    <img src="images/twitter.png" alt="" style="width: 48px"> TweetPal</h1>
                                    <p>All Rights Reserved. TweetPal ©2017.</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>

        <?php getFooterIncludes() ?>
    </body>
</html>