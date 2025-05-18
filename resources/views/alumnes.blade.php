<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8" />
    <title>Alumnes - Escola FP</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen p-8">
    <header class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-[#45b39d]">Gestió de Alumnes</h1>
        <a href="{{ url('/') }}" class="text-[#45b39d] hover:underline">Tornar a l'inici</a>
    </header>
    
    <section class="mb-6 max-w-md">
        <input type="text" id="inputBuscar" placeholder="Buscar mòdul..." class="w-full border border-black rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" id="nomAlumne" placeholder="Nom del alumne" class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" id="cognomAlumne" placeholder="Cognoms del alumne" class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        
        <button id="btnAfegir" class="bg-[#45b39d] text-white px-4 py-2 rounded hover:bg-green-500 transition w-full">Afegir</button>
    </section>
    
    <ul id="alumnesList" class="space-y-4 max-w-md"></ul>
    
    <script>
        const apiUrl = '/api/alumnes';
        
        async function carregarAlumnes(filtre = '') {
            let url = apiUrl;
            if(filtre) {
                url += '?q=' + encodeURIComponent(filtre);
            }
            const res = await fetch(url);
            const alumnes = await res.json();
            const llista = document.getElementById('alumnesList');
            llista.innerHTML = '';
            
            if (alumnes.length === 0) {
                const li = document.createElement('li');
                li.textContent = "No s'han trobat alumnes.";
                li.className = 'text-gray-500 italic';
                llista.appendChild(li);
                return;
            }
            
            alumnes.forEach(alumne => {
                const li = document.createElement('li');
                li.className = 'bg-white shadow rounded p-4 space-y-2';
                
                li.innerHTML = `
                    <p class="font-semibold text-lg">${alumne.nom}</p>
                    <p class="text-black-600 text-[15px]">${alumne.cognoms}</p>
                    <div class="flex space-x-2">
                        <button class="text-red-600 hover:text-red-800" data-id="${alumne.id}">Eliminar</button>
                    </div>
                `;
                
                llista.appendChild(li);
            });
            
            llista.querySelectorAll('button.text-red-600').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.getAttribute('data-id');
                    if(confirm('Segur que vols eliminar aquest alumne?')) {
                        const res = await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });
                        if(res.ok) carregarAlumnes(document.getElementById('inputBuscar').value);
                        else alert('Error eliminant alumne');
                    }
                });
            });
        }
        
        document.getElementById('btnAfegir').addEventListener('click', async () => {
            const nom = document.getElementById('nomAlumne').value.trim();
            const cognoms = document.getElementById('cognomAlumne').value.trim();
            if(!nom) return alert('Escriu un nom per afegir.');
            if(!cognoms) return alert('Escriu el cognom per afegir.');
            
            const res = await fetch(apiUrl, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify({nom, cognoms})
            });
            
            if(res.ok) {
                document.getElementById('nomAlumne').value = '';
                document.getElementById('cognomAlumne').value = '';
                carregarAlumnes(document.getElementById('inputBuscar').value);
            } else {
                alert('Error afegint el alumne');
            }
        });
        
        document.getElementById('inputBuscar').addEventListener('input', e => {
            carregarAlumnes(e.target.value);
        });
        
        carregarAlumnes();
    </script>
</body>
</html>