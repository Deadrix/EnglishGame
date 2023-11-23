<?php
session_start();
$page_name = "Rules";
require_once "../templates/header.php";
?>
    <div class="flex flex-col justify-center items-center w-full">
        <h1>Les règles du jeu</h1>

        <p id="playButton"
           class="m-0 mt-5 rounded-full py-4 w-2/3 text-center bg-ppblue text-ppyellow text-2xl border-4 border-ppred">
            Play !</p>
    </div>

<script>
    document.getElementById("playButton").addEventListener("click", function () {
        window.location.href = "./settings.php";
    });
    </script>

<?php
require_once "../templates/footer.php";
?>