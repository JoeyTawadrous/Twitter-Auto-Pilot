<script type="text/javascript">
    function ajaxFeedback(echoeddData) {
        if(echoeddData.indexOf("Success") != -1) {
            showSuccess("Configuration saved successfully!");
            return false;
        }
        else if(echoeddData.indexOf("Failure") != -1) {
            showError("Could not save configuration! Contact joeytawadrous@gmail.com");
            return false;
        }
    }

    function showError(text) {
        new PNotify({
            title: 'Oh No!',
            text: text,
            type: 'error',
            styling: 'bootstrap3'
        })
    }

    function showSuccess(text) {
        new PNotify({
            title: 'Success',
            text: text,
            type: 'success',
            styling: 'bootstrap3'
        })
    }


    function validateSignUpForm() {
        var fullName = document.getElementById('signup-form-full-name').value;
        var email = document.getElementById('signup-form-email').value;
        var password = document.getElementById('signup-form-password').value;

        if(fullName.length == 0
            || email.length == 0
            || password.length == 0) {
            showError("Please ensure all fields are filled in.");
            return false;
        }
        else if(email.indexOf("@") == -1) {
            showError("Please ensure email is filled in correctly.");
            return false;
        }
        else {
            $.ajax({
                url:  'utils/databaseUtils.php',
                type: 'post',
                data: {signUp: true, fullName: fullName, email: email, password: password},
                success: function(echoeddData) {
                    if(echoeddData.indexOf("User exists") != -1) {
                        showError("Username or email already exists. Please try again.");
                        return false;
                    }
                    else if(echoeddData.indexOf("User could not be registered") != -1) {
                        showError("We could not register you :( Please email joeytawadrous@gmail.com");
                        return false;
                    }
                    else if(echoeddData.indexOf("Success") != -1) {
                        window.location = "index.php";   
                    }
                }
            });
        }
    }
    

    function validateLoginForm() {
        var email = document.getElementById('login-form-email').value;
        var password = document.getElementById('login-form-password').value;

        if(email.length == 0
            || password.length == 0) {
            showError("Please ensure email & password are filled in correctly.");
            return false;
        }
        else if(email.indexOf("@") == -1) {
            showError("Please ensure email is filled in correctly.");
            return false;
        }
        else {
            $.ajax({
                url: 'utils/databaseUtils.php',
                type: 'post',
                data: {login: true, email: email, password: password},
                success: function(echoeddData) {
                    if(echoeddData.indexOf("Email & password combination does not exist") != -1) {
                        showError("Email & password combination does not exist.");
                        return false;
                    }
                    else if(echoeddData.indexOf("Success") != -1) {
                        window.location = "index.php";
                    }
                }
            });
        }
    }


    function validateApplyCouponForm() {
        var coupon = document.getElementById('coupon-input').value;

        if(coupon.length <= 5) {
            showError("Please ensure coupon code is filled in correctly.");
            return false;
        }
        else {
            $.ajax({
                type: "post",
                url: 'utils/databaseUtils.php',
                data: { applyCoupon: true, coupon: coupon },
                success: function(echoeddData) {
                    if(echoeddData.indexOf("Success") != -1) {
                        showSuccess("Your coupon has successfully been applied :)");
                        return false;
                    }
                    else if(echoeddData.indexOf("Failure") != -1) {
                        showError("Could not apply the coupon code supplied. Please ensure it is correct & try agian.");
                        return false;
                    }
                }
            });
        }
    }


    function logout() {
        $.ajax({
            url: 'utils/databaseUtils.php',
            type: 'post',
            data: {logout: true},
            success: function() {
                window.location = "login.php";
            }
        });
    }


    function createCookie(name, value, days) {
        var date, expires;
        if (days) {
            date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            expires = "; expires="+date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = name+"="+value+expires;
    }


    function getCookie(cookieName) {
        var myCookie = cookieName + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(myCookie) == 0) return c.substring(myCookie.length,c.length);
        }
        return "";
    }
</script>