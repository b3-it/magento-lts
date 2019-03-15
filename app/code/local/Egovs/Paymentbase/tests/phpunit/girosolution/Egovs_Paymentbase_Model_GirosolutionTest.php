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
    protected $mockForOrder;
    protected $mockForPayment;
    protected $mockForGirosolution;

    public function __construct(?string $name = NULL, array $data = [], string $dataName = '') {
        require_once dirname(__DIR__, 7) . DIRECTORY_SEPARATOR . 'Mage.php';
        $this->assertInstanceOf(Mage_Core_Model_App::class,
            Mage::app('admin', 'store'),
            'Magento DB not available'
        );
        $this->_factory = new Mage_Core_Model_Factory();

        parent::__construct($name, $data, $dataName);
    }

    /**
     * @param $bkz string Kassenzeichen
     *
     * @return Egovs_Paymentbase_Model_Girosolution $paymentMethod
     * @throws \ReflectionException
     */
    protected function _initMocks($bkz) {
        $this->mockForPayment = $this->getMockBuilder(Mage_Sales_Model_Order_Payment::class)
            ->setMethods(array('getKassenzeichen', 'addTransaction', 'hasKassenzeichen'))
            ->getMock()
        ;
        $this->mockForPayment->method('getKassenzeichen')
            ->willReturn($bkz)
        ;

        $this->mockForPayment->method('hasKassenzeichen')
            ->willReturn(true)
        ;

        $mockForTransaction = $this->getMockBuilder(Mage_Sales_Model_Order_Payment_Transaction::class)
            ->setMethods(array('save', 'setParentTxnId'))
            ->getMock()
        ;
        $mockForTransaction->expects($this->any())
            ->method('save')
            ->willReturnSelf()
        ;

        $this->mockForPayment->method('addTransaction')
            ->willReturn($mockForTransaction)
        ;

        $this->_initMockForOrder();

        $this->mockForGirosolution = $this->getMockBuilder(Egovs_Paymentbase_Model_Girosolution::class)
            ->setMethods(array('_getOrder', '_getQuote', '_activateKassenzeichen'))
            ->getMockForAbstractClass()
        ;

        $this->mockForGirosolution->expects($this->any())
            ->method('_getOrder')
            ->willReturn($this->mockForOrder)
        ;

        $this->mockForGirosolution->expects($this->any())
            ->method('_activateKassenzeichen')
            ->willReturn(true)
        ;

        $mockForQuote = $this->getMockBuilder(Mage_Sales_Model_Quote::class)
            ->setMethods(array('save'))
            ->getMock()
        ;
        $mockForQuote->expects($this->any())
            ->method('save')
            ->willReturnSelf()
        ;
        $this->mockForGirosolution->expects($this->any())
            ->method('_getQuote')
            ->willReturn($mockForQuote)
        ;

        return $this->mockForGirosolution;
    }

    public function _initMockForOrder() {
        $this->mockForOrder = $this->getMockBuilder(Mage_Sales_Model_Order::class)
            ->setConstructorArgs(array(array('id' => 65532, 'state' => Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW)))
            ->setMethods(array('save', 'canInvoice', 'getPayment', 'getIdFieldName', 'getResource'))
            ->getMock()
        ;

        $this->mockForOrder->method('getIdFieldName')
            ->willReturn('id');

        $this->mockForOrder->expects($this->any())
            ->method('canInvoice')
            ->willReturn(false)
        ;

        $mockForOrderResource = $this->getMockBuilder(Mage_Sales_Model_Resource_Order::class)
            ->setMethods(array('saveAttribute'))
            ->getMock()
        ;

        $this->mockForOrder->expects($this->any())
            ->method('getResource')
            ->willReturn($mockForOrderResource)
        ;

        $this->mockForOrder->method('getPayment')
            ->willReturn($this->mockForPayment)
        ;

        return $this->mockForOrder;
    }

    public function testModifyOrderAfterPaymentUnequalBkz() {
        $paymentMethod = $this->_initMocks('123456789');
        $this->mockForOrder->expects($this->never())
            ->method('save')
            ->willReturnSelf()
        ;

        $result = $paymentMethod->modifyOrderAfterPayment(
            true,
            'test1234',
            true,
            'Test',
            false,
            true,
            'Test Invoice',
            'test1234gc',
            array()
        );
        $this->assertFalse($result, 'BKZ are equal');
    }

    public function testModifyOrderAfterPaymentSuccessPayment() {
        $paymentMethod = $this->_initMocks('123456789');

        $this->mockForOrder->expects($this->any())
            ->method('save')
            ->willReturnSelf()
        ;

        $result = $paymentMethod->modifyOrderAfterPayment(
            true,
            'test/123456789',
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
