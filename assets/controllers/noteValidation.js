
window.onload = validateNote();
window.onload = validateEditNote();

function validateNote() {
    $(document).ready(function () {

        $('#noteForm').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 6,
                    maxlength: 30,


                },
                content: {
                    required: true,
                    minlength: 10,
                    maxlength: 400,

                }
            },
            messages: {

                title: {
                    required: 'Proszę podać tytuł notatki.',
                    minlength: "Tytuł musi składać się z conajmniej 6 znaków.",
                    maxlength: "Tytuł może składać się z maksymalnie 30 znaków",
                },
                content: {
                    required: 'Proszę wpisać treść notatki.',
                    minlength: "Notatka musi składać się z conajmniej 10 znaków.",
                    maxlength: "Notatka może składać się z maksymalnie 400 znaków",
                },

            },

            errorPlacement: function (error, element) {

                if (element.attr('name') == 'title') {
                    error.appendTo('.titleError');
                }

                if (element.attr('name') == 'content') {
                    error.appendTo('.contentError');
                }


            }
        });

    });

}

function validateEditNote() {
    $(document).ready(function () {

        $('#editNote').validate({
            rules: {
                titleEdit: {
                    required: true,
                    minlength: 6,
                    maxlength: 30,


                },
                note: {
                    required: true,
                    minlength: 10,
                    maxlength: 400,

                }
            },
            messages: {

                titleEdit: {
                    required: 'Proszę podać tytuł notatki.',
                    minlength: "Tytuł musi składać się z conajmniej 6 znaków.",
                    maxlength: "Tytuł może składać się z maksymalnie 30 znaków",
                },
                NodeIterator: {
                    required: 'Proszę wpisać treść notatki.',
                    minlength: "Notatka musi składać się z conajmniej 10 znaków.",
                    maxlength: "Notatka może składać się z maksymalnie 400 znaków",
                },

            },

            errorPlacement: function (error, element) {

                if (element.attr('name') == 'title') {
                    error.appendTo('.titleEditError');
                }

                if (element.attr('name') == 'note') {
                    error.appendTo('.noteError');
                }


            }
        });

    });

}
