@extends('layouts.app')
@section('content')

<head>
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
    </style>
</head>

<body>
    <div id="container" class="container">
        <h1 class="pb-2">Vehiculos</h1>
        <div class="row mt-2">
            <div class="col-5">
                <div class="card  rounded-0">
                    <div class="card-header bg-dark text-white rounded-0">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <label class="fw-bold text-uppercase">Nombre</label>
                            </div>
                            <div class="col-md-6 text-center">
                                <label class="fw-bold text-uppercase">Concesionario</label>
                            </div>
                        </div>
                    </div>
                    <list id="vehiclesList"></list>
                </div>
                <!-- Barra navegació -->
                <div class="mt-4 p-2 border">
                    <paginacio class="pagination justify-content-center" id="pagination-numbers">
                    </paginacio>
                </div>
            </div>

            <!-- Formulari alta/actualització  -->
            <div class="col-7">
                <div class="card  rounded-0">
                    <div class="card-header bg-dark text-white  rounded-0">
                        <label id="operationLabel" class="fw-bold text-uppercase">Operation</label>
                    </div>
                    <div class="card-body div-form">
                        <form>
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label text-md-end">Nombre Vehiculo</label>
                                <div class="col-md-7">
                                    <input type="text" name="name" id="nameInput" class="form-control mb-2" />
                                </div>
                                <label class="col-md-3 col-form-label text-md-end">Modelo</label>
                                <div class="col-md-7">
                                    <select name="model" id="modelInput" class="form-control mb-2" required>
                                        <option value="Crossover">Crossover</option>
                                        <option value="Sedan">Sedan</option>
                                        <option value="Sport">Sport</option>
                                        <option value="Coupe">Coupe</option>
                                    </select>
                                </div>
                                <label class="col-md-3 col-form-label text-md-end">Combustible</label>
                                <div class="col-md-7">
                                    <select name="fuel" id="fuelInput" class="form-control mb-2" required>
                                        <option value="Gasolina">Gasolina</option>
                                        <option value="Diésel">Diésel</option>
                                        <option value="Hibrido">Hibrido</option>
                                        <option value="Eléctrico">Eléctrico</option>
                                    </select>
                                </div>
                                <label class="col-md-3 col-form-label text-md-end">Precio</label>
                                <div class="col-md-7">
                                    <input type="text" name="price" id="priceInput" class="form-control mb-2" />
                                </div>
                                <label class="col-md-3 col-form-label text-md-end">Motor</label>
                                <div class="col-md-7">
                                    <input type="text" name="motor" id="motorInput" class="form-control mb-2" />
                                </div>
                                <label class="col-md-3 col-form-label text-md-end">Año de producción</label>
                                <div class="col-md-7">
                                    <input type="date" name="production_year" id="productionYearInput" class="form-control mb-2" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                </div>
                                <label class="col-md-3 col-form-label text-md-end">Foto</label>
                                <div class="col-md-7">
                                    <input type="text" name="picture" id="pictureInput" class="form-control mb-2" />
                                </div>
                                <label class="col-md-3 col-form-label text-md-end">Concesionario</label>
                                <div class="col-md-7">
                                    <select name="concessionaire_id" id="concessionaireInput" class="form-control mb-2" required>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="button" id="saveButton" class="btn btn-primary me-2">Desar</button>
                                    <button type="button" id="cancelButton" class="btn btn-secondary me-2">Cancel·lar</button>
                                    <button type="button" id="deleteButton" class="btn btn-danger">Esborrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- zona Missatges -->
                <div id="messagesDiv" class="border p-2 mt-4 rounded-0">
                </div>
            </div>

        </div>
    </div>
