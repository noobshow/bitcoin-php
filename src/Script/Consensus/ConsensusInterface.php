<?php

namespace BitWasp\Bitcoin\Script\Consensus;

use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Script\ScriptWitnessInterface;
use BitWasp\Bitcoin\Transaction\TransactionInterface;

interface ConsensusInterface
{
    /**
     * @param TransactionInterface $tx
     * @param ScriptInterface $scriptPubKey
     * @param integer $nInputToSign
     * @param int $flags
     * @param integer $amount
     * @param ScriptWitnessInterface $witness
     * @return bool
     */
    public function verify(TransactionInterface $tx, ScriptInterface $scriptPubKey, $flags, $nInputToSign, $amount, ScriptWitnessInterface $witness = null);
}
