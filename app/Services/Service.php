<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Service
{
    public function create($array)
    {
        try {
            $result = DB::table($this->table)->insert($array);
        }catch(\Throwable $e){ // \Error | \Exception $e
            return $this->getFriendlyMessage($e);
        }

        return $result;
    }

    public function update($array)
    {
        try {
            $result = DB::table($this->table)
                    ->where('id',$array['id'])
                    ->update($array);
        }catch(\Throwable $e){ // \Error | \Exception $e
            return $this->getFriendlyMessage($e);
        }

        return $result;
    }

    public function destroy($array)
    {
        try {
            $result = DB::table($this->table)
                    ->where('id',$array['id'])
                    ->delete();
        }catch(\Throwable $e){ // \Error | \Exception $e
            return $this->getFriendlyMessage($e);
        }

        return $result;
    }

    public function getFriendlyMessage($e)
    {
        switch($e->getCode()){
            case '23000';
                return [
                    'message' => [$e->getMessage()]
                ];
                break;
            default :
                return [
                    'message' => [$e->getMessage()]
                ];
            break;
        }
    }
}
