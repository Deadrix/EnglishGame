<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PitchPerfect | <?php if (!empty($page_name)) echo $page_name ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="../../dist/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
</head>
<body class="flex flex-col min-h-screen font-ppfont">

<header class="bg-ppyellow shadow-2xl shadow-black">
    <div class="bg-ppblue py-3 px-2 rounded-b-2xl">
        <div class="flex justify-between items-center">
            <img src="../assets/logo.png" alt="Logo Pitch Perfect" class="h-[70px]">
            <p class="text-5xl text-ppyellow font-bold font-ppfont m-0 p-0"><?php if (!empty($page_name)) echo $page_name ?></p>
            <div class="relative">
                <button id="toggleMenu" type="button"
                        class="inline-flex items-center justify-center w-12 h-12 bg-gray-800 text-white rounded-md focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="menu" class="hidden">
            <div class="p-4 mt-4 flex flex-col">
                <a id="link1" href="../vue/rules.php" class="text-3xl font-ppfont text-ppyellow">Rules</a>
                <a id="link2" href="../vue/settings.php" class="text-3xl font-ppfont text-ppyellow">Play !</a>
            </div>
        </div>
    </div>

</header>

<main class="flex-1 bg-ppyellow flex justify-center items-center p-3">