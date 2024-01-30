
window.onload = validateTask();

function validateTask() {
    $(document).ready(function () {

        $('#checkListForm').validate({
            rules: {
                category: {
                    required: true,



                },
                title: {
                    required: true,
                    minlength: 10,
                    maxlength: 100,

                }
            },
            messages: {

                category: {
                    required: 'Proszę wybrać kategorię.',

                },
                title: {
                    required: 'Proszę wpisać treść zadania.',
                    minlength: "Treść zadania musi składać się z conajmniej 10 znaków.",
                    maxlength: "Treść zadania może składać się z maksymalnie 100 znaków",
                },

            },

            errorPlacement: function (error, element) {

                if (element.attr('name') == 'category') {
                    error.appendTo('.categoryError');
                }

                if (element.attr('name') == 'title') {
                    error.appendTo('.titleError');
                }


            }
        });

    });

}

