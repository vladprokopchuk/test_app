<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class GetPersonsListRequest extends BaseRequest {

    #[Assert\Type(type: "string", message: "Field 'name' should be string")]
    public $name = null;

    #[Assert\Type(type: "string", message: "Field 'last_name' should be string")]
    public $last_name = null;

    #[Assert\Type(type: "string", message: "Field 'personal_id_number' should be string")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "The string must contain only letters and numbers."
    )]
    public $personal_id_number = null;

    #[Assert\Type(type: "integer", message: "Field 'apartment_number' should be integer")]
    public $apartment_number = null;

    #[Assert\Type(type: "integer", message: "Field 'house_number' should be integer")]
    public $house_number = null;

    #[Assert\Type(type: "string", message: "Field 'street_name' should be the string")]
    public  $street_name = null;

    #[Assert\Type(type: "integer", message: "Field 'limit' should be the integer. Pagination limit for one page")]
    public  $limit = null;

    #[Assert\Type(type: "integer", message: "Field 'page' should be the integer. Page number for pagination")]
    public  $page = null;

}
