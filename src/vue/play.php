<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_SESSION["newGame"])) {
        $_SESSION["minutes"] = ltrim($_POST["minutes"], '0');
        if ($_SESSION["minutes"] < 10) {
            $_SESSION["minutes"] = "0" . $_SESSION["minutes"];
        }
        $_SESSION["secondes"] = ltrim($_POST["secondes"], '0');
        if ($_SESSION["secondes"] < 10) {
            $_SESSION["secondes"] = "0" . $_SESSION["secondes"];
        }
        $rawCompanies = $_POST["companiesName"];
        $companiesNumber = count($rawCompanies);
        $maxPoints = 10000;
        $companyPoint = $maxPoints / $companiesNumber;
        foreach ($rawCompanies as $key => $company) {
            $companies[$key]["name"] = $company;
            $companies[$key]["point"] = $companyPoint;
        }
        if (!empty($companies)) $_SESSION["companies"] = $companies;
        $_SESSION["newGame"] = 1;
    } else {
        $_SESSION["companies"][$_POST["winner"]]["point"] += $_POST["bet"];
        $_SESSION["companies"][$_POST["looser"]]["point"] -= $_POST["bet"];
        foreach ($_SESSION["companies"] as $key => $company) {
            if ($_SESSION["companies"][$key]["point"] <= 0) {
                if (count($_SESSION["companies"]) === 2) {
                    unset($_SESSION["lastDeletedCompany"]);
                    $_SESSION["winner"]["name"] = $_SESSION["companies"][$_POST["winner"]]["name"];
                    $_SESSION["winner"]["point"] = $_SESSION["companies"][$_POST["looser"]]["point"];
                } else if (count($_SESSION["companies"]) > 2) {
                    $_SESSION["lastDeletedCompany"] = $_SESSION["companies"][$key]["name"];
                    unset($_SESSION["companies"][$key]);
                }
            }
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<?php
$page_name = "Play";
require_once "../templates/header.php";
?>

<form id="playForm" action="./duel.php" method="post" class="flex flex-col justify-center items-center gap-2 w-full">
    <div id="companies" class="flex flex-col gap-2 w-full">
        <?php if (!empty($_SESSION["companies"])) foreach ($_SESSION["companies"] as $key => $company) { ?>
            <div class="company border-4 border-ppred rounded-2xl p-3 w-full flex justify-between">
                <input type="hidden" name="company_keys[<?php echo $key ?>]" value="0">
                <p class="m-0 p-0 text-2xl"><?= $_SESSION["companies"][$key]["name"]; ?></p>
                <p class="m-0 p-0 text-2xl"><?= $_SESSION["companies"][$key]["point"]; ?></p>
            </div>
        <?php } ?>
    </div>
    <p id="duelButton"
       class="m-0 mt-5 rounded-full py-4 w-2/3 text-center bg-ppblue text-ppyellow text-2xl border-4 border-ppred">Duel
        !</p>
</form>

<div class="fixed z-10 inset-0 hidden m-12" id="companyDeletedModal">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-md">
            <div class="text-center">
                <div class="flex justify-end">
                    <button onclick="closeCompanyDeletedModal()"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <h3 class="text-lg font-semibold mt-2">Société en Faillite</h3>
                <p>La société <?php if (!empty($_SESSION["lastDeletedCompany"])) echo $_SESSION["lastDeletedCompany"] ?>
                    à perdu tous ses clients avec ses idées de merde.</p>
            </div>
        </div>
    </div>
</div>

<div class="fixed z-10 inset-0 hidden m-12" id="winnerModal">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-md">
            <div class="text-center">
                <div class="flex justify-end">
                    <button onclick="closeWinnerModal(); restartGame();"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <h3 class="text-lg font-semibold mt-2">Une société a démonté les autres !</h3>
                <p>La société <?php if (!empty($_SESSION["winner"]["name"])) echo $_SESSION["winner"]["name"] ?> a
                    écrasé la concurrence et se retrouve haïs de ses camarades.</p>
            </div>
        </div>
    </div>
</div>

<script>

    <?php if (!empty($_SESSION["winner"]["name"])) { ?>
    openWinnerModal();
    <?php } else if (!empty($_SESSION["lastDeletedCompany"])) { ?>
    openCompanyDeletedModal();
    <?php unset($_SESSION["lastDeletedCompany"]);} ?>

    function openCompanyDeletedModal() {
        document.getElementById('companyDeletedModal').classList.remove('hidden');
    }

    function closeCompanyDeletedModal() {
        document.getElementById('companyDeletedModal').classList.add('hidden');
    }

    function openWinnerModal() {
        document.getElementById('winnerModal').classList.remove('hidden');
    }

    function closeWinnerModal() {
        document.getElementById('winnerModal').classList.add('hidden');
    }

    function restartGame() {
        window.location.href = "../controller/newgame.php";
    }

    $(document).ready(function () {
        let selectedNumber = 0;
        const maxSelections = 2;

        $('.company').click(function () {
            let hiddenInput = $(this).find('input[type="hidden"]');

            if ($(this).hasClass('border-ppblue')) {
                $(this).removeClass('border-ppblue');
                $(this).addClass('border-ppred');
                hiddenInput.val('0');
                selectedNumber--;
            } else {
                if (selectedNumber < maxSelections) {
                    $(this).removeClass('border-ppred');
                    $(this).addClass('border-ppblue');
                    hiddenInput.val('1');
                    selectedNumber++;
                }
            }
        });

        $('#duelButton').on('click', function (event) {
            event.preventDefault();
            if (selectedNumber === maxSelections) {
                $("#playForm").submit();
            } else {
                alert("You must select 2 companies");
            }
        });
    });
</script>


<?php
require_once "../templates/footer.php";
?>
