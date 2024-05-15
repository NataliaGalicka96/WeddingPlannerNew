document.addEventListener('DOMContentLoaded', (event) => {
    let isCountdownRunning = true;

    function makeTimer() {
        if (!isCountdownRunning) {
            return;
        }

        let weddingDate = document.getElementById('time').innerHTML;

        let year = weddingDate.substring(0, 4);
        let month = weddingDate.substring(5, 7) - 1; // Subtract 1 to adjust for zero-indexed months
        let day = weddingDate.substring(8, 10);
        let hour = weddingDate.substring(11, 13);
        let minutesOfWeddingDate = weddingDate.substring(14, 16);
        let secondsOfWeddingDate = weddingDate.substring(17, 19);

        let daysToWedding = document.getElementById("days");
        let hourToWedding = document.getElementById("hours");
        let minutesToWedding = document.getElementById("minutes");
        let secondToWedding = document.getElementById("seconds");

        var endTime = new Date(year, month, day, hour, minutesOfWeddingDate, secondsOfWeddingDate);
        endTime = (Date.parse(endTime) / 1000);

        var now = new Date();
        now = (Date.parse(now) / 1000);

        var timeLeft = endTime - now;

        console.log(timeLeft);

        let date = weddingDate.substring(0, 10);
        if (timeLeft <= 0) {
            document.getElementById('timer').innerHTML = `Twój ślub odbył się ${date}`;
            isCountdownRunning = false;
            return;
        } else {
            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
            var seconds = Math.floor(timeLeft % 60);

            if (hours < 10) { hours = "0" + hours; }
            if (minutes < 10) { minutes = "0" + minutes; }
            if (seconds < 10) { seconds = "0" + seconds; }

            daysToWedding.innerHTML = days + "<span>Dni</span>";
            hourToWedding.innerHTML = hours + "<span>Godzin</span>";
            minutesToWedding.innerHTML = minutes + "<span>Minut</span>";
            secondToWedding.innerHTML = seconds + "<span>Sekund</span>";
        }
    }

    setInterval(function () { makeTimer(); }, 1000);
});
