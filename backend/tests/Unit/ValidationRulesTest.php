<?php

namespace Tests\Unit;

use App\Rules\ValidCnpj;
use App\Rules\ValidCpf;

it('should return true for a valid CPF', function () {
    $rule = new ValidCpf();
    expect($rule->passes('attribute', '11144477735'))->toBeTrue();
});

it('should return false for an invalid CPF', function () {
    $rule = new ValidCpf();
    expect($rule->passes('attribute', '11144477736'))->toBeFalse();
});

it('should return false for a CPF with all same digits', function () {
    $rule = new ValidCpf();
    expect($rule->passes('attribute', '11111111111'))->toBeFalse();
});

it('should return false for a CPF with incorrect length', function () {
    $rule = new ValidCpf();
    expect($rule->passes('attribute', '12345'))->toBeFalse();
});


it('should return true for a valid CNPJ', function () {
    $rule = new ValidCnpj();
    expect($rule->passes('attribute', '24706035000109'))->toBeTrue();
});

it('should return false for an invalid CNPJ', function () {
    $rule = new ValidCnpj();
    expect($rule->passes('attribute', '33406775000108'))->toBeFalse();
});

it('should return false for a CNPJ with incorrect length', function () {
    $rule = new ValidCnpj();
    expect($rule->passes('attribute', '12345'))->toBeFalse();
});
