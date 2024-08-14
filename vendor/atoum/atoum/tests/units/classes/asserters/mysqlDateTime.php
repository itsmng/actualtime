<?php

namespace atoum\atoum\tests\units\asserters;

use atoum\atoum;

require_once __DIR__ . '/../../runner.php';

class mysqlDateTime extends atoum\test
{
    public function testClass()
    {
        $this->testedClass->isSubclassOf(atoum\asserters\dateTime::class);
    }

    public function testSetWith()
    {
        $this
            ->given($asserter = $this->newTestedInstance)

            ->if(
                $asserter
                    ->setLocale($locale = new \mock\atoum\atoum\locale())
                    ->setAnalyzer($analyzer = new \mock\atoum\atoum\tools\variable\analyzer()),
                $this->calling($locale)->_ = $notMysqlDateTime = uniqid(),
                $this->calling($analyzer)->getTypeOf = $type = uniqid()
            )
            ->then
                ->exception(function () use ($asserter, & $value) {
                    $asserter->setWith($value = uniqid());
                })
                    ->isInstanceOf(atoum\asserter\exception::class)
                    ->hasMessage($notMysqlDateTime)
                ->mock($locale)->call('_')->withArguments('%s is not in format Y-m-d H:i:s', $type)->once
                ->mock($analyzer)->call('getTypeOf')->withArguments($value)->once
                ->string($asserter->getValue())->isEqualTo($value)

            ->object($asserter->setWith($value = '1976-10-06 14:05:54'))->isIdenticalTo($asserter)
            ->string($asserter->getValue())->isIdenticalTo($value)
            ->object($asserter->setWith($value = uniqid(), false))->isIdenticalTo($asserter)
            ->string($asserter->getValue())->isEqualTo($value)
        ;
    }
}
