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
        <h1 class="pb-2">Clientes</h1>
        <div class="row mt-2">
            <div class="col-3">
                <div class="card  rounded-0">
                    <div class="card-header bg-dark text-white  rounded-0">
                        <label class="fw-bold text-uppercase">Nombre</label>
                    </div>
                    <list id="customersList"></list>
                </div>
                <!-- Barra navegació -->
                <div class="mt-4 p-2 border">
                    <paginacio class="pagination justify-content-center" id="pagination-numbers">
                    </paginacio>
                </div>
            </div>

            <!-- Formulari alta/actualització  -->
            <div class="col-9">
                <div class="card  rounded-0">
                    <div class="card-header bg-dark text-white  rounded-0">
                        <label id="operationLabel" class="fw-bold text-uppercase">Operation</label>
                    </div>
                    <div class="card-body div-form">
                        <form>
                            <div class="row mb-3">
                                <label class="col-md-2 col-form-label text-md-end">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" id="nameInput" class="form-control mb-2" />
                                </div>
                                <label class="col-md-2 col-form-label text-md-end">Teléfono</label>
                                <div class="col-md-9">
                                    <input type="text" name="phone_number" id="phoneInput" class="form-control mb-2" />
                                </div>
                                <label class="col-md-2 col-form-label text-md-end">Correo electrónico</label>
                                <div class="col-md-9">
                                    <input type="text" name="email" id="emailInput" class="form-control mb-2" />
                                </div>
                                <label class="col-md-2 col-form-label text-md-end">Dirección</label>
                                <div class="col-md-9">
                                    <input type="text" name="address" id="addressInput" class="form-control mb-2" />
                                </div>
                                <label class="col-md-2 col-form-label text-md-end">User ID</label>
                                <div class="col-md-9">
                                    <input type="text" name="user_id" id="userInput" class="form-control mb-2" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-2 col-form-label text-md-end">Clientes</label>
                                <div class="col-md-4">
                                    <select id="concessionairesOutput" class="form-control" size="8" name="concessionaires[]" multiple>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-md-1 d-flex flex-column align-items-center justify-content-center">
                                    <button id="addButton" type="button" class="btn btn-primary rounded-circle mb-2" style="width: 35px;">+</button>
                                    <button id="removeButton" type="button" class="btn btn-secondary rounded-circle" style="width: 35px;">-</button>
                                </div>
                                <div class="col-md-4">
                                    <select id="concessionairesInput" class="form-control" size="8" name="concessionaires[]" multiple>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="button" id="saveButton" class="btn btn-primary me-2">Guardar</button>
                                    <button type="button" id="cancelButton" class="btn btn-secondary me-2">Cancelar</button>
                                    <button type="button" id="deleteButton" class="btn btn-danger">Borrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                 <!-- zona Missatges -->
                <div id="messagesDiv" class="border p-2 mt-4 rounded-0"></div>
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
    const addButton = document.getElementById('addButton');
    addButton.addEventListener('click', addConcessionaires);
    const removeButton = document.getElementById('removeButton');
    removeButton.addEventListener('click', removeConcessionaires);

    // url per accedir a l'API
    const url = 'http://localhost:8000/api/customers';

    // Número pàgines del llistat
    let last_page = 0;
    // Número de registres per pàgina
    let per_page = 0;
    // Pàgina actual
    let currentPage = 1;
    // llista de customers
    let customers = [];
    // Referència al customer seleccionat
    let selectedCustomer;

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
        if (selectedCustomer === undefined) {
            newCustomer = {
                id: undefined,
                name: document.getElementById("nameInput").value,
                phone_number: document.getElementById("phoneInput").value,
                email: document.getElementById("emailInput").value,
                address: document.getElementById("addressInput").value,
                user_id: document.getElementById("userInput").value,
            }
            await newRegister(newCustomer);

        } else { // Si l'objecte té valor, farem una actualització
            // Recuperem les dades de la caixa i les posem en els atributs de Customer
            selectedCustomer.name = document.getElementById("nameInput").value
            selectedCustomer.phone_number = document.getElementById("phoneInput").value
            selectedCustomer.email = document.getElementById("emailInput").value
            selectedCustomer.address = document.getElementById("addressInput").value
            selectedCustomer.user_id = document.getElementById("userInput").value
            await updateRegister(selectedCustomer);
        }
    }

    async function addConcessionaires(event) {
        var selectedConcessionaires = Array.from(document.getElementById('concessionairesInput').selectedOptions).map(option => option.value);

        if (!selectedConcessionaires || selectedConcessionaires.length === 0) {
            alert('Selecciona al menos un cliente');
            return;
        }

        var jsonData = {
            concessionaires: selectedConcessionaires
        };

        try {
            const response = await fetch(url + '/' + selectedCustomer.id + '/attach-concessionaires', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(jsonData)
            });

            const data = await response.json();
            if (response.ok) {
                getConcessionaires();
                showMessages('message', 'Concesionarios añadidos correctamente');
            } else {
                showMessages('error', data.data);
            }
        } catch (error) { // Errors de xarxa
            showMessages('error', 'Error accedint a les dades remotes.');
        }
    }

    async function removeConcessionaires(event) {
        var selectedConcessionaires = Array.from(document.getElementById('concessionairesOutput').selectedOptions).map(option => option.value);

        if (!selectedConcessionaires || selectedConcessionaires.length === 0) {
            alert('Selecciona al menos un cliente');
            return;
        }

        var jsonData = {
            concessionaires: selectedConcessionaires
        };

        try {
            const response = await fetch(url + '/' + selectedCustomer.id + '/detach-concessionaires', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(jsonData)
            });

            const data = await response.json();
            if (response.ok) {
                getConcessionaires();
                showMessages('message', 'Concessionarios quitados correctamente');
            } else {
                showMessages('error', data.data);
            }
        } catch (error) { // Errors de xarxa
            showMessages('error', 'Error accedint a les dades remotes.');
        }
    }


    //////////////////////////////////////////////////////////////////////////
    // updateRegister()
    // Crida a l'API remota per actualitzar un registre (PUT)
    //////////////////////////////////////////////////////////////////////////
    async function updateRegister(selectedCustomer) {
        try {
            const response = await fetch(url + '/' + selectedCustomer.id, {
                method: 'PUT',
                body: JSON.stringify(selectedCustomer),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            const data = await response.json();

            if (response.ok) {
                const selectedTr = document.getElementById('customer-' + selectedCustomer.id);
                selectedTr.innerHTML = data.data.name;

                showMessages('message', "Cliente actualizado correctamente");
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
        const phoneInput = document.getElementById('phoneInput');
        const emailInput = document.getElementById('emailInput');
        const addressInput = document.getElementById('addressInput');
        const userInput = document.getElementById('userInput');
        const operationLabel = document.getElementById('operationLabel');

        operationLabel.innerText = 'Nuevo Concesionario';
        nameInput.value = "";
        phoneInput.value = "";
        emailInput.value = "";
        addressInput.value = "";
        userInput.value = "";
        concessionairesInput.innerHTML = '';
        concessionairesOutput.innerHTML = '';
        // deshabilita botons de cance·lar i esborrar            
        //deleteButton.classList.add("invisible"); // classe Bootstrap
        deleteButton.style.visibility = 'hidden';
        //cancelButton.classList.remove("invisible"); // Treiem la classe Bootstrap
        cancelButton.style.visibility = 'hidden';

        // Desmarquem el seleccionat
        if (selectedCustomer !== undefined) {
            const currentElement = document.getElementById("customer-" + selectedCustomer.id);
            currentElement.removeAttribute("selected");
        }
        selectedCustomer = undefined;
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
                customers = json.data.data;
                // console.log(customers) salen los concess¡ionarios? ??
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
                reset(event)
                reloadListAndPagination(url);

                showMessages('message', 'Cliente añadido correctamente');
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
            const response = await fetch(url + '/' + selectedCustomer.id, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            const json = await response.json();
            if (response.ok) { // codi 200

                const message = "Cliente: " + json.data.name + " esborrat.";
                reset();
                showMessages('message', message);
                // Recreem taula per veure els canvis                   
                reloadListAndPagination(url);

            } else {
                showMessages('error', "Error en esborrar el Concesionario amb codi " + selectedCustomer.id + ".<br>" +
                    "Seguramente un vehiculo ha sido introducido en este concesionario.");
            }

        } catch (error) {
            showMessages('error', 'Error accedint a les dades remotes.');
        }
    }

    async function reloadListAndPagination(url) {
        // Obtinc les dades del servidor
        await getList(url);
        //... Customers, per_page, last_page disponibles ...  
        loadIntoList()
    }

    async function createEmptyList(per_page) {
        // Buido el contingut
        const dataTable = document.getElementById('customersList');
        dataTable.innerHTML = "";

        for (var i = 0; i < per_page; i++) {
            addEmptyElement(i);
        }
    }

    function addEmptyElement(index) {
        const customerElementList = document.getElementById('customersList');
        const customerElement = document.createElement('customer');

        // Registrem event per quan cliquem sobre una fila de la taula            
        customerElement.addEventListener('click', function() {
            editCustomer(index);
        });

        customerElementList.appendChild(customerElement);
    }

    async function createListAndPagination() {
        await getToken();
        // Obtinc les dades del servidor
        await getList(url);
        //... customers, per_page, last_page disponibles ...                
        createEmptyList(per_page);
        loadIntoList()
        createPaginationBar();
    }

    async function loadIntoList() {

        // Obtenim tots els elements <customer> de la llista amb id = customersList
        const container = document.querySelector("#customersList");
        const customerElements = container.querySelectorAll("customer");
        // Tots els elements <customer> quedaran per exemple:   <customer id='customer-34' selected=false ...>
        for (let i = 0; i < customers.length; i++) {
            customerElements[i].setAttribute("selected", false);
            customerElements[i].removeAttribute("deleted")

            customerElements[i].innerHTML = customers[i].name;
            // Posem id de l'estil customer-0, ...
            customerElements[i].setAttribute('id', 'customer-' + customers[i].id);

            // Cursor amb dit per seleccionar
            customerElements[i].style = 'cursor: pointer';
        }
        // Si queden elements de la llista sense dades, les desactivem.
        for (let j = customers.length; j < customerElements.length; j++) {
            // cursor normal
            customerElements[j].style = 'cursor: cursor';
            customerElements[j].setAttribute("selected", false);
            // Els elements sense customer tenen un estil diferent!
            customerElements[j].setAttribute("deleted", true);
            customerElements[j].innerHTML = "";
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

    function getConcessionaires() {

        fetch(url + '/' + selectedCustomer.id + '/edit-concessionaires', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
            })
            .then(response => response.json())
            .then(data => {
                const concessionairesOut = data.data[1]; // Extraer los segundos clientes de la respuesta
                const concessionairesIn = data.data[0].concessionaires;

                concessionairesInput.innerHTML = ''; // Limpiar opciones existentes
                concessionairesOutput.innerHTML = ''; // Limpiar opciones existentes

                // Iterar sobre la lista de clientes y agregar opciones al <select>
                concessionairesIn.forEach(concessionaire => {
                    const option = document.createElement('option');
                    option.value = concessionaire.id;
                    option.text = concessionaire.name;
                    concessionairesOutput.appendChild(option);
                });

                // Iterar sobre la lista de clientes y agregar opciones al <select>
                concessionairesOut.forEach(concessionaire => {
                    const option = document.createElement('option');
                    option.value = concessionaire.id;
                    option.text = concessionaire.name;
                    concessionairesInput.appendChild(option);
                });
            })
            .catch(error => console.error('Error buscando clientes:', error));
    }

    function editCustomer(index) {

        // console.log(index);
        // console.log(Customers[index]);
        if (index >= customers.length) {
            return;
        }

        const selectedElement = document.getElementById('customer-' + customers[index].id);

        // Obtenim tots els elements <customer> de la llista amb id = customersList
        const container = document.querySelector("#customersList");
        const rows = container.querySelectorAll("customer");
        // els posem els atributs de seleccionat a false a tots
        for (const row of rows) {
            row.setAttribute("selected", false);
        }
        // El que hem seleccionat l'activem
        selectedElement.setAttribute("selected", true);

        // Obtenim les dades del regitre seleccionat
        // i les posem en les caixes del formulari per poder editar-les                         
        selectedCustomer = customers[index];

        const nameInput = document.getElementById('nameInput');
        const phoneInput = document.getElementById('phoneInput');
        const emailInput = document.getElementById('emailInput');
        const addressInput = document.getElementById('addressInput');
        const userInput = document.getElementById('userInput');

        getConcessionaires();

        nameInput.value = selectedCustomer.name;
        phoneInput.value = selectedCustomer.phone_number;
        emailInput.value = selectedCustomer.email;
        addressInput.value = selectedCustomer.address;
        userInput.value = selectedCustomer.user_id;

        // Activem botons per cancel·lar l'operació d'actualització i per
        // esborrar el registre actiu
        deleteButton.style.visibility = 'visible';
        cancelButton.style.visibility = 'visible';

        const operationLabel = document.getElementById('operationLabel');
        operationLabel.innerText = "Actualizar Concesionario";
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