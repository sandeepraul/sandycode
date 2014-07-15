$(document).ready(function () {

    $.validator.addMethod("letterOnly", function(value, element) {
            return this.optional(element) || /^[a-z\-]+$/i.test(value);
    }, "Only alphabets allowed.");

    $("#register").validate({
        debug: false,
        rules: {
            firstName: {
                required: true,
                letterOnly: true
            },
            
            lastName: {
                required: true,
                letterOnly: true
            },
            
            mobileNumber: {
                required: true,
                number: true,
                minlength: 10
            },
            
            email: {
                required: false,
                email: true
            },
            
            otherContactNumber: {
                required: false,
                number: true
            }
        },
        messages: {
            
            firstName: {
                required: "Please enter your first name.",
                letterOnly: "First name should contain only alphabets."
            },
            
            lastName: {
                required: "Please enter your last name.",
                letterOnly: "Last name should contain only alphabets."
            },
            
            mobileNumber: {
               required: "Please enter your mobile number.",
               number: "Mobile number should numeric.",
               minlength: "Mobile number should be of length {0}"
            },
            
            email: {
                email: "Please enter a valid email address."
            },
            
            otherContactNumber: {
               number: "Other Contact number should numeric."
            }
        },
        errorPlacement: function (error, element) {
            error.insertBefore(element);
        },
        submitHandler: function (form) {
            $("#submit").prop("disabled", true); //disable to prevent multiple submits
            form.submit(); 
        } 
    });
});

