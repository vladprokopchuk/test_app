<?php


namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class GetApartmentListRequest extends BaseRequest {
    #[Assert\Type(type: "string", message: "Field 'person_name' should be string")]
    public $person_name = null;

    #[Assert\Type(type: "string", message: "Field 'person_last_name' should be string")]
    public $person_last_name = null;

    #[Assert\Type(type: "integer", message: "Field 'number' should be integer")]
    public $number = null;

    #[Assert\Type(type: "string", message: "Field 'street_name' should be the string")]
    public $street_name = null;

    #[Assert\Type(type: "integer", message: "Field 'limit' should be the integer. Pagination limit for one page")]
    public $limit = null;

    #[Assert\Type(type: "integer", message: "Field 'page' should be the integer. Page number for pagination")]
    public  $page = null;
}
