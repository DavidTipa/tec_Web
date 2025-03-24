

$(document).ready(function(){
    let edit = false;

  $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);
            
                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if(Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = `
                            <li>Precio: ${producto.precio}</li>
                            <li>Unidades: ${producto.unidades}</li>
                            <li>Modelo: ${producto.modelo}</li>
                            <li>Marca: ${producto.marca}</li>
                            <li>Detalles: ${producto.detalles}</li>
                     `;
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    }
    $('#name').keyup(function() {
        let nombreProducto = $(this).val().trim();
    
        if (nombreProducto.length > 0) {
            $.ajax({
                url: './backend/product-singleByName.php',
                type: 'GET',
                data: { name: nombreProducto },
                success: function(response) {
                    console.log(response);
                    if(!response.error) {
                       
                       
                    
                    
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        if(Object.keys(productos).length > 0) {
                            // Si hay productos con el mismo nombre, mostrar error
                            $('#error-name').text('El nombre del producto ya existe.');
                            $('#product-result').show();
                        } else {
                            // Si no hay productos con el mismo nombre, limpiar el mensaje de error
                            $('#error-name').text('');
                            
                            listarProductos();
                           
                            
                        }
                        
                         
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                        <button class="product-delete btn btn-danger">
                                             Eliminar
                                                </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template); 
                         
                        }
                        
                    }
                 
                    
                }
            });
        }
        else {
            $('#product-result').hide();
            
            
            
                
            
        }
        
    });
    
        
  // Validaciones al perder el foco
  $('#name').on('blur', function() {
    let nombreProducto = $(this).val().trim();
    
    if (nombreProducto.length === 0 || nombreProducto.length > 100) {
        $('#error-name').text('Máximo 100 caracteres y no puede estar vacío');
        return;
    }
 
    // Hacer una petición AJAX para verificar si el nombre existe
    
});

$('#marca').on('blur', function() {
    if ($(this).val() === "") {
        $('#error-marca').text('Seleccione una marca');
    } else {
        $('#error-marca').text('');
    }
});

$('#modelo').on('blur', function() {
    if (!$(this).val().match(/^[A-Za-z0-9 ]+$/)) {
        $('#error-modelo').text('Solo caracteres alfanuméricos');
    } else {
        $('#error-modelo').text('');
    }
});

$('#precio').on('blur', function() {
    if (parseFloat($(this).val()) < 100.00|| $(this).val().trim().length === 0) {
        $('#error-precio').text('Debe ser mayor o igual a 100.00 y no puede estar vacio');
    } else {
        $('#error-precio').text('');
    }
});

$('#detalles').on('blur', function() {
    if ($(this).val().length > 250) {
        $('#error-details').text('Máximo 250 caracteres');
    } else {
        $('#error-details').text('');
    }
});

$('#unidades').on('blur', function() {
    if (parseInt($(this).val()) < 0) {
        $('#error-unidades').text('Debe ser mayor o igual a 0');
    } else {
        $('#error-unidades').text('');
    }
});
    $('#search', ).keyup(function() {
        if($('#search',).val()) {
            let search = $('#search',).val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    if(!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);
                        
                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if(Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                            let template = '';
                            let template_bar = '';

                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: '+producto.precio+'</li>';
                                descripcion += '<li>unidades: '+producto.unidades+'</li>';
                                descripcion += '<li>modelo: '+producto.modelo+'</li>';
                                descripcion += '<li>marca: '+producto.marca+'</li>';
                                descripcion += '<li>detalles: '+producto.detalles+'</li>';
                            
                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();
        let isValid = true;
         // Validar campos
         if ($('#name').val().trim().length === 0 || $('#name').val().trim().length > 100) {
            $('#error-name').text('Máximo 100 caracteres y no puede estar vacío');
            isValid = false;
        } else if ($('#error-name').text() === 'El nombre del producto ya existe.') {
            // Evitar envío si el nombre ya existe
            isValid = false;
        }
        if ($('#marca').val() === "") {
            $('#error-marca').text('Seleccione una marca');
            isValid = false;
        }
        if (!$('#modelo').val().match(/^[A-Za-z0-9 ]+$/)) {
            $('#error-modelo').text('Solo caracteres alfanuméricos');
            isValid = false;
        }
        if (parseFloat($('#precio').val()) < 100.00) {
            $('#error-precio').text('Debe ser mayor o igual a 100.00');
            isValid = false;
        }
        if ($('#detalles').val().length > 250) {
            $('#error-details').text('Máximo 250 caracteres');
            isValid = false;
        }
        if (parseInt($('#unidades').val()) < 0) {
            $('#error-unidades').text('Debe ser mayor o igual a 0');
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        // SE CONVIERTE EL JSON DE STRING A OBJETO
        let postData = {
            nombre: $('#name').val(),
            marca: $('#marca').val(),
            modelo: $('#modelo').val(),
            precio: parseFloat($('#precio').val()),
            unidades: parseInt($('#unidades').val()),
            detalles: $('#detalles').val(),
            imagen: $('#imagen').val(),
            id: $('#productId').val()
        };
        /**
         * AQUÍ DEBES AGREGAR LAS VALIDACIONES DE LOS DATOS EN EL JSON
         * --> EN CASO DE NO HABER ERRORES, SE ENVIAR EL PRODUCTO A AGREGAR
         **/

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
            //console.log(response);
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let respuesta = JSON.parse(response);
            // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
            let template_bar = '';
            template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
                    $('#product-result').show();
                    $('#container').html(template_bar);
        
                    // Reiniciar el formulario
                    $('#product-form')[0].reset();
                    $('#productId').val('');
                    $('button.btn-primary').text("Agregar Producto");
                    edit = false;
        
                    // Actualizar la lista de productos
                    listarProductos();
        });
    });

    $(document).on('click', '.product-delete', function() {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this).closest('tr'); // Obtener la fila (tr) más cercana al botón clickeado
            const id = $(element).attr('productId'); // Obtener el ID del producto desde el atributo "productId"
    
            // Enviar una solicitud POST para eliminar el producto
            $.post('./backend/product-delete.php', { id }, (response) => {
                console.log(response); // Mostrar la respuesta del servidor en la consola
    
                // Convertir la respuesta a un objeto JSON (si es necesario)
                let respuesta = JSON.parse(response);
    
                // Crear una plantilla para mostrar el estado y el mensaje
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $('#container').html(template_bar);
                // Ocultar el resultado (si es necesario)
                $('#product-result').show();
    
                // Actualizar la lista de productos
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, (response) => {
            // SE CONVIERTE A OBJETO EL JSON OBTENIDO
            let product = JSON.parse(response);
            $('#name').val(product.nombre);
            $('#marca').val(product.marca);
            $('#modelo').val(product.modelo);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);

            $('button.btn-primary').text("Modificar Producto");
            // SE PONE LA BANDERA DE EDICIÓN EN true
            edit = true;
        });
        e.preventDefault();
    });    
});