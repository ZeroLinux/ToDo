<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{

    /**
     * Muestra todos los registros de la base de datos
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $todo = Todo::get();
        return response()->json($todo);
    }

    /**
     * Consulta por Id la API de jsonplaceholder y trae la información del To Do
     * Luego para la respuesta al método store para hacerlo persistente.
     *
     * @param number $id Número de identificación del ToDo a consultar
     * @return request $request Respuesta de datos en objeto tipo request
     */
    public function getById($id)
    {

        $url = 'https://jsonplaceholder.typicode.com/todos/' . $id ;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);

        $response = json_decode($response, true);

        //Creamos un objeto tipo request a partir de los datos obtenidos:
        $request = new \Illuminate\Http\Request();
        $request->replace($response);

        //Llamamos al método store para guardar los datos:
        return $this->store($request);

    }

    /**
     * Guardar registro en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $response = Todo::updateOrCreate(
                [ 'id' => $request->id ],
                $request->all()
            );
            return response()->json($response);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    /**
     * Eliminar un registro de la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        try {
            $response = Todo::where('id', $id)->delete();
            return response()->json($response);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

}
