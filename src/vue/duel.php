<?php
session_start();
$duelist = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['company_keys']) && is_array($_POST['company_keys'])) {
        foreach ($_POST['company_keys'] as $companyId => $status) {
            if ($status == 1) {
                $duelist[] = $companyId;
            }
        }
    }
}
$minutes = $_SESSION["minutes"];
$secondes = $_SESSION["secondes"];
$timer = $minutes . ":" . $secondes;
?>

<?php
$page_name = "Duel";
require_once "../templates/header.php";
?>

<form id="duelForm" action="./play.php" method="post" class="flex flex-col justify-center items-center gap-2 w-full">

    <h1 id="roundNumber" class="text-4xl">Round 1</h1>

    <div id="companies" class="flex flex-col items-center gap-2 w-full">

        <div id="company0" class="company border-4 border-ppred rounded-2xl p-3 w-full flex justify-between">
            <input type="hidden" value="<?= $duelist[0] ?>">
            <p class="m-0 p-0 text-2xl"><?= $_SESSION["companies"][$duelist[0]]["name"]; ?></p>
            <p class="m-0 p-0 text-2xl"><?= $_SESSION["companies"][$duelist[0]]["point"]; ?></p>
        </div>

        <div class="flex justify-center w-full">
            <input id="winner" type="hidden" name="winner">
            <input id="looser" type="hidden" name="looser">
            <input id="bet" type="hidden" name="bet">
            <div id="timerDisplay" class="text-2xl"><?= $timer ?></div>
        </div>

        <div id="company1" class="company border-4 border-ppred rounded-2xl p-3 w-full flex justify-between">
            <input type="hidden" value="<?= $duelist[1] ?>">
            <p class="m-0 p-0 text-2xl"><?= $_SESSION["companies"][$duelist[1]]["name"]; ?></p>
            <p class="m-0 p-0 text-2xl"><?= $_SESSION["companies"][$duelist[1]]["point"]; ?></p>
        </div>

        <div id="betButton" class=" justify-between gap-2 w-full hidden">
            <div id="bet250" class="company border-4 border-ppred rounded-2xl p-3 flex-1">
                <p class="m-0 p-0 text-2xl text-center">250</p>
            </div>

            <div id="bet500" class="company border-4 border-ppred rounded-2xl p-3 flex-1">
                <p class="m-0 p-0 text-2xl text-center">500</p>
            </div>

            <div id="bet1000" class="company border-4 border-ppred rounded-2xl p-3 flex-1">
                <p class="m-0 p-0 text-2xl text-center">1000</p>
            </div>

            <div id="bet2000" class="company border-4 border-ppred rounded-2xl p-3 flex-1">
                <p class="m-0 p-0 text-2xl text-center">2000</p>
            </div>
        </div>

        <p id="debateButton"
           class="m-0 rounded-full py-4 w-2/3 text-center bg-ppblue text-ppyellow text-2xl border-4 border-ppred">
            Start timer !</p>
        <p id="duelButton"
           class="m-0 rounded-full py-4 w-2/3 text-center bg-ppblue text-ppyellow text-2xl border-4 border-ppred hidden">
            Confirm Winner !</p>
    </div>
</form>

