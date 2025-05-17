<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{
    public function getAllWithPaginate($perPage = 15)
    {
        return Patient::paginate($perPage);
    }

    public function create(array $data)
    {
        return Patient::create($data);
    }

    public function getEdit($id)
    {
        return Patient::findOrFail($id);
    }

    public function search($query)
    {
        return Patient::where('first_name', 'like', "%{$query}%")
                      ->orWhere('last_name', 'like', "%{$query}%")
                      ->get();
    }
}
