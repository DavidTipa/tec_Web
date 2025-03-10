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


function fetchProducts() {
  $.ajax({
    url: 'backend/product-list.php',
    type: 'GET',
    success: function (response) {
      let products = JSON.parse(response);
      let template = '';
      if (products.length > 0) {
       
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
 
      $('#name').val(response.nombre); // Nombre
      $('#productId').val(response.id); // ID (campo oculto)
      $('#description').val(JSON.stringify(response, null, 2)); 
      edit = true; // Establecer la variable `edit` en true
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
    
    var id = $(event.target).data('id');

  
    $.ajax({
      url: 'backend/product-delete.php',
      type: 'GET',
      data: { id: id }, 
      success: function (response) {
        console.log(response);

      
        let respuesta = JSON.parse(response);

     
        let template_bar = `
          <li style="list-style: none;">status: ${respuesta.status}</li>
          <li style="list-style: none;">message: ${respuesta.message}</li>
        `;

        // Hacer visible la barra de estado
        $('#product-result').removeClass('d-none').addClass('d-block');
        $('#container').html(template_bar);

        
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

 
  $('#search').keyup(function (e) {
    let search = $('#search').val().trim(); 

    if (search) {
      
      $.ajax({
        url: 'backend/product-search.php',
        type: 'GET',
        data: { search: search },
        success: function (response) {
          let products = JSON.parse(response);
          let template = '';
          let productNames = ''; 

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
    dataType: 'json', 
    success: function(response) {
      console.log("Respuesta del servidor:", response);

     
      if (typeof response === 'object' && response !== null) {
        if (response.status === 'success') {
          window.alert('Producto actualizado correctamente');
          $('#product-form').trigger('reset');
          $('#productId').val(''); 
          $('#product-form button[type="submit"]').text('Agregar Producto'); // Restaurar el texto del botón
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