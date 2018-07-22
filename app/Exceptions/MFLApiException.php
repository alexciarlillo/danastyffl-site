<?php

namespace App\Exceptions;

class MFLApiException extends \Exception
{
    public function __construct($query, $code)
    {
        $this->query = $query;
        $this->code = $code;
    }

    public function render()
    {
        return response()->json([
            'message' => "Problem fetching data from MFL API",
            'query' => $this->query,
            'code' => $this->code
        ], 400);
    }
}
