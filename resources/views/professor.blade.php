<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8" />
    <title>Professors - Escola FP</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen p-8">
    <header class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-[#f5b041]">Gestió de professors</h1>
        <a href="{{ url('/') }}" class="text-[#f5b041] hover:underline">Tornar a l'inici</a>
    </header>
    
    <section class="mb-6 max-w-md">
        <input type="text" id="inputBuscar" placeholder="Buscar professor..." class="w-full border border-black rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" id="nomProfessor" placeholder="Nom del professor" class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" id="cognomProfessor" placeholder="Cognom del professor" class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <button id="btnAfegir" class="bg-[#f5b041] text-white px-4 py-2 rounded hover:bg-orange-600 transition w-full">Afegir</button>
    </section>
    
    <ul id="professorList" class="space-y-4 max-w-md"></ul>
    
    <script>
        const apiUrl = '/api/professor';
        
        async function carregarProfessors(filtre = '') {
            let url = apiUrl;
            if(filtre) {
                url += '?q=' + encodeURIComponent(filtre);
            }
            const res = await fetch(url);
            const professors = await res.json();
            const llista = document.getElementById('professorList');
            llista.innerHTML = '';
            
            if (professors.length === 0) {
                const li = document.createElement('li');
                li.textContent = "No s'han trobat professors.";
                li.className = 'text-gray-500 italic';
                llista.appendChild(li);
                return;
            }
            
            professors.forEach(professor => {
                const li = document.createElement('li');
                li.className = 'bg-white shadow rounded p-4 flex justify-between items-center space-x-4';
                li.innerHTML = `
                    <div class="flex flex-col flex-grow">
                        <p class="font-semibold text-lg">${professor.nom}</p>
                        <p class="text-gray-600 text-sm">${professor.cognoms}</p>
                    </div>
                    <button class="text-red-600 hover:text-red-800" data-id="${professor.id}">Eliminar</button>
                `;
                llista.appendChild(li);
            });
            
            llista.querySelectorAll('button.text-red-600').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.getAttribute('data-id');
                    if(confirm('Segur que vols eliminar aquest professor?')) {
                        const res = await fetch(`${apiUrl}/${id}`, { method: 'DELETE' });
                        if(res.ok) carregarProfessors(document.getElementById('inputBuscar').value);
                        else alert('Error eliminant el professor');
                    }
                });
            });
        }
        
        document.getElementById('btnAfegir').addEventListener('click', async () => {
            const nom = document.getElementById('nomProfessor').value.trim();
            const cognoms = document.getElementById('cognomProfessor').value.trim();
            
            if(!nom) return alert('Escriu un nom per afegir.');
            if(!cognoms) return alert('Escriu un cognom per afegir.');
            
            const res = await fetch(apiUrl, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify({nom, cognoms})
            });
            
            if(res.ok) {
                document.getElementById('nomProfessor').value = '';
                document.getElementById('cognomProfessor').value = '';
                carregarProfessors(document.getElementById('inputBuscar').value);
            } else {
                alert('Error afegint el professor');
            }
        });
        
        document.getElementById('inputBuscar').addEventListener('input', e => {
            carregarProfessors(e.target.value);
        });
        
        carregarProfessors();
    </script>

</body>
</html>
