<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Persons;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{

    public function index(Persons $person): object
    {
        return response()->json($person->all());
    }

    public function create(Persons $person, Request $request): object
    {
        $data = $request->json()->all();

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['status' => false, 'msg' => 'Błąd JSON: ' . json_last_error_msg()]);
        }

        $validator = Validator::make($request->all(), ['name' => 'required', 'surname' => 'required']);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()]);
        }

        $exist_person = $person->where('name', trim($data['name']))
            ->where('surname', trim($data['surname']))
            ->first();
        if ($exist_person) {
            return response()->json(['status' => false, 'msg' => 'Nie dodano rekordu. Osoba o wskazanym imieniu i nazwisku jest już w bazie danych. Id: ' . $exist_person->id]);
        }

        $person = new Persons;
        $person->name= trim($data['name']);
        $person->surname = trim($data['surname']);
        $person->save();

        return response()->json(['id' => $person->id, 'status' => true, 'msg' => 'Dodano rekord do bazy danych.']);
    }

    public function show(Persons $person, int $id): object
    {
        if (!is_int($id)) {
            return response()->json(['status' => false, 'msg' => 'Parametr {id} musi być typu int']);
        }

        $person = $person->find($id);

        if ($person) {
            return response()->json($person);
        }

        return response()->json(['status' => false, 'msg' => 'Brak osoby o id ' . $id . '.']);
    }

    public function update(Request $request, int $id): object
    {
        //Book::where('publication_place',"Warszawa")->update(['year' => 2010]);

        $data = $request->json()->all();

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['status' => false, 'msg' => 'Błąd JSON: ' . json_last_error_msg()]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()]);
        }

        $person_exists_id = DB::select('SELECT id FROM persons WHERE id=?', [$id]);
        if (!$person_exists_id) {
            return response()->json(['status' => false, 'msg' => 'Brak osoboy o id ' . $id]);
        }

        $person_exists = DB::select('SELECT id FROM persons WHERE name=? AND surname=?', [trim($data['name']), trim($data['surname'])]);
        if ($person_exists) {
            return response()->json(['status' => false, 'msg' => 'Osoba o podanym imieniu i nazwisko jest już w bazie danych. Id: ' . $person_exists[0]->id]);
        }

        DB::beginTransaction();
        try {
            DB::update('UPDATE persons SET name=?, surname=? WHERE id=?', [trim($data['name']), trim($data['surname']), $id]);
            DB::commit();
            return response()->json(['id' => $id, 'status' => true, 'msg' => 'Zaktualizowano osobę o id ' . $id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'msg' => $e]);
        }
    }

    public function destroy(Persons $person, int $id): object
    {
        $person = $person->find($id);

        if ($person) {
            $person->delete();
            return response()->json(['id' => $id, 'status' => true, 'msg' => 'Usunięto osobę o id ' . $id]);
        }
        return response()->json(['status' => false, 'msg' => 'Nie usunięto rekordu. Brak osoby o id ' . $id]);
    }
}
