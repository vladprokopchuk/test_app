<?php


namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class CreateApartmentRequest extends BaseRequest {


    #[Assert\NotBlank(message: "Field 'number' should not be blank")]
    #[Assert\Type(type: "integer", message: "Field 'number' should be integer")]
    public  $number = null;

    #[Assert\NotBlank(message: "Field 'house_id' should not be blank")]
    #[Assert\Type("integer",  message: "Field 'house_id' should be integer")]
    public  $house_id;

}
