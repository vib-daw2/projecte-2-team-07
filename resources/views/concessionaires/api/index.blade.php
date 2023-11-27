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
        <h1 class="pb-2">Concesionarios</h1>
        <div class="row mt-2">
            <!-- Formulari alta/actualització  -->
            <div class="col-6">
                <div class="card  rounded-0">
                    <div class="card-header bg-dark text-white  rounded-0">
                        <label id="operationLabel" class="fw-bold text-uppercase">Operation</label>
                    </div>
                    <div class="card-body div-form">
                        <form>
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">Nombre Concesionario</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" id="nameInput" class="form-control" />
                                </div>
                                <label class="col-md-4 col-form-label text-md-end">Teléfono</label>
                                <div class="col-md-6">
                                    <input type="text" name="phone_number" id="phoneInput" class="form-control" />
                                </div>
                                <label class="col-md-4 col-form-label text-md-end">Correo electrónico</label>
                                <div class="col-md-6">
                                    <input type="text" name="email" id="emailInput" class="form-control" />
                                </div>
                                <label class="col-md-4 col-form-label text-md-end">Dirección</label>
                                <div class="col-md-6">
                                    <input type="text" name="address" id="addressInput" class="form-control" />
                                </div>
                                <label class="col-md-4 col-form-label text-md-end">Coordenadas</label>
                                <div class="col-md-6">
                                    <input type="text" name="coordinates" id="coordinatesInput" class="form-control" />
                                </div>
                                <label class="col-md-4 col-form-label text-md-end">Foto</label>
                                <div class="col-md-6">
                                    <input type="text" name="picture" id="pictureInput" class="form-control" />
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
            <div class="col-6">
                <list id="concessionairesList">
                </list>
                <!-- Barra navegació -->
                <div class="mt-4 p-2 border">
                    <paginacio class="pagination justify-content-center" id="pagination-numbers">
                    </paginacio>
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
    const url = 'http://localhost:8000/api/concessionaires';

    // Número pàgines del llistat
    let last_page = 0;
    // Número de registres per pàgina
    let per_page = 0;
    // Pàgina actual
    let currentPage = 1;
    // llista de concessionaires
    let concessionaires = [];
    // Referència al concessionaire seleccionat
    let selectedConcessionaire;

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
        if (selectedConcessionaire === undefined) {
            newConcessionaire = {
                id: undefined,
                name: document.getElementById("nameInput").value,
                phone_number: document.getElementById("phoneInput").value,
                email: document.getElementById("emailInput").value,
                address: document.getElementById("addressInput").value,
                coordinates: document.getElementById("coordinatesInput").value,
                picture: document.getElementById("pictureInput").value
            }
            await newRegister(newConcessionaire);

        } else { // Si l'objecte té valor, farem una actualització
            // Recuperem les dades de la caixa i les posem en els atributs de selectedSuperhero
            selectedConcessionaire.name = document.getElementById("nameInput").value
            selectedConcessionaire.name = document.getElementById("phoneInput").value
            selectedConcessionaire.name = document.getElementById("emailInput").value
            selectedConcessionaire.name = document.getElementById("addressInput").value
            selectedConcessionaire.name = document.getElementById("coordinatesInput").value
            selectedConcessionaire.name = document.getElementById("pictureInput").value
            await updateRegister(selectedConcessionaire);
        }
    }

    async function newRegister(newData) {

    }

    //////////////////////////////////////////////////////////////////////////
    // updateRegister()
    // Crida a l'API remota per actualitzar un registre (PUT)
    //////////////////////////////////////////////////////////////////////////
    async function updateRegister(selectedConcessionaire) {
        try {
            const response = await fetch(url + '/' + selectedConcessionaire.id, {
                method: 'PUT',
                body: JSON.stringify(selectedConcessionaire),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                const selectedTr = document.getElementById('concessionaire-' + selectedConcessionaire.id);
                selectedTr.innerHTML = data.data.name;

                showMessages('message', "Concessionario actualizado correctamente");
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
        const coordinatesInput = document.getElementById('coordinatesInput');
        const pictureInput = document.getElementById('pictureInput');
        const operationLabel = document.getElementById('operationLabel');

        operationLabel.innerText = 'Nuevo Concesionario';
        nameInput.value = "";
        phoneInput.value = "";
        emailInput.value = "";
        addressInput.value = "";
        coordinatesInput.value = "";
        pictureInput.value = "";
        // deshabilita botons de cance·lar i esborrar            
        //deleteButton.classList.add("invisible"); // classe Bootstrap
        deleteButton.style.visibility = 'hidden';
        //cancelButton.classList.remove("invisible"); // Treiem la classe Bootstrap
        cancelButton.style.visibility = 'hidden';

        // Desmarquem el seleccionat
        if (selectedConcessionaire !== undefined) {
            const currentElement = document.getElementById("concessionaire-" + selectedConcessionaire.id);
            currentElement.removeAttribute("selected");
        }
        selectedConcessionaire = undefined;
    }

    async function deleteRegister(event) {
        event.preventDefault();
        console.log('borramos....');
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
                    'Accept': 'application/json'
                },
            });

            if (response.ok) {
                const json = await response.json();
                concessionaires = json.data.data;
                // console.log(concessionaires) salen los concess¡ionarios? ??
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
                },
                body: JSON.stringify(newData)
            });

            const data = await response.json();
            if (response.ok) {

                reloadListAndPagination(url);

                showMessages('message', 'Concesionario añadido correctamente');
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
            const response = await fetch(url + '/' + selectedConcessionaire.id, {
                method: 'DELETE'
            });
            const json = await response.json();
            if (response.ok) { // codi 200

                const message = "Concesionario: " + json.data.name + " esborrat.";
                reset();
                showMessages('message', message);
                // Recreem taula per veure els canvis                   
                reloadListAndPagination(url);

            } else {
                showMessages('error', "Error en esborrar el Concesionario amb codi " + selectedConcessionaire.id + ".<br>" +
                    "Seguramente un vehiculo ha sido introducido en este concesionario.");
            }

        } catch (error) {
            showMessages('error', 'Error accedint a les dades remotes.');
        }
    }

    async function reloadListAndPagination(url) {
        // Obtinc les dades del servidor
        await getList(url);
        //... concessionaires, per_page, last_page disponibles ...  
        loadIntoList()

        // encara no tenim pagination 
    }


    // Per provar:

    // Amagar en Bootstrap
    // document.getElementById('messagesDiv').classList.add("d-none"); 
    // Amagar element Javascript
    //document.getElementById('messagesDiv').style.display = "none";

    // showMessages("message","Bon dia!!")
    // showMessages("error","Uppss! Fa fred!!")
    // showMessages("error", ["plou", "fa fred", "tinc febre"])

    getList(url);
    // Que surt per la consola si fem aquí:  console.log(concessionaires); per que ??

    async function createEmptyList(per_page) {
        // Buido el contingut
        const dataTable = document.getElementById('concessionairesList');
        dataTable.innerHTML = "";

        for (var i = 0; i < per_page; i++) {
            addEmptyElement(i);
        }
    }

    function addEmptyElement(index) {
        const concessionaireElementList = document.getElementById('concessionairesList');
        const concessionaireElement = document.createElement('concessionaire');

        // Registrem event per quan cliquem sobre una fila de la taula            
        concessionaireElement.addEventListener('click', function() {
            editConcessionaire(index);
        });

        concessionaireElementList.appendChild(concessionaireElement);
    }

    function editConcessionaire(index) {
        // console.log(index);
        // console.log(concessionaires[index]);           
    }

    async function createListAndPagination() {
        // Obtinc les dades del servidor
        await getList(url);
        //... concessionaires, per_page, last_page disponibles ...                
        createEmptyList(per_page);
        loadIntoList()
        createPaginationBar();
    }

    async function loadIntoList() {

        // Obtenim tots els elements <concessionaire> de la llista amb id = concessionairesList
        const container = document.querySelector("#concessionairesList");
        const concessionaireElements = container.querySelectorAll("concessionaire");
        // Tots els elements <concessionaire> quedaran per exemple:   <concessionaire id='concessionaire-34' selected=false ...>
        for (let i = 0; i < concessionaires.length; i++) {
            concessionaireElements[i].setAttribute("selected", false);
            concessionaireElements[i].removeAttribute("deleted")

            concessionaireElements[i].innerHTML = concessionaires[i].name;
            // Posem id de l'estil concessionaire-0, ...
            concessionaireElements[i].setAttribute('id', 'concessionaire-' + concessionaires[i].id);

            // Cursor amb dit per seleccionar
            concessionaireElements[i].style = 'cursor: pointer';
        }
        // Si queden elements de la llista sense dades, les desactivem.
        for (let j = concessionaires.length; j < concessionaireElements.length; j++) {
            // cursor normal
            concessionaireElements[j].style = 'cursor: cursor';
            concessionaireElements[j].setAttribute("selected", false);
            // Els elements sense concessionaire tenen un estil diferent!
            concessionaireElements[j].setAttribute("deleted", true);
            concessionaireElements[j].innerHTML = "";
        }
    }
    
    function createPaginationBar() {
          
        const prevButton = document.createElement("button");
        prevButton.innerHTML = "<"; 
        prevButton.classList.add("navbutton");
        
        const nextButton = document.createElement("button");
        nextButton.innerHTML = ">"; 
        nextButton.classList.add("navbutton");

        prevButton.addEventListener("click", function () {     
            setCurrentPage(currentPage - 1);
        });

        nextButton.addEventListener("click", function()  {           
            setCurrentPage(currentPage + 1);
        });            

        const paginationNumbers = document.getElementById("pagination-numbers");
        paginationNumbers.appendChild(prevButton); 
        paginationNumbers.appendChild(nextButton);

    }

    async function setCurrentPage(pageNum)  {
        // Actualitzar la pàgina actual
        if(pageNum<1 || pageNum>last_page) return;

        currentPage = pageNum;
        
        // Carregar dades a la taula, passant la pàgina que vull obtenir
        await getList(url+'?page='+currentPage) ;
        loadIntoList();              
    }

    function editConcessionaire(index) {

        // console.log(index);
        // console.log(concessionaires[index]);
        if (index >= concessionaires.length) {
            return;
        }

        const selectedElement = document.getElementById('concessionaire-' + concessionaires[index].id);

        // Obtenim tots els elements <concessionaire> de la llista amb id = concessionairesList
        const container = document.querySelector("#concessionairesList");
        const rows = container.querySelectorAll("concessionaire");
        // els posem els atributs de seleccionat a false a tots
        for (const row of rows) {
            row.setAttribute("selected", false);
        }
        // El que hem seleccionat l'activem
        selectedElement.setAttribute("selected", true);

        // Obtenim les dades del regitre seleccionat
        // i les posem en les caixes del formulari per poder editar-les                         
        selectedConcessionaire = concessionaires[index];

        const nameInput = document.getElementById('nameInput');
        const phoneInput = document.getElementById('phoneInput');
        const emailInput = document.getElementById('emailInput');
        const addressInput = document.getElementById('addressInput');
        const coordinatesInput = document.getElementById('coordinatesInput');
        const pictureInput = document.getElementById('pictureInput');
        nameInput.value = selectedConcessionaire.name;
        phoneInput.value = selectedConcessionaire.phone_number;
        emailInput.value = selectedConcessionaire.email;
        addressInput.value = selectedConcessionaire.address;
        coordinatesInput.value = selectedConcessionaire.coordinates;
        pictureInput.value = selectedConcessionaire.picture;

        // Activem botons per cancel·lar l'operació d'actualització i per
        // esborrar el registre actiu
        deleteButton.style.visibility = 'visible';
        cancelButton.style.visibility = 'visible';

        const operationLabel = document.getElementById('operationLabel');
        operationLabel.innerText = "Actualizar Concesionario";
    }

    createListAndPagination();
    reset();  // mateix codi que reset(), sense paràmetre event!!
</script>
@endsection