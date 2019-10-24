<?php

namespace DoubleDeuce\Data;

class BankAccount
{
    public $bank;
    public $agency;
    public $account;
    public $digit;

    public function __construct(
        int $bank,
        int $agency,
        int $account,
        string $digit
    ) {
        $this->bank = $bank;
        $this->agency = $agency;
        $this->account = $account;
        $this->digit = $digit;
    }
}
