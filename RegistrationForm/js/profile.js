$(document).ready(function() {
    $.ajax({
        url: 'php/profile.php',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                var profile = response.profile;

                $('#name').val(profile.name);
                $('#email').val(profile.email);
                $('#age').val(profile.age);
                $('#dob').val(profile.dob);
                $('#contact').val(profile.contact);
            } else {
                alert('Error retrieving profile data.');
            }
        },
        error: function(error) {
            console.error('Profile retrieval error:', error);
        }
    });

    $('#updateForm').on('submit', function(e) {
        e.preventDefault();

        var age = $('#age').val();
        var dob = $('#dob').val();
        var contact = $('#contact').val();

        $.ajax({
            url: 'php/profile.php',
            method: 'POST',
            data: {
                update: true,
                age: age,
                dob: dob,
                contact: contact
            },
            success: function(response) {
                if (response.success) {
                    alert('Profile updated successfully.');
                } else {
                    alert('Profile update failed: ' + response.message);
                }
            },
            error: function(error) {
                console.error('Profile update error:', error);
            }
        });
    });
});
