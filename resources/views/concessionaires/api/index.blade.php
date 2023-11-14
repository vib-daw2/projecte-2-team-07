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
                <list id="concessionaireList">

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
    cancelButton.addEventListener('click', reset);
    const deleteButton = document.getElementById('deleteButton');
    deleteButton.addEventListener('click', deleteRegister);


    async function saveRegister(event) {

        event.preventDefault();
        console.log('gaurdamos....');

    }

    async function reset(event) {
        event.preventDefault()
        console.log('cancelamos....');
        const messagesDiv = document.getElementById('messagesDiv');
        const nameInput = document.getElementById('nameInput');
        const operationLabel = document.getElementById('operationLabel');

        operationLabel.innerText = 'Nuevo Concesionario';
        nameInput.value = "";
        // deshabilita botons de cance·lar i esborrar            
        //deleteButton.classList.add("invisible"); // classe Bootstrap
        deleteButton.style.visibility = 'visible';
        //cancelButton.classList.remove("invisible"); // Treiem la classe Bootstrap
        cancelButton.style.visibility = 'visible';
    }


    async function deleteRegister(event) {

        event.preventDefault();
        console.log('borramos....');
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
    // Per provar:

    // Amagar en Bootstrap
    // document.getElementById('messagesDiv').classList.add("d-none"); 
    // Amagar element Javascript
    //document.getElementById('messagesDiv').style.display = "none";

    // showMessages("message","Bon dia!!")
    // showMessages("error","Uppss! Fa fred!!")
    // showMessages("error", ["plou", "fa fred", "tinc febre"])
</script>
@endsection