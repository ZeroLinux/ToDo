@extends('layout')
@section('content')

<div id="app" class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
        <div class="mt-2 text-gray-600 dark:text-gray-400">
            <form v-on:submit.prevent id="myForm" class="was-validated">
                @csrf
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend">Consultar</legend>
                    <p>Desde aquí podrá buscar los To Do por su número de identificación.</p>
                    <div class="uk-margin uk-width-1-6@m">
                        <input class="uk-input" type="text" v-model="todo.id" v-on:focus="clear();" placeholder="To Do Number" pattern="[0-9]{1,3}" required>
                        <button v-if="todo.id >= 1" class="uk-button uk-button-secondary" v-on:click="searchById();">Consultar</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="mt-2 text-gray-600 dark:text-gray-400" v-if="todo.userId != ''">
            <fieldset class="uk-fieldset">
                <legend class="uk-legend">Resultados</legend>
                <div class="uk-card uk-card-secondary uk-card-body">
                    <span v-if="todo.completed" class="uk-label uk-label-success">Completada</span>
                    <span v-if="!todo.completed" class="uk-label uk-label-warning">Pendiente</span>
                    <h3 class="uk-card-title">Tarea #@{{todo.id}}</h3>
                    <p>@{{todo.title}}</p>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/todo.js"></script>

@endsection