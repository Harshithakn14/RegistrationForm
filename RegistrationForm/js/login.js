$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            url: 'php/login.php',
            method: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                if (response.success) {
                    alert('Login successful. Redirecting to profile...');
                    window.location.href = response.redirect;
                } else {
                    alert('Login failed: ' + response.message);
                }
            },
            error: function(error) {
                console.error('Login error:', error);
            }
        });
    });
});
