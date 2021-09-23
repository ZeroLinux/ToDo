@extends('layout')
@section('content')

<div id="app" class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
        <div class="mt-2 text-gray-600 dark:text-gray-400">
            <form v-on:submit.prevent id="myForm" class="was-validated">
                @csrf
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend">Administrar</legend>
                    <p>Desde aquí podrá editar o eliminar los To Do.</p>
                    <div class="uk-margin uk-width-1-6@m">
                        <input class="uk-input" type="text" v-model="todo.title" required>
                        <select class="uk-select" v-model="todo.completed">
                            <option value="0">Completado</option>
                            <option value="1">Pendiente</option>
                        </select>
                        <button v-if="todo.id >= 1" class="uk-button uk-button-secondary" v-on:click="save();">Guardar</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="mt-2 text-gray-600 dark:text-gray-400">
            <div class="uk-overflow-auto">
                <table id="dataTable" class="uk-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>To Do</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/todo.js"></script>

@endsection