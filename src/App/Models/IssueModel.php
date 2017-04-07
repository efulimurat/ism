<?php

namespace App\Models;

class IssueModel implements BaseModel{
    
    public $alias = [
        "issue_id" => "id",
        "title" => "baslik",
        "content" => "aciklama",
        "created_at" => "kayit_tarihi",
        "updated_at" => "duzenleme_tarihi",
        "status" => "durum"
    ];
    
}