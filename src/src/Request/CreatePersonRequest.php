<?php


namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class CreatePersonRequest extends  BaseRequest {


    #[Assert\NotBlank(message: "Field 'name' should not be blank")]
    #[Assert\Type(type: "string", message: "Field 'name' should be string")]
    public  $name = null;

    #[Assert\NotBlank(message: "Field 'last_name' should not be blank")]
    #[Assert\Type(type: "string", message: "Field 'last_name' should be string")]
    public  $last_name = null;

    #[Assert\NotBlank(message: "Field 'personal_id_number' should not be blank")]
    #[Assert\Type(type: "string", message: "Field 'personal_id_number' should be string")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "The string must contain only letters and numbers."
    )]
    public $personal_id_number = null;

    #[Assert\NotBlank(message: "Field 'apartment_id' should not be blank")]
    #[Assert\Type("integer",  message: "Field 'apartment_id' should be integer")]
    public  $apartment_id;

}
