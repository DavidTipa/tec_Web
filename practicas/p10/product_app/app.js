// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarProducto(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var busqueda = document.getElementById('search').value.trim();
    if(busqueda == '') {
        alert('Ingrese un valor para buscar');
        return;
    }

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');

            let productosTable = document.getElementById("productos");
            productosTable.innerHTML = ""; // LIMPIAR RESULTADOS ANTERIORES
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS

            if(productos.length === 0) {
                productosTable.innerHTML = "<tr><td colspan='3'>No se encontraron resultados</td></tr>";
                return;
            }
             productos.forEach(producto => {
                let descripcion = `
                    <li>precio: ${producto.precio || "N/A"}</li>
                    <li>unidades: ${producto.unidades || "N/A"}</li>
                    <li>modelo: ${producto.modelo || "N/A"}</li>
                    <li>marca: ${producto.marca || "N/A"}</li>
                    <li>detalles: ${producto.detalles || "N/A"}</li>
                `;

                let template = `
                    <tr>
                        <td>${producto.id}</td>
                        <td>${producto.nombre}</td>
                        <td><ul>${descripcion}</ul></td>
                    </tr>
                `;

                productosTable.innerHTML += template;
            });

            /*if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }

    */
        }
   };
    client.send("busqueda=" + encodeURIComponent(busqueda));
}

function agregarProducto(e) {
    e.preventDefault();

    var nombreProducto = document.getElementById('name').value.trim();
    var productoJsonString = document.getElementById('description').value.trim();
    let finalJSON;

    try {
        finalJSON = JSON.parse(productoJsonString);
    } catch (error) {
        window.alert("El JSON no tiene un formato válido. Por favor, verifica que el JSON esté bien formado.");
        return;
    }

    // VALIDACIONES
    if (!nombreProducto || nombreProducto.length > 100) {
        window.alert("El nombre del producto no puede estar vacío y debe tener máximo 100 caracteres.");
        return;
    }

    if (typeof finalJSON.precio !== 'number' || finalJSON.precio < 100 || finalJSON.precio > 1000000) {
        window.alert('El precio debe ser un numero valido, mayor o igual a 100 y menor o igual a 1,000,000.');
        return;
    }

    if (typeof finalJSON.unidades !== 'number' || finalJSON.unidades < 0 || finalJSON.unidades > 10000) {
        window.alert('Las unidades deben ser un número válido, mayor o igual a 0 y menor o igual a 10,000.');
        return;
    }

    if (!finalJSON.modelo || !/^[A-Za-z0-9 ]+$/.test(finalJSON.modelo) || finalJSON.modelo.length > 50) {
        window.alert('El modelo solo puede contener caracteres alfanuméricos y debe tener máximo 50 caracteres.');
        return;
    }

    if (!finalJSON.marca || finalJSON.marca.trim() === '' || finalJSON.marca.length > 50) {
        window.alert('La marca no puede estar vacía y debe tener máximo 50 caracteres.');
        return;
    }

    if (!finalJSON.detalles || finalJSON.detalles.length > 250) {
        window.alert('Los detalles no pueden estar vacíos y deben tener máximo 250 caracteres.');
        return;
    }

    if (!finalJSON.imagen || !/^https?:\/\/.+\.(jpg|jpeg|png|gif)$/i.test(finalJSON.imagen)) {
        window.alert('La imagen debe ser una URL válida y debe terminar en .jpg, .jpeg, .png o .gif.');
        return;
    }

    // Agregar el nombre al JSON y convertirlo en string
    finalJSON['nombre'] = nombreProducto;
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    // Enviar al backend
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            alert("Producto agregado con éxito.");
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}
client.onreadystatechange = function () {
    if (client.readyState == 4 && client.status == 200) {
        // Parsear la respuesta del servidor
        let response = JSON.parse(client.responseText);

        // Mostrar el mensaje en un alert
        if (response.status === 'success') {
            alert(response.message); // Mensaje de éxito
        } else {
            alert(response.message); // Mensaje de error
        }
    }
};
