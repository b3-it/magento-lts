<?php
/**
 * Created by PhpStorm.
 * User: Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * Date: 12.02.2019
 *
 */

use PHPUnit\Framework\TestCase;

final class Egovs_Paymentbase_Model_GirosolutionTest extends TestCase
{
    public function __construct(?string $name = NULL, array $data = [], string $dataName = '') {
        require_once dirname(__DIR__, 7) . DIRECTORY_SEPARATOR . 'Mage.php';
        $this->assertInstanceOf(Mage_Core_Model_App::class,
            Mage::app('admin', 'store'),
            'Magento DB not available'
        );
        $this->_factory = new Mage_Core_Model_Factory();

        parent::__construct($name, $data, $dataName);
    }

    public function testModifyOrderAfterPaymentSuccessPayment() {
        $mockForPayment = $this->getMockBuilder(Mage_Sales_Model_Order_Payment::class)
            ->setMethods(array('getKassenzeichen'))
            ->getMock()
            ;
        $mockForPayment->method('getKassenzeichen')
            ->willReturn('123456789')
            ;

        $mockForOrder = $this->getMockBuilder(Mage_Sales_Model_Order::class)
            ->setConstructorArgs(array(array('id' => 65532, 'state' => Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW)))
            ->setMethods(array('save', 'canInvoice', 'setState', 'getState', 'getPayment', 'getIdFieldName'))
            ->getMock()
        ;

        $mockForOrder->method('getIdFieldName')
            ->willReturn('id');

        $mockForOrder->expects($this->atLeast(2))
            ->method('save')
            ->willReturnSelf()
        ;
        $mockForOrder->expects($this->any())
            ->method('canInvoice')
            ->willReturn(false)
        ;
        $mockForOrder->expects($this->any())
            ->method('setState')
            ->willReturnSelf()
        ;

        $mockForOrder->method('getPayment')
            ->willReturn($mockForPayment)
            ;


        $mockForGirosolution = $this->getMockBuilder(Egovs_Paymentbase_Model_Girosolution::class)
            ->setMethods(array('_getOrder'))
            ->getMockForAbstractClass()
        ;

        $mockForGirosolution->expects($this->any())
            ->method('_getOrder')
            ->willReturn($mockForOrder);

        $paymentMethod = $mockForGirosolution;
        $result = $paymentMethod->modifyOrderAfterPayment(
            true,
            'test1234',
            true,
            'Test',
            //TODO implement test case
            false,
            true,
            'Test Invoice',
            'test1234gc',
            array()
            );
        $this->assertTrue($result, 'Payment not successful');
    }
}
