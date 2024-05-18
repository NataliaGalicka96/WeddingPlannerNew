let tdBudget = document.querySelector('td#Budget');
let tdAlreadyPaid = document.querySelector('td#paid');
let tdToSpend = document.querySelector('td#toSpend');


let budget = (parseFloat(document.querySelector('td#Budget').innerHTML)).toFixed(2);
let alreadyPaid = (parseFloat(document.querySelector('td#paid').innerHTML)).toFixed(2);


let difference = (budget - alreadyPaid).toFixed(2);
console.log('Różnica'.difference);

let spend = isNaN(difference) ? "0.00" : difference;

let newBudget2 = isNaN(budget) ? "0.00" : budget;

let newAlreadyPaid2 = isNaN(alreadyPaid) ? "0.00" : alreadyPaid;

let newBudget = newBudget2.replace('.', ',');
let newPaid = newAlreadyPaid2.replace('.', ',');
let newToSpend = spend.replace('.', ',');

console.log('budget'.newBudget);

tdBudget.innerHTML = newBudget + " zł";
tdAlreadyPaid.innerHTML = newPaid + " zł";
tdToSpend.innerHTML = newToSpend + " zł";

let div = document.getElementById('comment');
let span = document.createElement('span');

if (spend >= 0) {

    span.innerHTML = "Gratulacje, dobrze zarządzasz swoim budżetem!";
    div.classList.add('alert-success');
    div.appendChild(span);

} else {
    span.innerHTML = "Uważaj, przekraczasz ustalony budżet!";
    div.classList.add('alert-danger');
    div.appendChild(span);

}



let tdleftToPay = document.querySelectorAll('td#leftToPay');

let inputPrice = document.querySelectorAll('input#price');
let inputSpend = document.querySelectorAll('input#alreadySpend');



for (let i = 0; i < tdleftToPay.length; i++) {


    let difference = (parseFloat(inputPrice[i].value) - (parseFloat(inputSpend[i].value))).toFixed(2);
    let diff = isNaN(difference) ? "" : difference;

    console.log(diff);


    tdleftToPay[i].innerHTML = diff.replace('.', ',');

    let check = document.createElement('i');
    check.classList.add('fa-solid');
    check.classList.add('fa-circle-check');

    console.log(check);




    if (diff == "0.00") {
        tdleftToPay[i].innerHTML = "";
        tdleftToPay[i].style.color = "green";
        tdleftToPay[i].appendChild(check);
    } else if (diff > 0) {
        tdleftToPay[i].style.color = "red";
    } else if (diff < 0) {
        tdleftToPay[i].style.color = "orange";
    }

}


tdSummaryPrice = document.querySelectorAll("td[id='price']");
tdSummarySpend = document.querySelectorAll("td[id='alreadySpend']");
tdSummaryLeft = document.querySelectorAll("td[id='left']");



for (let i = 0; i < tdSummaryLeft.length; i++) {



    let difference = (parseFloat(tdSummaryPrice[i].innerHTML) - (parseFloat(tdSummarySpend[i].innerHTML))).toFixed(2);
    console.log(difference);

    let price = (tdSummaryPrice[i].innerHTML).replace('.', ',');
    let spend = (tdSummarySpend[i].innerHTML).replace('.', ',');


    tdSummaryLeft[i].innerHTML = difference.replace('.', ',');
    tdSummaryPrice[i].innerHTML = price;
    tdSummarySpend[i].innerHTML = spend;



    if (difference == 0) {
        tdSummaryLeft[i].style.color = "green";

    } else if (difference > 0) {
        tdSummaryLeft[i].style.color = "red";
    } else if (difference < 0) {
        tdSummaryLeft[i].style.color = "orange";
    }

}
