
window.onload = validateExpenses();
window.onload = validatePrice();


function validateExpenses() {



    $(document).ready(function () {

        $('#expenseForm').validate({
            rules: {
                category: {
                    required: true,

                },
                expenseName: {
                    required: true,
                    minlength: 10,
                    maxlength: 100,

                },
                price: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 999999.99,
                    step: 0.01


                },
                alreadyPaid: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 999999.99,
                    step: 0.01

                }
            },
            messages: {
                category: {
                    required: 'Proszę wybrać kategorię!'
                },
                expenseName: {
                    required: 'Proszę wpisać nazwę wydatku!',
                    minlength: 'Nazwa wydatku powinna składać się z minimum 10 znaków.',
                    maxlength: "Nazwa wydatku powinna składać się z maksymalnie 100 znaków.",

                },
                price: {
                    required: 'Proszę podać kwotę.',
                    min: 'Kwota musi mieścić się w przedziale od 0 do 10000000 zł.',
                    max: 'Kwota musi mieścić się w przedziale od 0 do 10000000 zł.',
                },
                alreadyPaid: {
                    required: 'Proszę podać kwotę.',
                    min: 'Kwota musi mieścić się w przedziale od 0 do 10000000 zł.',
                    max: 'Kwota musi mieścić się w przedziale od 0 do 10000000 zł.',
                }

            },
            errorPlacement: function (error, element) {

                if (element.attr('name') == 'category') {
                    error.appendTo('.categoryError');
                }

                if (element.attr('name') == 'expenseName') {
                    error.appendTo('.expenseNameError');
                }
                if (element.attr('name') == 'price') {
                    error.appendTo('.priceError');
                }
                if (element.attr('name') == 'alreadyPaid') {
                    error.appendTo('.alreadyPaidError');
                }

            }
        });

    });

}


function validatePrice() {

    $(document).ready(function () {

        $('#addPriceForm').validate({
            rules: {
                priceOfPodcategory: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 999999.99,
                    step: 0.01
                }
            },
            messages: {

                priceOfPodcategory: {
                    required: 'Proszę podać kwotę.',
                    min: 'Kwota musi mieścić się w przedziale od 0 do 10000000 zł.',
                    max: 'Kwota musi mieścić się w przedziale od 0 do 10000000 zł.',
                }


            },
            errorPlacement: function (error, element) {


                if (element.attr('name') == 'priceOfPodcategory') {
                    error.appendTo('.updatePriceError');
                }


            }
        });

    });

}
