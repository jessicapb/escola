<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8" />
    <title>Unitats Formatives - Escola FP</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen p-8">
    <header class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-red-400">Gestió de Unitats Formatives</h1>
        <a href="{{ url('/') }}" class="text-red-400 hover:underline">Tornar a l'inici</a>
    </header>
    
    <section class="mb-6 max-w-md">
        <input type="text" id="inputBuscar" placeholder="Buscar mòdul..." class="w-full border border-black rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" id="nomUnitatsFormatives" placeholder="Nom de la unitat formativa" class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" id="descripUnitatsFormatives" placeholder="Descripció de la unitat formativa" class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        
        <button id="btnAfegir" class="bg-red-400 text-white px-4 py-2 rounded hover:bg-red-600 transition w-full">Afegir</button>
    </section>
    
    <ul id="unitatsformativesList" class="space-y-4 max-w-md"></ul>
    
    <script>
        const apiUrl = '/api/unitatsformatives';
        
        async function carregarunitatsFormatives(filtre = '') {
            let url = apiUrl;
            if(filtre) {
                url += '?q=' + encodeURIComponent(filtre);
            }
            const res = await fetch(url);
            const unitatsformatives = await res.json();
            const llista = document.getElementById('unitatsformativesList');
            llista.innerHTML = '';
            
            if (unitatsformatives.length === 0) {
                const li = document.createElement('li');
                li.textContent = "No s'han trobat unitats formatives.";
                li.className = 'text-gray-500 italic';
                llista.appendChild(li);
                return;
            }
            
            unitatsformatives.forEach(unitatsformative => {
                const li = document.createElement('li');
                li.className = 'bg-white shadow rounded p-4 space-y-2';
                
                li.innerHTML = `
                    <p class="font-semibold text-lg">${unitatsformative.nom}</p>
                    <p class="text-black-600 text-[15px]">${unitatsformative.descripcio}</p>
                    <div class="flex space-x-2">
                        <button class="text-red-600 hover:text-red-800" data-id="${unitatsformative.id}">Eliminar</button>
                    </div>
                `;
                
                llista.appendChild(li);
            });
            
            llista.querySelectorAll('button.text-red-600').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.getAttribute('data-id');
                    if(confirm('Segur que vols eliminar aquesta unitat formativa?')) {
                        const res = await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });
                        if(res.ok) carregarunitatsFormatives(document.getElementById('inputBuscar').value);
                        else alert('Error eliminant la unitat formativa');
                    }
                });
            });
        }
        
        document.getElementById('btnAfegir').addEventListener('click', async () => {
            const nom = document.getElementById('nomUnitatsFormatives').value.trim();
            const descripcio = document.getElementById('descripUnitatsFormatives').value.trim();
            if(!nom) return alert('Escriu un nom per afegir.');
            if(!descripcio) return alert('Escriu la descripció per afegir.');
            
            const res = await fetch(apiUrl, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify({nom, descripcio})
            });
            
            if(res.ok) {
                document.getElementById('nomUnitatsFormatives').value = '';
                document.getElementById('descripUnitatsFormatives').value = '';
                carregarunitatsFormatives(document.getElementById('inputBuscar').value);
            } else {
                alert('Error afegint la unitat formativa');
            }
        });
        
        document.getElementById('inputBuscar').addEventListener('input', e => {
            carregarunitatsFormatives(e.target.value);
        });
        
        carregarunitatsFormatives();
    </script>
</body>
</html>
