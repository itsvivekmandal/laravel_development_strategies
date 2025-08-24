<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;

class UserService extends BaseService {
    // protected $logger;

    // public function __construct($logger){
    //     $this->logger = $logger;
    // }

    public function test(array $data): ?array {
        $this->logger->emergency('User service log.', $data);
        $this->test2();
        return $data;
    }

    private function test2() {
        throw new \Exception('exception test');
    }
}

