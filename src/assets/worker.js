let timerInterval;

function startTimerWorker(minutes, seconds) {
    let timer = minutes * 60 + seconds - 1;

    timerInterval = setInterval(function () {
        let minutes = Math.floor(timer / 60);
        let seconds = timer % 60;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        postMessage({ minutes, seconds });

        if (--timer < 0) {
            timer = 0;
            clearInterval(timerInterval);
            postMessage('TimerExpired');
        }
    }, 1000);
}

function stopTimerWorker() {
    clearInterval(timerInterval);
}

// Écouter les messages du script principal
self.onmessage = function (e) {
    if (e.data.command === 'start') {
        let minutes = e.data.minutes;
        let seconds = e.data.seconds;
        startTimerWorker(minutes, seconds);
    } else if (e.data === 'stop') {
        stopTimerWorker();
    }
};