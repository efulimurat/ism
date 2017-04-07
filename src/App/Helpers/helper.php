<?php

use App\Models\BaseModel;

function aliases(BaseModel $Model, $data, $keepUndefineds = false) {
    $converted = [];
    foreach ($data as $key => $item) {
        $converted[$key] = [];
        foreach ((array) $item as $k => $v) {
            if (isset($Model->alias[$k])) {
                $converted[$key][$Model->alias[$k]] = $v;
            } elseif ($keepUndefineds == true) {
                $converted[$key][$k] = $v;
            }
        }
    }
    return ($converted);
}