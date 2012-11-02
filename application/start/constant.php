<?php

//account type debit and credit
define('AUTOCARE_ACCOUNT_TYPE_DEBIT', 'D');
define('AUTOCARE_ACCOUNT_TYPE_CREDIT', 'C');
//constant variable name session
define('ACCOUNT_TRX_ID', 'accountTrxId');
abstract class approvedStatus {
    const NEW_ACCOUNT_INVOICE = 'O',
        REVIEW_BY_WAREHOUSE = 'R',
        CONFIRM_BY_WAREHOUSE = 'C';
}

abstract class accountTrxStatus {
    const AWAITING_PAYMENT = '1',
        DONE_PAYMENT = '0';
}

abstract class itemStockFlowStatus {
    const ADD_TO_LIST = 'O',
        CONFIRM_ADDITIONAL = 'C',
        CANCEL = 'D';
}

abstract class statusType {
    const ACTIVE ='1',
        INACTIVE ='0';
}

abstract class statusWorkOrder {
    const OPEN ='O',
        CLOSE ='D',
        CANCELED='C';
}


abstract class paymentType {
    const CASH ='C',
        EDC ='E',
        MONTHLY ='M',
        CORPORATE = 'O';
}

abstract class paymentState {
    const INITIATE = 'I',
        CANCELED = 'C',
        DONE = 'D';
}

abstract class SettlementState {
    const   UNSETTLED = 'U',
            SETTLED = 'S',
            SETTLED_MATCH = 'M',
            SETTLED_UNMATCH = 'F'
    ;
}

abstract class batchStatus {
    const UNSETTLED ='1',
        SETTLED ='0';
}

abstract class AccountCategory {
    const   ITEM = 'I',
            ACCOUNTING = 'A'
    ;
}