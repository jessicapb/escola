<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8" />
    <title>Mòduls - Escola FP</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen p-8">
    <header class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-blue-400">Gestió de Mòduls</h1>
        <a href="{{ url('/') }}" class="text-blue-400 hover:underline">Tornar a l'inici</a>
    </header>
    
    <section class="mb-6 max-w-md">
        <input type="text" id="inputBuscar" placeholder="Buscar mòdul..." class="w-full border border-black rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" id="nomModul" placeholder="Nom del mòdul" class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" id="descripModul" placeholder="Descripció del mòdul" class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        
        <button id="btnAfegir" class="bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-600 transition w-full">Afegir</button>
    </section>
    
    <ul id="modulsList" class="space-y-4 max-w-md"></ul>
    
    <script>
        const apiUrl = '/api/moduls';
        
        async function carregarModuls(filtre = '') {
            let url = apiUrl;
            if(filtre) {
                url += '?q=' + encodeURIComponent(filtre);
            }
            const res = await fetch(url);
            const moduls = await res.json();
            const llista = document.getElementById('modulsList');
            llista.innerHTML = '';
            
            if (moduls.length === 0) {
                const li = document.createElement('li');
                li.textContent = "No s'han trobat mòduls.";
                li.className = 'text-gray-500 italic';
                llista.appendChild(li);
                return;
            }
            
            moduls.forEach(modul => {
                const li = document.createElement('li');
                li.className = 'bg-white shadow rounded p-4 space-y-2';
                
                li.innerHTML = `
                    <p class="font-semibold text-lg">${modul.nom}</p>
                    <p class="text-black-600 text-[15px]">${modul.descripcio}</p>
                    <div class="flex space-x-2">
                        <button class="text-red-600 hover:text-red-800" data-id="${modul.id}">Eliminar</button>
                    </div>
                `;
                
                llista.appendChild(li);
            });
            
            llista.querySelectorAll('button.text-red-600').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.getAttribute('data-id');
                    if(confirm('Segur que vols eliminar aquest mòdul?')) {
                        const res = await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });
                        if(res.ok) carregarModuls(document.getElementById('inputBuscar').value);
                        else alert('Error eliminant el mòdul');
                    }
                });
            });
        }
        
        document.getElementById('btnAfegir').addEventListener('click', async () => {
            const nom = document.getElementById('nomModul').value.trim();
            const descripcio = document.getElementById('descripModul').value.trim();
            if(!nom) return alert('Escriu un nom per afegir.');
            if(!descripcio) return alert('Escriu la descripció per afegir.');
            
            const res = await fetch(apiUrl, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify({nom, descripcio})
            });
            
            if(res.ok) {
                document.getElementById('nomModul').value = '';
                document.getElementById('descripModul').value = '';
                carregarModuls(document.getElementById('inputBuscar').value);
            } else {
                alert('Error afegint el mòdul');
            }
        });
        
        document.getElementById('inputBuscar').addEventListener('input', e => {
            carregarModuls(e.target.value);
        });
        
        carregarModuls();
    </script>
</body>
</html>
