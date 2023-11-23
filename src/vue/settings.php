<?php
session_start();
if (!empty($_SESSION["companies"])) {
    header("Location: ./play.php");
    exit();
}
$page_name = "Settings";
require_once "../templates/header.php";
?>

<form action="./play.php" method="post" class="flex flex-col justify-center items-center gap-2 w-full">

    <div class="border-4 border-ppblue rounded-2xl p-3 w-full flex justify-center">
        <label class="text-3xl">
            Debate Time :
            <input type="number" id="minutes" name="minutes" min="0" max="59" placeholder="min" required class="bg-ppyellow text-end" value="02">
            :
            <input type="number" id="secondes" name="secondes" min="0" max="59" placeholder="sec" required class="bg-ppyellow text-start" value="30">
        </label>
    </div>
    <div id="company1" class="flex flex-col gap-2 w-full">
        <div class="border-4 border-ppblue rounded-2xl p-3 w-full flex justify-center">
            <label class="text-3xl">
                <span>Company Name :</span>
                <input type="text" name="companiesName[]" placeholder="Type name" required class="bg-ppyellow border border-ppred rounded-2xl p-2">
            </label>
        </div>
    </div>
    <div id="company2" class="flex flex-col gap-2 w-full">
        <div class="border-4 border-ppblue rounded-2xl p-3 w-full flex justify-center">
            <label class="text-3xl">
                <span>Company Name :</span>
                <input type="text" name="companiesName[]" placeholder="Type name" required class="bg-ppyellow border border-ppred rounded-2xl p-2">
            </label>
        </div>
    </div>
    <button id="addCompany">Add company</button>
    <input type="submit" value="Play !">

</form>

<script>
    let companiesNumber = 2;
    document.getElementById("addCompany").addEventListener("click", function (){

        let companies = document.getElementById("company2");
        let newCompany = document.createElement("div");
        newCompany.classList.add("border-4", "border-ppblue", "rounded-2xl", "p-3", "w-full");
        newCompany.innerHTML = `
            <label class="text-3xl">
                <span>Company Name :</span>
                <input type="text" name="companiesName[]" placeholder="Type name" required class="bg-ppyellow border border-ppred rounded-2xl p-2">
            </label>
        `;
        companies.appendChild(newCompany);
        companiesNumber++;
        if (companiesNumber === 6) {
            document.getElementById("addCompany").classList.add("hidden");
        }
    })
</script>

<?php
require_once "../templates/footer.php";
?>
