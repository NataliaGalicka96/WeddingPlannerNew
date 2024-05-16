
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
                    required: 'Proszę wybrać kategorię',

                },
                title: {
                    required: 'Proszę wpisać treść zadania',
                    minlength: "Treść zadania musi składać się z conajmniej 10 znaków",
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


const checkboxes = document.querySelectorAll('.task-checkbox');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const taskId = this.value;
        switchStatusWithAjax(taskId);
    });
});

function switchStatusWithAjax(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/check/list/switch-status/${id}`, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log('Status zadania został zmieniony.');
                // Możesz dodać kod do aktualizacji interfejsu użytkownika bez przeładowywania strony
            } else {
                console.error('Wystąpił błąd podczas zmiany statusu zadania.');
            }
        }
    };
    xhr.send();
}

