// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };
  
  // Variable para controlar si se está editando un producto
  let edit = false;
  
  // Función para inicializar la página
  function init() {
    // Convertir el JSON base a string y mostrarlo en el textarea
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
  
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
        //$('#productId').val(response.id); 
        $('#description').val(JSON.stringify(response, null, 2))
        edit = true; // Establecer la variable edit en true
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
  
    let inputName = $('#name').val();
    if (inputName == '' || inputName.length > 100) {
      window.alert('El nombre es obligatorio y no puede ser mayor a 100 caracteres');
      return;
    }
  
    let inputDescription = $('#description').val();
    if (!inputDescription) {
      window.alert('La descripción es obligatoria');
      return;
    }
  
    let finalDescription; // Declarar la variable antes del bloque try
    try {
      finalDescription = JSON.parse(inputDescription);
    } catch (error) {
      window.alert('La descripción no es un JSON válido');
      return;
    }
    finalDescription.nombre = inputName;
  
    // Validaciones adicionales (marca, modelo, precio, detalles, unidades)
    if (!finalDescription.marca || finalDescription.marca.trim() === "") {
      window.alert('La marca es obligatoria');
      return;
    }
  
    if (!finalDescription.modelo || finalDescription.modelo.trim() === "" ||
      finalDescription.modelo.length > 20 || !/^[a-zA-Z0-9-]+$/.test(finalDescription.modelo)) {
      window.alert('El modelo es obligatorio, no puede ser mayor a 20 caracteres y solo puede contener letras, números y guiones');
      return;
    }
  
    let precioSubmit = parseFloat(finalDescription.precio);
    if (isNaN(precioSubmit) || precioSubmit <= 99.99) {
      window.alert('El precio es obligatorio y debe ser un número mayor a 99.99');
      return;
    }
  
    if (!finalDescription.detalles || finalDescription.detalles.trim() === "" || finalDescription.detalles.length > 100) {
      window.alert('Los detalles son obligatorios y no pueden ser mayores a 100 caracteres');
      return;
    }
  
    let unidadSubmit = parseFloat(finalDescription.unidades);
    if (isNaN(unidadSubmit) || unidadSubmit <= 0) {
      window.alert('Las unidades son obligatorias y deben ser un número mayor a 0');
      return;
    }
  
    let productId = $('#productId').val();
    let url = 'backend/product-update.php'; // Siempre usar update.php para guardar cambios
    let type = 'POST'; // Usar POST para enviar los datos
  
    $.ajax({
      url: url,
      type: type,
      data: JSON.stringify(finalDescription),
      contentType: 'application/json; charset=utf-8',
      dataType: 'json', // Asegúrate de que jQuery parsee la respuesta como JSON
      success: function(response) {
        console.log("Respuesta del servidor:", response);
  
        // Verifica si la respuesta es un objeto JSON válido
        if (typeof response === 'object' && response !== null) {
            if (response.status === 'success') {
                
                let template_bar = `
                    <li style="list-style: none;">status: ${response.status}</li>
                    <li style="list-style: none;">message: Producto actualizado correctamente</li>
                `;
                $('#product-result').removeClass('d-none').addClass('d-block');
                $('#container').html(template_bar);
            
              
                $('#product-form').trigger('reset');
                var JsonString = JSON.stringify(baseJSON, null, 2);
                    document.getElementById("description").value = JsonString;
                $('#productId').val(''); 
                $('#product-form button[type="submit"]').text('Agregar Producto');
                fetchProducts(); 
                edit = false; // Restablecer la variable `edit`
            } else {
                alert(response.message || 'Error al procesar el producto');
            }
        } else {
          console.error('La respuesta del servidor no es un objeto JSON válido:', response);
          alert("Error en la respuesta del servidor. Revisa la consola para más detalles.");
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        console.error("Respuesta del servidor:", xhr.responseText);
      }
    });
  });