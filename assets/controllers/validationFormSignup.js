
window.onload = validateSignForm();


function validateSignForm() {
    $.validator.addMethod('validName',
        function (value, element, param) {

            if (value != '') {

                if (value.match(/^[A-Za-z]+$/)) {

                    return true;
                }
            }
            return false;
        },

        'Nazwa użytkownika może zawierać tylko litery.'
    );


    /**
     * Add jQuery Validation plugin method for a valid password
     *
     * Valid passwords contain at least one letter and one number.
     */
    $.validator.addMethod('validPassword',
        function (value, element, param) {

            if (value != '') {
                if (value.match(/.*[a-z]+.*/i) == null) {
                    return false;
                }
                if (value.match(/.*\d+.*/) == null) {
                    return false;
                }
            }

            return true;
        },
        'Hasło musi zawierać przynajmniej jedną literę i jedną cyfrę'
    );


    $(document).ready(function () {

        $('#formSignup').validate({
            rules: {
                username: {
                    required: true,
                    minlength: 2,
                    maxlength: 20,
                    validName: true,
                    // remote: '/account/validate-username'
                },
                email: {
                    required: true,
                    email: true,
                    //  remote: '/account/validate-email'
                },
                plainPassword: {
                    required: true,
                    minlength: 6,
                    validPassword: true
                }
            },
            /*  messages: {
                  email: {
                      remote: 'Email already taken!'
                  },
                  username: {
                      remote: 'Username already taken!'
                  }
              },*/
            errorPlacement: function (error, element) {

                if (element.attr('name') == 'username') {
                    error.appendTo('.nameError');
                }

                if (element.attr('name') == 'email') {
                    error.appendTo('.emailError');
                }
                if (element.attr('name') == 'plainPassword') {
                    error.appendTo('.passwordError');
                }

            }
        });

    });

}
