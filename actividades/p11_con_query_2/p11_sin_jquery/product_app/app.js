// Variable para controlar si se está editando un producto
let edit = false;

// Función para inicializar la página
function init() {
    // Cargar todos los productos no eliminados al inicio
    fetchProducts();
}

// Función para cargar todos los productos no eliminados
function fetchProducts() {
    $.ajax({
        url: 'backend/product-list.php', // Endpoint que devuelve todos los productos no eliminados
        type: 'GET',
        success: function (response) {
            let products = JSON.parse(response);
            let template = '';
            if (products.length > 0) {
                // Construir la tabla con todos los productos no eliminados
                products.forEach(product => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + product.precio + '</li>';
                    descripcion += '<li>unidades: ' + product.unidades + '</li>';
                    descripcion += '<li>modelo: ' + product.modelo + '</li>';
                    descripcion += '<li>marca: ' + product.marca + '</li>';
                    descripcion += '<li>detalles: ' + product.detalles + '</li>';
                    template += `
                        <tr>
                            <td>${product.id}</td>
                            <td><a href="#" class="task-item" data-id="${product.id}">${product.nombre}</a></td>
                            <td>${descripcion}</td>
                            <td>
                                <button class="product-delete btn btn-danger" data-id="${product.id}" onclick="eliminarProducto(event)">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                // Mostrar un mensaje si no hay productos
                template = `
                    <tr>
                        <td colspan="4" class="text-center">No hay productos disponibles</td>
                    </tr>
                `;
            }
            // Actualizar la tabla con todos los productos no eliminados
            $('#products').html(template);
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}

$(document).on('click', '.task-item', function (event) {
    event.preventDefault(); // Evita que el enlace recargue la página
    let productId = $(this).data('id'); // Obtén el ID del producto
    console.log('ID del producto:', productId);

    $.post('backend/product-single.php', { id: productId }, function (response) {
        console.log('Respuesta del servidor:', response); // Depuración

        // Verifica si la respuesta es un objeto JSON válido
        if (typeof response === 'object' && response !== null) {
            // Cargar los datos del producto en el formulario
            $('#name').val(response.nombre);
            $('#marca').val(response.marca);
            $('#modelo').val(response.modelo);
            $('#precio').val(response.precio);
            $('#unidades').val(response.unidades);
            $('#detalles').val(response.detalles);
            $('#imagen').val(response.imagen);
            $('#productId').val(response.id);

            edit = true; // Establecer la variable edit en true
            $('#product-form button[type="submit"]').text('Modificar Producto');
        } else {
            console.error('La respuesta del servidor no es un objeto JSON válido:', response);
        }
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
        console.log('Respuesta del servidor:', jqXHR.responseText); // Muestra la respuesta del servidor
    });
});

// Función para eliminar un producto
function eliminarProducto(event) {
    if (confirm("¿De verdad deseas eliminar el producto?")) {
        // Obtener el ID del producto desde el atributo data-id del botón
        var id = $(event.target).data('id');

        // Realizar la solicitud AJAX para eliminar el producto
        $.ajax({
            url: 'backend/product-delete.php',
            type: 'GET',
            data: { id: id }, // Enviar el ID del producto
            success: function (response) {
                console.log(response);

                // Parsear la respuesta JSON
                let respuesta = JSON.parse(response);

                // Mostrar el estado de la operación en la barra de estado
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;

                // Hacer visible la barra de estado
                $('#product-result').removeClass('d-none').addClass('d-block');
                $('#container').html(template_bar);

                // Actualizar la lista de productos
                fetchProducts();
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    }
}

$(document).ready(function () {
    init(); // Inicializa la página

    // Mostrar un mensaje en la barra de estado al cargar la página
    let template_bar = `
        <li style="list-style: none;">status: success</li>
        <li style="list-style: none;">message: Página cargada correctamente</li>
    `;
    $('#product-result').removeClass('d-none').addClass('d-block');
    $('#container').html(template_bar);

    // Evento keyup para el campo de búsqueda
    $('#search').keyup(function (e) {
        let search = $('#search').val().trim(); // Obtener el valor del campo de búsqueda

        if (search) {
            // Realizar la búsqueda
            $.ajax({
                url: 'backend/product-search.php',
                type: 'GET',
                data: { search: search }, // Enviar el término de búsqueda al backend
                success: function (response) {
                    let products = JSON.parse(response);
                    let template = ``;
                    let productNames = ''; // Variable para almacenar los nombres de los productos

                    if (products.length > 0) {
                        // Construir la tabla con los productos encontrados
                        products.forEach(product => {
                            let descripcion = '';
                            descripcion += '<li>precio: ' + product.precio + '</li>';
                            descripcion += '<li>unidades: ' + product.unidades + '</li>';
                            descripcion += '<li>modelo: ' + product.modelo + '</li>';
                            descripcion += '<li>marca: ' + product.marca + '</li>';
                            descripcion += '<li>detalles: ' + product.detalles + '</li>';
                            template += `
                                <tr>
                                    <td>${product.id}</td>
                                    <td>${product.nombre}</td>
                                    <td>${descripcion}</td>
                                    <td>
                                        <button class="product-delete btn btn-danger" data-id="${product.id}" onclick="eliminarProducto(event)">Eliminar</button>
                                    </td>
                                </tr>
                            `;

                            // Agregar el nombre del producto a la lista de nombres
                            productNames += `<li>${product.nombre}</li>`;
                        });
                    } else {
                        // Mostrar un mensaje si no se encontraron productos
                        template = `
                            <tr>
                                <td colspan="4" class="text-center">No se encontraron productos</td>
                            </tr>
                        `;
                        productNames = '<li>No se encontraron productos</li>';
                    }

                    // Actualizar la tabla con los resultados de la búsqueda
                    $('#products').html(template);

                    // Actualizar la barra de estado con los nombres de los productos
                    $('#product-names').html(productNames);
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        } else {
            // Si el campo de búsqueda está vacío, cargar todos los productos no eliminados
            fetchProducts();

            // Limpiar la barra de estado
            $('#product-names').html('');
        }
    });
});

// Evento submit para el formulario de agregar/actualizar producto
$('#product-form').submit(function(e) {
    e.preventDefault();

    // Obtener los valores del formulario
    let nombre = $('#name').val().trim();
    let marca = $('#marca').val().trim();
    let modelo = $('#modelo').val().trim();
    let precio = parseFloat($('#precio').val());
    let unidades = parseInt($('#unidades').val());
    let detalles = $('#detalles').val().trim();
    let imagen = $('#imagen').val().trim();
    let productId = $('#productId').val();

    // Validaciones
    if (nombre === '' || nombre.length > 100) {
        $('#error-name').text('El nombre es obligatorio y no puede ser mayor a 100 caracteres');
        return;
    } else {
        $('#error-name').text('');
    }

    if (marca === '') {
        $('#error-marca').text('La marca es obligatoria');
        return;
    } else {
        $('#error-marca').text('');
    }

    if (modelo === '' || modelo.length > 20 || !/^[a-zA-Z0-9-]+$/.test(modelo)) {
        $('#error-modelo').text('El modelo es obligatorio, no puede ser mayor a 20 caracteres y solo puede contener letras, números y guiones');
        return;
    } else {
        $('#error-modelo').text('');
    }

    if (isNaN(precio) || precio <= 99.99) {
        $('#error-precio').text('El precio es obligatorio y debe ser un número mayor a 99.99');
        return;
    } else {
        $('#error-precio').text('');
    }

    if (detalles === '' || detalles.length > 100) {
        $('#error-details').text('Los detalles son obligatorios y no pueden ser mayores a 100 caracteres');
        return;
    } else {
        $('#error-details').text('');
    }

    if (isNaN(unidades) || unidades <= 0) {
        $('#error-unidades').text('Las unidades son obligatorias y deben ser un número mayor a 0');
        return;
    } else {
        $('#error-unidades').text('');
    }

    // Crear el objeto con los datos del formulario
    let postData = {
        nombre: nombre,
        marca: marca,
        modelo: modelo,
        precio: precio,
        unidades: unidades,
        detalles: detalles,
        imagen: imagen,
        id: productId
    };

    // Determinar la URL y el método HTTP según si es una edición o un nuevo producto
    let url = edit ? 'backend/product-update.php' : 'backend/product-add.php';
    let type = 'POST';

    // Enviar los datos al servidor
    $.ajax({
        url: url,
        type: type,
        data: JSON.stringify(postData),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function(response) {
            console.log("Respuesta del servidor:", response);

            if (response.status === 'success') {
                let template_bar = `
                    <li style="list-style: none;">status: ${response.status}</li>
                    <li style="list-style: none;">message: ${response.message}</li>
                `;
                $('#product-result').removeClass('d-none').addClass('d-block');
                $('#container').html(template_bar);

                // Reiniciar el formulario
                $('#product-form').trigger('reset');
                $('#productId').val('');
                $('#product-form button[type="submit"]').text('Agregar Producto');
                edit = false;

                // Actualizar la lista de productos
                fetchProducts();
            } else {
                alert(response.message || 'Error al procesar el producto');
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            console.error("Respuesta del servidor:", xhr.responseText);
        }
    });
});

// Validaciones al perder el foco
$('#name').on('blur', function() {
    let nombreProducto = $(this).val().trim();
    
    if (nombreProducto.length === 0 || nombreProducto.length > 100) {
        $('#error-name').text('Máximo 100 caracteres y no puede estar vacío');
        return;
    } else {
        $('#error-name').text('');
    }
});

$('#marca').on('blur', function() {
    if ($(this).val() === "") {
        $('#error-marca').text('Seleccione una marca');
    } else {
        $('#error-marca').text('');
    }
});

$('#modelo').on('blur', function() {
    if (!$(this).val().match(/^[A-Za-z0-9-]+$/)) {
        $('#error-modelo').text('Solo caracteres alfanuméricos y guiones');
    } else {
        $('#error-modelo').text('');
    }
});

$('#precio').on('blur', function() {
    if (parseFloat($(this).val()) < 100.00) {
        $('#error-precio').text('Debe ser mayor o igual a 100.00');
    } else {
        $('#error-precio').text('');
    }
});

$('#detalles').on('blur', function() {
    if ($(this).val().length > 100) {
        $('#error-details').text('Máximo 100 caracteres');
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
$('#name').keyup(function() {
  let nombreProducto = $(this).val().trim();

  if (nombreProducto.length > 0) {
      $.ajax({
          url: './backend/product-search_2.php',
          type: 'GET',
          data: { name: nombreProducto },
          success: function(response) {
              console.log(response);
              if (!response.error) {
                  // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                  const productos = JSON.parse(response);
                  if (Object.keys(productos).length > 0) {
                      // Si hay productos con el mismo nombre, mostrar error
                      $('#error-name').text('El nombre del producto ya existe.');
                  } else {
                      // Si no hay productos con el mismo nombre, limpiar el mensaje de error
                      $('#error-name').text('');
                  }

                  // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                  if (Object.keys(productos).length > 0) {
                      // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                      let template = '';
                      let template_bar = '';

                      productos.forEach(producto => {
                          // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                          let descripcion = '';
                          descripcion += '<li>precio: ' + producto.precio + '</li>';
                          descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                          descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                          descripcion += '<li>marca: ' + producto.marca + '</li>';
                          descripcion += '<li>detalles: ' + producto.detalles + '</li>';

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
  } else {
      // Si el campo de nombre está vacío, limpiar el mensaje de error
      $('#error-name').text('');

      // Si el campo de búsqueda está vacío, cargar todos los productos no eliminados
      fetchProducts();

      // Ocultar la barra de estado
      $('#product-result').hide();
  }
});