</body>
<script type="text/javascript">
    // Enregistrem els events associats a cada botó del formulari
    const saveButton = document.getElementById('saveButton');
    saveButton.addEventListener('click', saveRegister);
    const cancelButton = document.getElementById('cancelButton');
    cancelButton.addEventListener('click', resetButton);
    const deleteButton = document.getElementById('deleteButton');
    deleteButton.addEventListener('click', deleteRegister);

    // url per accedir a l'API
    const url = 'http://localhost:8000/api/vehicles';

    // Número pàgines del llistat
    let last_page = 0;
    // Número de registres per pàgina
    let per_page = 0;
    // Pàgina actual
    let currentPage = 1;
    // llista de vehicles
    let vehicles = [];
    // Referència al vehicle seleccionat
    let selectedVehicle;

    let concessionaires = [];

    function resetButton(event) {
        event.preventDefault()
        console.log('cancelarem....');
        reset();
    }

    ///////////////////////////////////////////////////////////////////////
    // saveRegister()
    // Funció que s'executa en fer click sobre el botó "Desar"
    // Si no tenim cap registre seleccionat farem una alta
    // en cas contrari, es tracta d'una actualització
    //////////////////////////////////////////////////////////////////////
    async function saveRegister(event) {
        event.preventDefault()
        if (selectedVehicle === undefined) {
            newVehicle = {
                id: undefined,
                name: document.getElementById("nameInput").value,
                model: document.getElementById("modelInput").value,
                fuel: document.getElementById("fuelInput").value,
                price: document.getElementById("priceInput").value,
                motor: document.getElementById("motorInput").value,
                production_year: document.getElementById("productionYearInput").value,
                picture: document.getElementById("pictureInput").value,
                concessionaire_id: document.getElementById("concessionaireInput").value
            }
            await newRegister(newVehicle);

        } else { // Si l'objecte té valor, farem una actualització
            // Recuperem les dades de la caixa i les posem en els atributs de selectedSuperhero
            selectedVehicle.name = document.getElementById("nameInput").value
            selectedVehicle.model = document.getElementById("modelInput").value
            selectedVehicle.fuel = document.getElementById("fuelInput").value
            selectedVehicle.price = document.getElementById("priceInput").value
            selectedVehicle.motor = document.getElementById("motorInput").value
            selectedVehicle.production_year = document.getElementById("productionYearInput").value
            selectedVehicle.picture = document.getElementById("pictureInput").value
            selectedVehicle.concessionaire_id = document.getElementById("concessionaireInput").value
            await updateRegister(selectedVehicle);
        }
    }

    //////////////////////////////////////////////////////////////////////////
    // updateRegister()
    // Crida a l'API remota per actualitzar un registre (PUT)
    //////////////////////////////////////////////////////////////////////////
    async function updateRegister(selectedVehicle) {
        try {
            const response = await fetch(url + '/' + selectedVehicle.id, {
                method: 'PUT',
                body: JSON.stringify(selectedVehicle),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            const data = await response.json();

            if (response.ok) {
                const selectedTr = document.getElementById('vehicle-' + selectedVehicle.id);

                let containerDiv = document.createElement('div');
                containerDiv.classList.add('row');

                let leftElement = document.createElement('div');
                leftElement.classList.add('col-md-6', 'text-center');
                leftElement.innerHTML = data.data.name;

                let rightElement = document.createElement('div');
                rightElement.classList.add('col-md-6', 'text-center');
                rightElement.innerHTML = getConcessionaireNameById(data.data.concessionaire_id);

                // Agregar elementos al contenedor
                containerDiv.appendChild(leftElement);
                containerDiv.appendChild(rightElement);

                // Limpiar el contenido existente de selectedTr
                selectedTr.innerHTML = '';

                // Agregar el contenedor al elemento con la clase selectedTr
                selectedTr.appendChild(containerDiv);

                showMessages('message', "Vehiculo actualizado correctamente");
            } else {
                showMessages('error', data.data);
            }
        } catch (error) {
            showMessages('error', 'Error accedint a les dades remotes.');
        }
    }

    async function reset(event) {
        const messagesDiv = document.getElementById('messagesDiv');
        const nameInput = document.getElementById('nameInput');
        const modelInput = document.getElementById('modelInput');
        const fuelInput = document.getElementById('fuelInput');
        const priceInput = document.getElementById('priceInput');
        const motorInput = document.getElementById('motorInput');
        const productionYearInput = document.getElementById('productionYearInput');
        const pictureInput = document.getElementById('pictureInput');
        const concessionaireInput = document.getElementById('concessionaireInput');
        const operationLabel = document.getElementById('operationLabel');

        operationLabel.innerText = 'Nuevo Vehiculo';
        nameInput.value = "";
        modelInput.value = "";
        fuelInput.value = "";
        priceInput.value = "";
        motorInput.value = "";
        productionYearInput.value = "";
        pictureInput.value = "";
        concessionaireInput.value = "";
        // deshabilita botons de cance·lar i esborrar            
        //deleteButton.classList.add("invisible"); // classe Bootstrap
        deleteButton.style.visibility = 'hidden';
        //cancelButton.classList.remove("invisible"); // Treiem la classe Bootstrap
        cancelButton.style.visibility = 'hidden';

        // Desmarquem el seleccionat
        if (selectedVehicle !== undefined) {
            const currentElement = document.getElementById("vehicle-" + selectedVehicle.id);
            currentElement.removeAttribute("selected");
        }
        selectedVehicle = undefined;
    }

    /////////////////////////////////////////////////////////////////////
    // getList()
    // versió 1
    // Crida a l'API remota per obtenir llistat de dades (GET)
    //////////////////////////////////////////////////////////////////////
    async function getList(url) {
        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
            });

            if (response.ok) {
                const json = await response.json();
                vehicles = json.data.data;
                // console.log(vehicles) salen los concess¡ionarios? ??
                last_page = json.data.last_page;
                per_page = json.data.per_page;

            } else {
                showMessages('error', 'Error accedint a les dades remotes.');
            }

        } catch (error) {
            showMessages('error', 'Error de xarxa imprevist.');
        }
    }

    ////////////////////////////////////////////////////////////////////////////////
    // showMessages(type,errors)
    //  type: pot ser "error" o "missatge", per mostrar en vermell ...
    // errors: pot ser un únic string o un array d'strings
    // Mostra el div on es mostren els missatges
    ///////////////////////////////////////////////////////////////////////////////
    function showMessages(type, errors) {

        const messagesDiv = document.getElementById('messagesDiv');

        // Treure ocultació en bootstrap
        messagesDiv.classList.remove("d-none");

        // En javascript pode fer
        //messagesDiv.style.display = "block"
        messagesDiv.innerHTML = '';

        // Afegir classes d'estil segons tipus de missatge
        if (type == "error") {
            messagesDiv.classList.remove("text-dark");
            messagesDiv.classList.add("text-danger");
        } else {
            messagesDiv.classList.remove("text-danger");
            messagesDiv.classList.add("text-dark");
        }

        // Si errors és un array fa un recorregut i crea una llista <ul> amb elements <li>
        // <ul><li>Error 1 <li>Error 2</li></ul>
        if (Array.isArray(errors)) {
            const ul = document.createElement("ul");

            for (const error of errors) {
                const li = document.createElement('li');
                li.textContent = error;
                ul.appendChild(li);
            }
            messagesDiv.appendChild(ul);

        } else messagesDiv.innerHTML = errors;
    }

    ///////////////////////////////////////////////////////////////////////
    // newRegister()
    // Crida a l'API remota per crear un nou registre (POST)
    //////////////////////////////////////////////////////////////////////
    async function newRegister(newData) {

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(newData)
            });

            const data = await response.json();
            if (response.ok) {

                reloadListAndPagination(url);

                showMessages('message', 'Vehiculo añadido correctamente');
            } else {
                showMessages('error', data.data);
            }
        } catch (error) { // Errors de xarxa
            showMessages('error', 'Error accedint a les dades remotes.');
        }
    }

    //////////////////////////////////////////////////////////////////////////
    // deleteRegister()
    // Crida a l'API remota per esborrar un registre (DELETE)
    //////////////////////////////////////////////////////////////////////////
    async function deleteRegister() {

        if (confirm("Seguro que quieres borrar el registro") === false) {
            return;
        }

        try {
            const response = await fetch(url + '/' + selectedVehicle.id, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            const json = await response.json();
            if (response.ok) { // codi 200

                const message = "Vehiculo: " + json.data.name + " esborrat.";
                reset();
                showMessages('message', message);
                // Recreem taula per veure els canvis                   
                reloadListAndPagination(url);

            } else {
                showMessages('error', "Error en esborrar el Vehiculo amb codi " + selectedVehicle.id + ".<br>" +
                    "Seguramente un vehiculo ha sido introducido en este Vehiculo.");
            }

        } catch (error) {
            showMessages('error', 'Error accedint a les dades remotes.');
        }
    }

    async function reloadListAndPagination(url) {
        // Obtinc les dades del servidor
        await getList(url);
        //... vehicles, per_page, last_page disponibles ...  
        loadIntoList()

        // encara no tenim pagination 
    }

    async function createEmptyList(per_page) {
        // Buido el contingut
        const dataTable = document.getElementById('vehiclesList');
        dataTable.innerHTML = "";

        for (var i = 0; i < per_page; i++) {
            addEmptyElement(i);
        }
    }

    function addEmptyElement(index) {
        const vehicleElementList = document.getElementById('vehiclesList');
        const vehicleElement = document.createElement('vehicle');

        // Registrem event per quan cliquem sobre una fila de la taula            
        vehicleElement.addEventListener('click', function() {
            editVehicle(index);
        });

        vehicleElementList.appendChild(vehicleElement);
    }

    async function createListAndPagination() {
        await getToken();
        loadConcessionaires();
        // Obtinc les dades del servidor
        await getList(url);
        //... vehicles, per_page, last_page disponibles ...                
        createEmptyList(per_page);
        loadIntoList()
        createPaginationBar();
    }

    async function loadIntoList() {
        // Obtenim tots els elements <vehicle> de la llista amb id = vehiclesList
        const container = document.querySelector("#vehiclesList");
        const vehicleElements = container.querySelectorAll("vehicle");

        // Tots els elements <vehicle> quedaran per exemple:   <vehicle id='vehicle-34' selected=false ...>
        for (let i = 0; i < vehicles.length; i++) {
            // Limpiar contenido existente
            vehicleElements[i].innerHTML = '';

            vehicleElements[i].setAttribute("selected", false);
            vehicleElements[i].removeAttribute("deleted");

            let containerDiv = document.createElement('div');
            containerDiv.classList.add('row');

            let leftElement = document.createElement('div');
            leftElement.classList.add('col-md-6', 'text-center');
            leftElement.innerHTML = vehicles[i].name;

            let rightElement = document.createElement('div');
            rightElement.classList.add('col-md-6', 'text-center');
            rightElement.innerHTML = getConcessionaireNameById(vehicles[i].concessionaire_id);

            // Agregar elementos al contenedor
            containerDiv.appendChild(leftElement);
            containerDiv.appendChild(rightElement);

            // Agregar el contenedor al elemento del vehículo
            vehicleElements[i].appendChild(containerDiv);

            // Posem id de l'estil vehicle-0, ...
            vehicleElements[i].setAttribute('id', 'vehicle-' + vehicles[i].id);

            // Cursor amb dit per seleccionar
            vehicleElements[i].style = 'cursor: pointer';
        }

        // Si queden elements de la llista sense dades, les desactivem.
        for (let j = vehicles.length; j < vehicleElements.length; j++) {
            // Limpiar contenido existente
            vehicleElements[j].innerHTML = '';

            // cursor normal
            vehicleElements[j].style = 'cursor: cursor';
            vehicleElements[j].setAttribute("selected", false);

            // Els elements sense vehicle tenen un estil diferent!
            vehicleElements[j].setAttribute("deleted", true);
        }
    }

    async function loadConcessionaires() {
        try {
            const respuesta = await fetch('http://localhost:8000/api/concessionaires/all', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
            });
            if (!respuesta.ok) {
                throw new Error('Error al obtener los concesionarios');
            }
            const datos = await respuesta.json();
            concessionaires = datos;
            const concessionaireInput = document.getElementById('concessionaireInput');
            concessionaires.data.forEach(function(concessionaire) {
                // Crea una opción para cada concesionario
                var option = document.createElement("option");
                option.value = concessionaire.id; // Puedes usar el ID como valor, o cambiarlo según tus necesidades
                option.text = concessionaire.name;
                concessionaireInput.appendChild(option);
            });
            concessionaireInput.value = '';
        } catch (error) {
            console.error('Error:', error);
            return null;
        }
    }

    function getConcessionaireNameById(id) {
        const concesionarioEncontrado = concessionaires.data.find(concesionario => concesionario.id == id);

        if (concesionarioEncontrado) {
            return concesionarioEncontrado.name;
        } else {
            return null;
        }
    }

    function createPaginationBar() {
        const prevButton = document.createElement("button");
        prevButton.innerHTML = "<";
        prevButton.classList.add("navbutton");

        const spanElement = document.createElement('span');
        spanElement.classList.add('page-number');

        const nextButton = document.createElement("button");
        nextButton.innerHTML = ">";
        nextButton.classList.add("navbutton");

        prevButton.addEventListener("click", function() {
            setCurrentPage(currentPage - 1);
            updatePageNumber(); // Actualizar el número de página después de cambiar de página
        });

        nextButton.addEventListener("click", function() {
            setCurrentPage(currentPage + 1);
            updatePageNumber(); // Actualizar el número de página después de cambiar de página
        });

        const paginationNumbers = document.getElementById("pagination-numbers");
        paginationNumbers.appendChild(prevButton);
        paginationNumbers.appendChild(spanElement);
        paginationNumbers.appendChild(nextButton);

        // Función para actualizar el número de página en el spanElement
        const updatePageNumber = () => {
            const textNode = document.createTextNode(`${currentPage}`);
            // Eliminar el contenido actual antes de agregar el nuevo nodo de texto
            while (spanElement.firstChild) {
                spanElement.removeChild(spanElement.firstChild);
            }
            spanElement.appendChild(textNode);
        };

        // Llamar a updatePageNumber inicialmente para establecer el número de página
        updatePageNumber();
    }

    async function setCurrentPage(pageNum) {
        // Actualitzar la pàgina actual
        if (pageNum < 1 || pageNum > last_page) return;

        currentPage = pageNum;

        // Carregar dades a la taula, passant la pàgina que vull obtenir
        await getList(url + '?page=' + currentPage);
        loadIntoList();
    }

    function editVehicle(index) {

        // console.log(index);
        // console.log(vehicles[index]);
        if (index >= vehicles.length) {
            return;
        }

        const selectedElement = document.getElementById('vehicle-' + vehicles[index].id);

        // Obtenim tots els elements <vehicle> de la llista amb id = vehiclesList
        const container = document.querySelector("#vehiclesList");
        const rows = container.querySelectorAll("vehicle");
        // els posem els atributs de seleccionat a false a tots
        for (const row of rows) {
            row.setAttribute("selected", false);
        }
        // El que hem seleccionat l'activem
        selectedElement.setAttribute("selected", true);

        // Obtenim les dades del regitre seleccionat
        // i les posem en les caixes del formulari per poder editar-les                         
        selectedVehicle = vehicles[index];

        const nameInput = document.getElementById('nameInput');
        const modelInput = document.getElementById('modelInput');
        const fuelInput = document.getElementById('fuelInput');
        const priceInput = document.getElementById('priceInput');
        const motorInput = document.getElementById('motorInput');
        const productionYearInput = document.getElementById('productionYearInput');
        const pictureInput = document.getElementById('pictureInput');
        const concessionaireInput = document.getElementById('concessionaireInput');
        nameInput.value = selectedVehicle.name;
        modelInput.value = selectedVehicle.model;
        fuelInput.value = selectedVehicle.fuel;
        priceInput.value = selectedVehicle.price;
        motorInput.value = selectedVehicle.motor;
        productionYearInput.value = selectedVehicle.production_year;
        pictureInput.value = selectedVehicle.picture;

        concessionaireInput.value = selectedVehicle.concessionaire_id;

        // Activem botons per cancel·lar l'operació d'actualització i per
        // esborrar el registre actiu
        deleteButton.style.visibility = 'visible';
        cancelButton.style.visibility = 'visible';

        const operationLabel = document.getElementById('operationLabel');
        operationLabel.innerText = "Actualizar Vehiculo";
    }

    async function getToken() {
        console.log('obtener token')
        try {
            let token_url = 'http://127.0.0.1:8000/token';
            const response = await fetch(token_url, {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            });
            if (response.ok) {
                const json = await response.json();
                token = json.token;


            } else {
                console.log('error token')
                showMessages('error', 'Error accediendo a los datos remotos.');
            }
        } catch (error) {
            console.log('error token 2')
            showMessages('error', 'Error de red imprevisto.');
        }
    }

    createListAndPagination();
    reset(); // mateix codi que reset(), sense paràmetre event!!
</script>
@endsection