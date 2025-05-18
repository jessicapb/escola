<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8" />
    <title>Inici - Escola FP</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-4xl font-bold mb-8 text-blue-700">Benvingut a Escola FP</h1>

    <p class="mb-6 text-lg">Consulta els mòduls, professor i alumnes que te l'escola.</p>

    <div class="flex">
        <a href="{{ url('/moduls') }}" class="mr-[10px] bg-blue-400 text-white px-6 py-3 rounded hover:bg-blue-500 transition">
            Anar a Mòduls
        </a>
        <a href="{{ url('/professor') }}" class=" mr-[10px] bg-[#f5b041] text-white px-6 py-3 rounded hover:bg-orange-500 transition">
            Anar a Professors
        </a>
        <a href="{{ url('/alumnes') }}" class=" mr-[10px] bg-[#45b39d] text-white px-6 py-3 rounded hover:bg-green-500 transition">
            Anar a Alumnes
        </a>
        <a href="{{ url('/unitatsformatives') }}" class="mr-[10px] bg-[#f4d03f] text-white px-6 py-3 rounded hover:bg-yellow-500 transition">
            Anar a Unitats Formatives
        </a>
    </div>
</body>
</html>
