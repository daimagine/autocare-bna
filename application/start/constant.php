<?php

//account type debit and credit
define('AUTOCARE_ACCOUNT_TYPE_DEBIT', 'D');
define('AUTOCARE_ACCOUNT_TYPE_CREDIT', 'C');

abstract class approvedStatus {
    const NEW_ACCOUNT_INVOICE = 'N',
        CONFIRM_BY_WAREHOUSE = 'W';
}

abstract class accountTransactionStatus {
    const AWAITING_PAYMENT = 'O',
        DONE_PAYMENT = 'C';
}