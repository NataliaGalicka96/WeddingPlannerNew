

/*

function czasDoWydarzenia(year, month, day, hour, minutes) {
    var aktualnyCzas = new Date();
    var dataWydarzenia = new Date(year, month, day, hour, minutes);
    
    var pozostaleDni = 
    var pozostalyCzas = dataWydarzenia.getTime() - aktualnyCzas.getTime();

    if (pozostalyCzas > 0) {

        var s = pozostalyCzas / 1000;   // sekundy
        var min = s / 60;               // minuty
        var h = min / 60;               // godziny



        var sLeft = Math.floor(s % 60);    // pozostało sekund    
        var minLeft = Math.floor(min % 60); // pozostało minut
        var hLeft = Math.floor(h);          // pozostało godzin

        if (minLeft < 10)
            minLeft = "0" + minLeft;
        if (sLeft < 10)
            sLeft = "0" + sLeft;
        return "Do wesela pozostały: </br>" + hLeft + "h " + minLeft + "m " + sLeft + "s";
    }
    else
        return "Zdarzenie miało już miejsce na naszym globie, to już jest historia i już nie powróci!";
}

window.onload = function () {

    idElement = "time";
    document.getElementById(idElement).innerHTML = czasDoWydarzenia(year, month, day, hour, minutes);
    setInterval("document.getElementById(idElement).innerHTML = czasDoWydarzenia(year, month, day, hour, minutes)", 1000);

};

*/

function makeTimer() {

    let weddingDate = document.getElementById('time').innerHTML;
    console.log(weddingDate);

    let year = weddingDate.substring(0, 4);
    let month = weddingDate.substring(5, 7);
    let day = weddingDate.substring(8, 11);
    let hour = weddingDate.substring(11, 13);
    let minutesOfWeddingDate = weddingDate.substring(14, 16);
    let secondsOfWeddingDate = weddingDate.substring(17, 19);

    let daysToWedding = document.getElementById("days");
    let hourToWedding = document.getElementById("hours");
    let minutesToWedding = document.getElementById("minutes");
    let secondToWedding = document.getElementById("seconds");
    //console.log(daysToWedding);

    var endTime = new Date(year, month, day, hour, minutesOfWeddingDate, secondsOfWeddingDate);
    endTime = (Date.parse(endTime) / 1000);
    console.log(endTime);

    var now = new Date();
    now = (Date.parse(now) / 1000);

    var timeLeft = endTime - now;

    var days = Math.floor(timeLeft / 86400);
    console.log(days);
    var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
    var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
    var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

    if (hours < "10") { hours = "0" + hours; }
    if (minutes < "10") { minutes = "0" + minutes; }
    if (seconds < "10") { seconds = "0" + seconds; }

    daysToWedding.innerHTML = days + "<span>Dni</span>";
    hourToWedding.innerHTML = hours + "<span>Godzin</span>";
    minutesToWedding.innerHTML = minutes + "<span>Minut</span>";
    secondToWedding.innerHTML = seconds + "<span>Sekund</span>";
}

setInterval(function () { makeTimer(); }, 1000)

/*
window.onload = function () {

    idElement = "timer";
    document.getElementById(idElement).innerHTML = makeTimer();
    setInterval("document.getElementById(idElement).innerHTML = makeTimer()", 1000);

};

*/