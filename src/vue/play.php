<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_SESSION["newGame"])){
        session_start();
        $_SESSION["minutes"] = $_POST["minutes"];
        $_SESSION["secondes"] = $_POST["secondes"];
        $rawCompanies = $_POST["companiesName"];
        $companiesNumber = count($rawCompanies);
        $maxPoints = 30000;
        $companyPoint = $maxPoints / $companiesNumber;
        foreach ($rawCompanies as $key => $company) {
            $companies[$key]["name"] = $company;
            $companies[$key]["point"] = $companyPoint;
        }
        if (!empty($companies)) $_SESSION["companies"] = $companies;
        $_SESSION["newGame"] = 1;
    }
}
?>

<?php
$page_name = "Play";
require_once "../templates/header.php";
?>

<form id="playForm" action="./duel.php" class="flex flex-col justify-center items-center gap-2 w-full">
    <div id="companies" class="flex flex-col gap-2 w-full">
        <?php if (!empty($_SESSION["companies"])) foreach ($_SESSION["companies"] as $key => $company) { ?>
            <div class="company border-4 border-ppred rounded-2xl p-3 w-full flex justify-between">
                <input type="hidden" name="<?php echo $key ?>" value="0">
                <p class="m-0 p-0 text-2xl"><?= $_SESSION["companies"][$key]["name"]; ?> </p>
                <p class="m-0 p-0 text-2xl"><?= $_SESSION["companies"][$key]["point"]; ?> </p>
            </div>
        <?php } ?>
    </div>
    <p id="duelButton" class="m-0 mt-5 rounded-full py-4 w-2/3 text-center bg-ppblue text-ppyellow text-2xl border border-ppred">Duel !</p>
</form>

<script>
    $(document).ready(function(){
        let selectedNumber = 0;
        const maxSelections = 2;

        $('.company').click(function(){
            let hiddenInput = $(this).find('input[type="hidden"]');

            if($(this).hasClass('border-ppblue')){
                $(this).removeClass('border-ppblue');
                $(this).addClass('border-ppred');
                hiddenInput.val('0');
                selectedNumber--;
            } else {
                if(selectedNumber < maxSelections){
                    $(this).removeClass('border-ppred');
                    $(this).addClass('border-ppblue');
                    hiddenInput.val('1');
                    selectedNumber++;
                }
            }
        });

        $('#duelButton').on('click', function(event) {
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
