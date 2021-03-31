<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{

    public function index(): object
    {
        $persons = DB::select("SELECT * FROM persons");
        return response()->json($persons);
    }

    public function create(Request $request): object
    {
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

        $person = DB::select('SELECT id FROM persons WHERE name=? AND surname=?', [trim($data['name']), trim($data['surname'])]);
        if ($person) {
            return response()->json(['status' => false, 'msg' => 'Nie dodano rekordu. Osoba o wskazanym imieniu i nazwisku jest już w bazie danych. Id: '.$person[0]->id]);
        }

        DB::beginTransaction();
        try {
            DB::insert('INSERT INTO persons (name, surname) values (?, ?)', [trim($data['name']), trim($data['surname'])]);
            DB::commit();
            return response()->json(['id' => DB::getPdo()->lastInsertId(), 'status' => true, 'msg' => 'Dodano rekord do bazy danych.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'msg' => $e]);
        }
    }

    public function show(int $id): object
    {
        if(!is_int($id)){
            return response()->json(['status' => false, 'msg' => 'Parametr {id} musi być typu int']);
        }

        $person = DB::select("SELECT * FROM persons WHERE id=?", [$id]);

        if ($person) {
            return response()->json($person[0]);
        }

        return response()->json(['status' => false, 'msg' => 'Brak osoby o id ' . $id . '.']);
    }

    public function update(Request $request, int $id): object
    {
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

    public function destroy(int $id): object
    {
        DB::beginTransaction();
        try {
            $delete_person = DB::delete('DELETE FROM persons WHERE id=?', [$id]);
            DB::commit();
            if ($delete_person) {
                return response()->json(['id' => $id, 'status' => true, 'msg' => 'Usunięto osobę o id ' . $id]);
            }
            return response()->json(['status' => false, 'msg' => 'Nie usunięto rekordu. Brak osoby o id ' . $id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'msg' => $e]);
        }
    }
}
