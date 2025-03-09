// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
  "precio": 0.0,
  "unidades": 1,
  "modelo": "XX-000",
  "marca": "NA",
  "detalles": "NA",
  "imagen": "img/default.png"
};

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
      success: function(response) {
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
                          <td>${product.nombre}</td>
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
      error: function(xhr, status, error) {
          console.error('Error en la solicitud AJAX:', error);
      }
  });
}

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
          success: function(response) {
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
          error: function(xhr, status, error) {
              console.error('Error en la solicitud AJAX:', error);
          }
      });
  }
}

// Evento cuando el documento está listo
$(document).ready(function() {
  init(); // Inicializa la página

  // Evento keyup para el campo de búsqueda
  $('#search').keyup(function(e) {
      let search = $('#search').val().trim(); // Obtener el valor del campo de búsqueda

      if (search) {
          // Realizar la búsqueda
          $.ajax({
              url: 'backend/product-search.php',
              type: 'GET',
              data: { search: search }, // Enviar el término de búsqueda al backend
              success: function(response) {
                  let products = JSON.parse(response);
                  let template = '';
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
              error: function(xhr, status, error) {
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

// Evento submit para el formulario de agregar producto
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

  $.ajax({
      url: 'backend/product-add.php',
      type: 'POST',
      data: JSON.stringify(finalDescription),
      contentType: 'application/json; charset=utf-8',
      success: function(response) {
          console.log("Respuesta del servidor:", response);

          // Intentar extraer el JSON válido de la respuesta
          let jsonStart = response.indexOf('{');
          let jsonEnd = response.lastIndexOf('}');
          if (jsonStart >= 0 && jsonEnd >= 0) {
              let jsonString = response.slice(jsonStart, jsonEnd + 1);
              try {
                  let jsonResponse = JSON.parse(jsonString);
                  if (jsonResponse.status === 'success') {
                      window.alert('Producto agregado correctamente');
                      $('#product-form').trigger('reset');
                      fetchProducts();
                  } else {
                      alert(jsonResponse.message || 'Error al agregar el producto');
                  }
              } catch (error) {
                  console.error("Error al parsear JSON:", error);
                  console.error("Respuesta recibida:", response);
                  alert("Error en la respuesta del servidor. Revisa la consola para más detalles.");
              }
          } else {
              console.error("No se encontró un JSON válido en la respuesta:", response);
              alert("Error en la respuesta del servidor. Revisa la consola para más detalles.");
          }
      },
      error: function(xhr, status, error) {
          console.error("Error en la solicitud AJAX:", error);
          console.error("Respuesta del servidor:", xhr.responseText);
      }
  });
});