</main>

<footer class="bg-ppyellow">
    <div class="flex py-3 px-2 bg-ppblue justify-between items-center rounded-t-2xl">
        <img src="../assets/logo.png" alt="Pitch Perfect Logo" class="h-[50px]">
        <div class="flex flex-col items-end">
            <p class="text-xl text-ppyellow font-ppfont font-bold m-0 p-0">PitchPerfect - English Game</p>
            <p class="text-xl text-ppyellow font-ppfont font-bold m-0 p-0">Montpellier 2023</p>
        </div>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleMenu = document.getElementById('toggleMenu');
        const menu = document.getElementById('menu');
        const link1 = document.getElementById('link1');
        const link2 = document.getElementById('link2');

        toggleMenu.addEventListener('click', function () {
            menu.classList.toggle('hidden');
        });
        link1.addEventListener('click', function () {
            menu.classList.toggle('hidden');
        });
        link2.addEventListener('click', function () {
            menu.classList.toggle('hidden');
        });
    });
</script>


</body>
</html>