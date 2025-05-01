// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

$(document).ready(function(){
    let edit = false;

    let JsonString = JSON.stringify(baseJSON,null,2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();
    function listarProductos() {
        $.ajax({
            url: 'http://localhost/tec_Web/actividades/a09/product_app/backend/products',
            type: 'GET',
            dataType: 'json', // <- Esto es clave para el parseo automático
            success: function(productos) { // 'productos' ya es un objeto (no necesitas JSON.parse)
                console.log("Datos recibidos:", productos);
                
                if(productos && productos.length > 0) {
                    let template = '';
    
                    productos.forEach(producto => {
                        let descripcion = `
                            <li>precio: ${producto.precio}</li>
                            <li>unidades: ${producto.unidades}</li>
                            <li>modelo: ${producto.modelo}</li>
                            <li>marca: ${producto.marca}</li>
                            <li>detalles: ${producto.detalles}</li>
                        `;
                        
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
                    });
                    
                    $('#products').html(template);
                } else {
                    console.warn("No se recibieron productos o el array está vacío");
                    $('#products').html('<tr><td colspan="4">No hay productos disponibles</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición:", status, error);
                $('#products').html('<tr><td colspan="4">Error al cargar los productos</td></tr>');
            }
        });
    }

    $('#search').keyup(function() {
        const searchTerm = $(this).val().trim();
        
        if(searchTerm) {
            $.ajax({
                url: `http://localhost/tec_Web/actividades/a09/product_app/backend/products/${encodeURIComponent(searchTerm)}`,
                type: 'GET',
                dataType: 'json',
                success: function(productos) {
                    // No necesitas JSON.parse porque dataType: 'json' ya lo hace
                    if(productos && productos.length > 0) {
                        let template = '';
                        let template_bar = '';
    
                        productos.forEach(producto => {
                            // Usamos template literals para mejor legibilidad
                            let descripcion = `
                                <li>precio: ${producto.precio}</li>
                                <li>unidades: ${producto.unidades}</li>
                                <li>modelo: ${producto.modelo}</li>
                                <li>marca: ${producto.marca}</li>
                                <li>detalles: ${producto.detalles}</li>
                            `;
                            
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
    
                            template_bar += `<li>${producto.nombre}</li>`;
                        });
    
                        $('#product-result').show();
                        $('#container').html(template_bar);
                        $('#products').html(template);
                    } else {
                        $('#product-result').hide();
                        $('#products').html('<tr><td colspan="4">No se encontraron productos</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la búsqueda:", error);
                    $('#product-result').hide();
                    $('#products').html('<tr><td colspan="4">Error al buscar productos</td></tr>');
                }
            });
        } else {
            $('#product-result').hide();
            listarProductos(); // Vuelve a listar todos los productos si el search está vacío
        }
    });
    $('#product-form').submit(e => {
        e.preventDefault();
    
        // Convierte el textarea en objeto
        const postData = JSON.parse($('#description').val());
        postData.nombre = $('#name').val();
        postData.id     = $('#productId').val();  // "" cuando es alta
    
        const url    = 'http://localhost/tec_Web/actividades/a09/product_app/backend/product';
        const method = edit ? 'PUT' : 'POST';
    
        $.ajax({
            url,
            method,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(postData),
            success: (respuesta) => {
                const template_bar = `
                    <li style="list-style:none;">status: ${respuesta.status}</li>
                    <li style="list-style:none;">message: ${respuesta.message}</li>`;
                $('#name').val('');
                $('#description').val(JSON.stringify(baseJSON, null, 2));
                $('#product-result').show();
                $('#container').html(template_bar);
                listarProductos();
                edit = false;
            }
        });
    });

    $(document).on('click', '.product-delete', function(e) {
        e.preventDefault();
        
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this).closest('tr'); // Selección más precisa
            const id = $(element).attr('productId');
            
            $.ajax({
                url: `http://localhost/tec_Web/actividades/a09/product_app/backend/product`,
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({ id: id }), // Envía el ID como JSON
                contentType: 'application/json', // Indica que envías JSON
                success: function(response) {
                    $('#product-result').hide();
                    listarProductos(); // Recarga la lista de productos
                },
                error: function(xhr, status, error) {
                    console.error("Error al eliminar:", error);
                    alert("No se pudo eliminar el producto");
                }
            });
        }
    });
    $(document).on('click', '.product-item', (e) => {
        e.preventDefault(); // Previene el comportamiento por defecto del enlace
        
        const element = $(e.currentTarget).closest('tr'); // Mejor selección del elemento padre
        const id = $(element).attr('productId');
        
        // Cambia la URL para usar tu API REST (GET /product/{id})
        $.ajax({
            url: `http://localhost/tec_Web/actividades/a09/product_app/backend/product/${id}`,
            type: 'GET',
            dataType: 'json',
            success: function(product) {
                // No necesitas JSON.parse, jQuery ya lo hace por dataType: 'json'
                $('#name').val(product.nombre);
                $('#productId').val(product.id);
                
                // Elimina campos no necesarios para el textarea
                const { nombre, eliminado, id: _, ...productDetails } = product;
                $('#description').val(JSON.stringify(productDetails, null, 2));
                
                edit = true; // Bandera de edición
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener el producto:", error);
                alert("No se pudo cargar el producto. Ver consola para detalles.");
            }
        });
    });   
});