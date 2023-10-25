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
            // Limpiar el formulario después de una operación exitosa
            $('#nombre').val('');
            $('#precio').val('');
            $('#cantidad').val('');
        } else {
            alert('Error al guardar el producto.');
        }
    });
});

    // Botón Modificar
    $('#btnModificar').click(function() {
        // Aquí puedes implementar la lógica para modificar un producto utilizando AJAX
        // con el valor ingresado en el campo ID y los demás valores del formulario.
    });

    // Botón Eliminar (para eliminar un producto)
    $('#btnEliminar').click(function() {
        const idProducto = $('#id_producto').val();

        // Realiza una solicitud AJAX para eliminar un producto por ID
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

// Botón Actualizar (para enviar los datos actualizados)
$('#btnActualizar').click(function() {
    const idProducto = $('#id_producto').val();
    const nombre = $('#nombre').val();
    const precio = $('#precio').val();
    const cantidad = $('#cantidad').val();

    // Realiza una solicitud AJAX para actualizar el producto
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
                // Puedes realizar alguna otra acción aquí, como actualizar la lista de productos.
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
