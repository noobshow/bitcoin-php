<?php

namespace BitWasp\Bitcoin\Tests\Script\ScriptInfo;

use BitWasp\Bitcoin\Key\PrivateKeyFactory;
use BitWasp\Bitcoin\Key\PublicKeyFactory;
use BitWasp\Bitcoin\Script\Classifier\OutputClassifier;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\ScriptInfo\Multisig;
use BitWasp\Bitcoin\Tests\AbstractTestCase;

class MultisigTest extends AbstractTestCase
{
    public function testMethods()
    {
        $pub = PublicKeyFactory::fromHex('045b81f0017e2091e2edcd5eecf10d5bdd120a5514cb3ee65b8447ec18bfc4575c6d5bf415e54e03b1067934a0f0ba76b01c6b9ab227142ee1d543764b69d901e0');
        $otherpub = $pub->tweakAdd(gmp_init(1));

        $script = ScriptFactory::scriptPubKey()->multisig(2, [$pub, $otherpub]);
        $classifier = new OutputClassifier();
        $this->assertEquals(OutputClassifier::MULTISIG, $classifier->classify($script));

        $info = new Multisig($script);
        $this->assertEquals(2, $info->getRequiredSigCount());
        $this->assertEquals(2, $info->getKeyCount());
        $this->assertTrue($info->checkInvolvesKey($pub));
        $this->assertTrue($info->checkInvolvesKey($otherpub));

        $unrelatedPub = $otherpub->tweakAdd(gmp_init(1));
        $this->assertFalse($info->checkInvolvesKey($unrelatedPub));

    }
}
