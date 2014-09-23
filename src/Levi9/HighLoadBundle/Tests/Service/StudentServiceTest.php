<?php

namespace Levi9\HighLoadBundle\Tests\Service;

use Levi9\HighLoadBundle\Service\StudentService;

class StudentServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return StudentService
     */
    public function getStudentService()
    {
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        return new StudentService($em);
    }

    public function encodeStringProvider()
    {
        return [
            [ 'Test String', 'test_string' ],
            [ 'Test String2', 'test_string2' ],
            [ 'Test @#&^', 'test' ],
            [ 'Test @#&^55', 'test_55' ],
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     *
     * @dataProvider encodeStringProvider
     */
    public function testEncodeString($str, $expected)
    {
        $studentService = $this->getStudentService();
        $actual = $studentService->encodeString($str);
        $this->assertEquals($expected, $actual);
    }

    public function getUniquePathProvider()
    {
        return [
            [ 'test', 'test' ],
            [ 'test', 'test_1' ],
            [ 'abcd', 'abcd' ],
            [ 'test', 'test_2' ],
            [ 'yyyy', 'yyyy' ],
            [ 'test', 'test_3' ],
            [ 'abcd', 'abcd_1' ],
            [ 'xxxx', 'xxxx' ],
        ];
    }

    public function testGetUniquePath()
    {
        $studentService = $this->getStudentService();

        foreach ($this->getUniquePathProvider() as list($input, $expected)) {
            $this->assertEquals($expected, $studentService->getUniquePath($input));
        }
    }
}
