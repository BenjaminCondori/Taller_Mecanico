<x-layouts.app>
    <x-layouts.content title="Cotizaciones" subtitle="" name="Cotizaciones">
        <div class="row">
            <div class="col-12">
                <div class="mb-2 d-flex justify-content-between">
                    <div class="form-group">
                        <a href="{{ route('cotizacion.new') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle"></i>&nbsp;
                            Nueva Cotización
                        </a>
                    </div>
                </div>
                <div class="card-box">
                    <div class="table-responsive">
                        <table id="table-cotizaciones" class="table table-hover mb-0 dts">
                            <thead class="bg-dark text-center text-white text-nowrap">
                                <tr style="cursor: pointer">
                                    <th scope="col">ID</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Monto Total</th>
                                    <th scope="col">Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cotizacionesConNombreCliente == null)
                                    <tr class="text-nowrap text-center">
                                        <th scope="row" class="align-middle">No hay cotizaciones</th>
                                    </tr>
                                @else
                                    @foreach ($cotizacionesConNombreCliente as $cotizacion)
                                    <tr class="text-nowrap text-center">
                                        <th scope="row" class="align-middle">{{ $cotizacion['id'] }}</th>
                                        <td class="align-middle">{{ $cotizacion['cliente_nombre'] }} {{ $cotizacion['cliente_apellido'] }}</td>
                                        <td class="align-middle">{{ $cotizacion['precio'] }}</td>
                                        <td class="align-middle">{{ $cotizacion['fecha'] }}</td>
                                        <td class="align-middle text-nowrap">
                                            <a href="{{ route('cotizacion.show', $cotizacion['id']) }}" title="Ver detalles"
                                                class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('cotizacion.create', $cotizacion['id']) }}" title="Editar" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                            <a href="{{ route('cotizacion.delete', $cotizacion['id']) }}" title="Eliminar"
                                                class="btn btn-sm btn-danger" data-confirm-delete="true"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.content>
</x-layouts.app>