<script>
    $(document).ready(function () {
        let selectedNumber = 0;
        let selectedBet = 0;
        let roundPlayed = 0;
        let runningTimer = false;
        let roundNumber = $("#roundNumber");
        let winner = $("#winner");
        let looser = $("#looser");
        let company0 = $("#company0")
        let company1 = $("#company1")
        let company0val = company0.find('input[type="hidden"]').val();
        let company1val = company1.find('input[type="hidden"]').val();
        let bet = $("#bet");
        let bet250 = $("#bet250");
        let bet500 = $("#bet500");
        let bet1000 = $("#bet1000");
        let bet2000 = $("#bet2000");
        let debateButton = $('#debateButton');
        let duelButton = $('#duelButton');
        let betButton = $('#betButton');
        let timerDisplay = $('#timerDisplay');
        let duelForm = $('#duelForm');

        let timerWorker = new Worker('../assets/worker.js');
        let minutes = <?= $_SESSION["minutes"] ?>;
        let seconds = <?= $_SESSION["secondes"] ?>;
        let timer = "<?= $timer ?>";

        company0.click(function () {
            winner.val(company0val)
            looser.val(company1val)
            company0.removeClass('border-ppred');
            company0.addClass('border-ppblue');
            company1.removeClass('border-ppblue');
            company1.addClass('border-ppred');
            selectedNumber = 1;
        })

        company1.click(function () {
            winner.val(company1val)
            looser.val(company0val)
            company1.removeClass('border-ppred');
            company1.addClass('border-ppblue');
            company0.removeClass('border-ppblue');
            company0.addClass('border-ppred');
            selectedNumber = 1;
        })

        bet250.click(function () {
            bet.val(250)
            bet250.removeClass('border-ppred');
            bet250.addClass('border-ppblue');
            bet500.removeClass('border-ppblue');
            bet500.addClass('border-ppred');
            bet1000.removeClass('border-ppblue');
            bet1000.addClass('border-ppred');
            bet2000.removeClass('border-ppblue');
            bet2000.addClass('border-ppred');
            selectedBet = 1;
        })

        bet500.click(function () {
            bet.val(500)
            bet500.removeClass('border-ppred');
            bet500.addClass('border-ppblue');
            bet250.removeClass('border-ppblue');
            bet250.addClass('border-ppred');
            bet1000.removeClass('border-ppblue');
            bet1000.addClass('border-ppred');
            bet2000.removeClass('border-ppblue');
            bet2000.addClass('border-ppred');
            selectedBet = 1;
        })

        bet1000.click(function () {
            bet.val(1000)
            bet1000.removeClass('border-ppred');
            bet1000.addClass('border-ppblue');
            bet500.removeClass('border-ppblue');
            bet500.addClass('border-ppred');
            bet250.removeClass('border-ppblue');
            bet250.addClass('border-ppred');
            bet2000.removeClass('border-ppblue');
            bet2000.addClass('border-ppred');
            selectedBet = 1;
        })

        bet2000.click(function () {
            bet.val(1500)
            bet2000.removeClass('border-ppred');
            bet2000.addClass('border-ppblue');
            bet500.removeClass('border-ppblue');
            bet500.addClass('border-ppred');
            bet1000.removeClass('border-ppblue');
            bet1000.addClass('border-ppred');
            bet250.removeClass('border-ppblue');
            bet250.addClass('border-ppred');
            selectedBet = 1;
        })

        duelButton.on('click', function (event) {
            event.preventDefault();
            if (selectedNumber === 1 && selectedBet === 1) {
                duelForm.submit();
            } else {
                alert("You must select 1 bet and 1 companies");
            }
        });

        debateButton.click(function () {
            if (runningTimer === false) {
                timerWorker.postMessage({ command: 'start', minutes: minutes, seconds: seconds });
                runningTimer = true;
                debateButton.text("Finish round !");
            } else {
                timerWorker.postMessage('stop');
                roundPlayed++;
                runningTimer = false;
                timerDisplay.text(timer);
                if (roundPlayed === 1) {
                    roundNumber.text("Round 2");
                    debateButton.text("Start timer !");
                } else if (roundPlayed === 2) {
                    debateButton.addClass("hidden");
                    duelButton.removeClass("hidden");
                    timerDisplay.text("Who win ?");
                    betButton.removeClass("hidden");
                    betButton.addClass("flex");
                    roundNumber.addClass("hidden");
                }
            }
        });

        timerWorker.onmessage = function (e) {
            if (typeof e.data === 'object') {
                timerDisplay.text(e.data.minutes + ':' + e.data.seconds);
            } else if (e.data === 'TimerExpired') {
                roundPlayed++;
                runningTimer = false;
                timerDisplay.text(timer);
                if (roundPlayed === 1) {
                    roundNumber.text("Round 2");
                    debateButton.text("Start timer !");
                } else if (roundPlayed === 2) {
                    debateButton.addClass("hidden");
                    duelButton.removeClass("hidden");
                    timerDisplay.text("Who win ?");
                    betButton.removeClass("hidden");
                    betButton.addClass("flex");
                    roundNumber.addClass("hidden");
                }
                console.log('Le minuteur a expiré.');
            }
        };

        timerWorker.onerror = function (error) {
            console.error('Worker error: ' + error.message);
        };

    });
</script>


<?php
require_once "../templates/footer.php";
?>


