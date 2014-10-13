<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Framework\Search\Adapter\Mysql\Aggregation\Builder;

use Magento\TestFramework\Helper\ObjectManager;
use Magento\Framework\Search\Request\BucketInterface as RequestBucketInterface;

class MetricsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Framework\Search\Adapter\Mysql\Aggregation\Builder\Metrics
     */
    private $metrics;

    /**
     * @var RequestBucketInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $requestBucket;

    /**
     * @var \Magento\Framework\Search\Request\Aggregation\Metric|\PHPUnit_Framework_MockObject_MockObject
     */
    private $metric;

    protected function setUp()
    {
        $helper = new ObjectManager($this);

        $this->requestBucket = $this->getMockBuilder('Magento\Framework\Search\Request\BucketInterface')
            ->setMethods(['getMetrics'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->metric = $this->getMockBuilder('Magento\Framework\Search\Request\Aggregation\Metric')
            ->setMethods(['getType'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->metrics = $helper->getObject('Magento\Framework\Search\Adapter\Mysql\Aggregation\Builder\Metrics');
    }

    public function testBuild()
    {
        $expectedResult = ['count' => 'count(main_table.value)'];
        $this->requestBucket->expects($this->once())->method('getMetrics')->willReturn([$this->metric]);
        $this->metric->expects($this->once())->method('getType')->willReturn('count');
        $metrics = $this->metrics->build($this->requestBucket);

        $this->assertEquals($expectedResult, $metrics);
    }
}
