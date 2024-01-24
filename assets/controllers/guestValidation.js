window.onload = validateGuest();

function validateGuest() {

    $(document).ready(function () {

        $('#guestForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 6,
                    maxlength: 50
                }
            },
            messages: {

                priceOfPodcategory: {
                    required: 'Proszę podać imię i nazwisko gościa.',
                    minlength: 'Imię gościa powinno składać się z przynajmniej 6 znaków.',
                    maxlength: 'Imię gościa powinno składać się z maksymalnie 50 znaków.',
                }


            },
            errorPlacement: function (error, element) {


                if (element.attr('name') == 'name') {
                    error.appendTo('.guestError');
                }


            }
        });

    });

}
