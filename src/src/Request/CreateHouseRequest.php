<?php


namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class CreateHouseRequest extends  BaseRequest {

    #[Assert\NotBlank(message: "Field 'number' should not be blank")]
    #[Assert\Type(type: "integer", message: "Field 'street_name' should be integer")]
    public $number = null;

    #[Assert\NotBlank(message: "Field 'street_name' should not be blank")]
    #[Assert\Type(type: "string", message: "Field 'street_name' should be the string")]
    public $street_name = null;

}
