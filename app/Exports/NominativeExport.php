<?php

namespace App\Exports;

use App\Models\Dropping;
use App\Models\DroppingDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class NominativeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dropping::all();
    }
}
