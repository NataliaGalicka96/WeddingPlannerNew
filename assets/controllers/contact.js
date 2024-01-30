// FETCH

fetch('check_list/fetch')
    .then((response) => response.json())
    .then((data) => console.log(data));