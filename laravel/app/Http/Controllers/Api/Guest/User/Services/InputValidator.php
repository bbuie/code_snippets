<?php

namespace App\Http\Controllers\Api\Guest\User\Services;

use Illuminate\Support\Facades\Validator;

class InputValidator {

    private $options = array(
        'name' => array('input_name'=>'name', 'rule'=>'required|string|max:255'),
        'email' => array('input_name'=>'email', 'rule'=>'required|string|email|max:255|unique:users'),
        'any_email' => array('input_name'=>'email', 'rule'=>'required|string|email|max:255'),
        'password' => array('input_name'=>'password', 'rule'=>'required|string|min:6|confirmed'),
        'single_password' => array('input_name'=>'password', 'rule'=>'required|string|min:6'),
    );

    private $selectedRules = array();

    public function __construct(array $ruleOptions) {

        $inputValidator = $this;

        foreach ($inputValidator->options as $option => $ruleArray){
            if (in_array($option, $ruleOptions)){
                $inputValidator->selectedRules[$ruleArray['input_name']] = $ruleArray['rule'];
            }
        }

    }

    public function validate($data){
        $inputValidator = $this;
        return Validator::make($data, $inputValidator->selectedRules)->validate();
    }
}
