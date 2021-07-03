<?php

namespace App\Services;

use App\Traits\ConsumeExternalTrait;

class CompanyService
{
    use ConsumeExternalTrait;

    protected $token;
    protected $url;

    public function __construct()
    {
        $this->token = config('services.micro-01.token');
        $this->url = config('services.micro-01.url');
    }

    public function getCompany(string $company) {
        return $this->request('get', "/companies/{$company}");
    }
}
