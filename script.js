$(document).ready(function() {
    // Variables para los elementos del formulario y la tabla
    const productForm = $('#productForm');
    const productList = $('#productos').find('tbody');
    const idProdInput = $('#id_producto');
    const nombreInput = $('#nombre');
    const precioInput = $('#precio');
    const cantidadInput = $('#cantidad');

    // Botón Listar
    $('#btnListar').click(function() {
        productList.empty();
        idProdInput.val('');
        nombreInput.val('');
        precioInput.val('');
        cantidadInput.val('');

        $.ajax({
            url: 'abm.php?action=listar',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(index, product) {
                        var row = '<tr>' +
                            '<td>' + product.id + '</td>' +
                            '<td>' + product.nombre + '</td>' +
                            '<td>' + product.precio + '</td>' +
                            '<td>' + product.cantidad + '</td>' +
                            '</tr>';
                        productList.append(row);
                    });
                } else {
                    productList.append('<tr><td colspan="4">No hay productos para mostrar</td></tr>');
                }
            },
            error: function(error) {
                alert('Error al cargar la lista de productos.');
            }
        });
    });

  // Botón Agregar
$('#btnAgregar').click(function() {
    const nombre = $('#nombre').val();
    const precio = $('#precio').val();
    const cantidad = $('#cantidad').val();

    // Realizar la solicitud POST a abm.php con la opción "agregar" y los datos del producto
    $.post('abm.php', { accion: 'agregar', nombre, precio, cantidad }, function(response) {
        if (response === true) {
            alert('Producto guardado exitosamente.');
           
            $('#nombre').val('');
            $('#precio').val('');
            $('#cantidad').val('');
        } else {
            alert('Error al guardar el producto.');
        }
    });
});

    // Botón Eliminar 
    $('#btnEliminar').click(function() {
        const idProducto = $('#id_producto').val();

         $.ajax({
            url: 'abm.php',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'eliminar',
                id: idProducto
            },
            success: function(response) {
                if (response.success) {
                    alert('Producto eliminado exitosamente.');
                } else {
                    alert('Error al eliminar el producto.');
                }
            },
            error: function(error) {
                alert('Error en la solicitud AJAX.');
            }
        });
    });

$('#btnCargar').click(function() {
    const idProducto = $('#id_producto').val();
    console.log('ID del Producto:', idProducto);

    $.ajax({
        url: 'abm.php',
        type: 'POST',
        dataType: 'json',
        data: {
            accion: 'buscarPorId',
            id: idProducto
        },
        success: function(response) {
            if (response.success) {
                console.log('Producto encontrado:', response.producto);

                // Llena los campos del formulario con los datos del producto
                $('#nombre').val(response.producto.nombre);
                $('#precio').val(response.producto.precio);
                $('#cantidad').val(response.producto.cantidad);
            } else {
                alert('Producto no encontrado.');
            }
        },
        error: function(error) {
            console.error('Error en la solicitud AJAX:', error);
            alert('Error en la solicitud AJAX.');
        }
    });
});

// Boton actualizar
$('#btnActualizar').click(function() {
    const idProducto = $('#id_producto').val();
    const nombre = $('#nombre').val();
    const precio = $('#precio').val();
    const cantidad = $('#cantidad').val();
  
    $.ajax({
        url: 'abm.php',
        type: 'POST',
        dataType: 'json',
        data: {
            accion: 'actualizar',
            id: idProducto,
            nombre: nombre,
            precio: precio,
            cantidad: cantidad
        },
        success: function(response) {
            if (response.success) {
                alert('Producto actualizado exitosamente.');
                
            } else {
                alert('Error al actualizar el producto.');
            }
        },
        error: function(error) {
            alert('Error en la solicitud AJAX.');
        }
    });
    });
});
