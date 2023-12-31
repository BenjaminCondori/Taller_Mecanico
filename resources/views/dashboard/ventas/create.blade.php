<x-layouts.app>
    <x-layouts.content title="Añadir Productos" subtitle="" name="Añadir Productos">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="form-group px-4 pt-2">
                        <i class="fas fa-file-invoice-dollar fa-2x"></i>
                        <h3 class="fs-1 d-inline-block ml-1">Productos a vender</h3>
                    </div>

                    {{-- formulario para guardar productos --}}
                    <form id="nuevoProducto" class="px-4 pt-2" action="{{ route('ventas.storeProducto',$venta['id'])}}" method="post">
                        @csrf
                        <div class="row ">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="producto-id" class="control-label">Producto</label>
                                    @if (!empty($productos))
                                    <select class="form-control" id="producto" name="producto" oninput="actualizarPrecioUnitario(), actualizarPrecioCantidad()">
                                        <option value="">Selecciona un producto</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto['id'] }}"
                                            data-precio="{{ $producto['precio_venta'] }}">{{
                                            $producto['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <select class="form-control" id="producto" name="producto">
                                        <option value="">No hay productos registrados</option>
                                    </select>
                                    @endif
                                </div>
                            </div>
                          
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="precioUnitarioProducto" class="control-label">Precio Unitario</label>
                                    <input type="number" class="form-control" id="precioUnitarioProducto"
                                        name="precioUnitarioProducto" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="cantidadProducto" class="control-label">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidadProducto"
                                        oninput="actualizarPrecioCantidad()" name="cantidadProducto" value="">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="precioPorCantidadProducto" class="control-label">Precio por
                                        Cantidad</label>
                                    <input type="number" class="form-control" id="precioPorCantidadProducto"
                                     value="" name="precioPorCantidadProducto" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-column">
                                    {{-- este label nomas es para alinear el boton con los demas elementos sksksksk --}}
                                    <label for="agregarProducto" class="control-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary" id="agregarProducto"
                                        style="white-space: nowrap;">Agregar Producto
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Lista de productos agregados -->


                    <div class="form-group px-4">
                        <div class="table-responsive py-3">
                            <table id="table-ventaproducto" class="table table-hover mb-0 dts">
                                <thead class="bg-dark text-center text-white text-nowrap">
                                    <tr style="cursor: pointer">
                                        <th scope="col">Producto</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Sub total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$venta['productos'])
                                    <tr class="text-nowrap text-center">
                                        <th scope="row" class="align-middle">Sin Productos</th>
                                    </tr>
                                    @else
                                        @foreach ($venta['productos'] as $ventaProducto)
                                            <tr class="text-nowrap text-center">
                                                <th scope="row" class="align-middle">{{ $ventaProducto['nombre'] }}
                                                </th>
                                                <td class="align-middle">{{ $ventaProducto['pivot']['producto_cantidad'] }}</td>
                                                <td class="align-middle">{{ $ventaProducto['pivot']['producto_preciototal'] }}</td>
                                                <td class="align-middle text-nowrap" style="width: 200px">
                                                    <div class="d-flex justify-content-center">
                                                        <form id="formDeleteventaProducto_{{ $ventaProducto['id'] }}"
                                                            action="{{ route('ventas.deleteProducto', ['id' => $venta['id'], 'producto_id' => $ventaProducto['pivot']['producto_id']]) }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit" title="Eliminar"
                                                                class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group text-left">
                            <label for="precioTotal" class="control-label" style="text-align: left;">
                                <h3>TOTAL:</h3>
                            </label>
                            <input type="number" class="form-control" id="precioTotal" name="precioTotal"
                                readonly style="text-align: left" value="{{$venta['monto']}}">
                        </div>

                        <br>
                        <a href="{{ route('ventas.index') }}" class="btn btn-primary waves-effect waves-light mx-1 float-right">
                            Guardar
                        </a>

                        <div >
                            <form id="formDeleteVenta_{{ $venta['id'] }}"
                            action="{{ route('ventas.delete', $venta['id']) }}"method="post">
                                @csrf
                                <div class="mx-1">
                                    <button type="button" title="Eliminar"
                                     onclick="confirmDelete({{ $venta['id'] }})" class="btn btn-danger waves-effect m-l-5 float-right">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                    
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.content>

    <script>
        function actualizarPrecioUnitario() {
            var productoSelect = document.getElementById('producto');
            var precioUnitarioInput = document.getElementById('precioUnitarioProducto');
    
            // Obtén el precio del atributo data-precio del elemento seleccionado
            var precioUnitario = parseFloat(productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio'));
    
            // Actualiza el valor del campo Precio Unitario
            precioUnitarioInput.value = isNaN(precioUnitario) ? '' : precioUnitario.toFixed(2);
        }

        function actualizarPrecioCantidad() {
        var cantidadInput = document.getElementById('cantidadProducto');
        var precioUnitarioInput = document.getElementById('precioUnitarioProducto');
        var precioPorCantidadInput = document.getElementById('precioPorCantidadProducto');

        // Obtén los valores de cantidad y precio unitario
        var cantidad = parseFloat(cantidadInput.value);
        var precioUnitario = parseFloat(precioUnitarioInput.value);

        // Calcula el precio por cantidad y actualiza el campo correspondiente
        var precioPorCantidad = isNaN(cantidad) || isNaN(precioUnitario) ? 0 : cantidad * precioUnitario;
        precioPorCantidadInput.value = precioPorCantidad.toFixed(2);
        }
    </script>

    @push('js')
    <script>
        function confirmDelete(id) {
                Swal.fire({
                    title: '¿Está seguro de cancelar la venta?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#556ee6',
                    cancelButtonColor: '#f46a6a',
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formId = 'formDeleteVenta_' + id;
                        var form = document.getElementById(formId);
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            }
    </script>
    @endpush

</x-layouts.app>