<?php

require_once '../../vendor/autoload.php';

use SbWereWolf\XmlNavigator\Convertation\FastXmlToArray;
use SbWereWolf\XmlNavigator\Parsing\FastXmlParser;

    function generateFile(string $filename, int $limit, string $xml): void
    {
        $file = fopen($filename, 'a');
        fwrite($file, '<Collection>');

        for ($i = 0; $i < $limit; $i++) {
            $content = "$xml$xml$xml$xml$xml$xml$xml$xml$xml$xml";
            fwrite($file, $content);
        }

        fwrite($file, '</Collection>');
        fclose($file);

        $size = round(filesize($filename) / 1024, 2);
        echo "$filename size is $size Kb" . PHP_EOL;
    }


$xml = '<SomeElement key="123">value</SomeElement>' . PHP_EOL;
$generation['temp-465b.xml'] = 1;
//$generation['temp-429Kb.xml'] = 1_000;
//$generation['temp-429Mb.xml'] = 1_000_000;

//foreach ($generation as $filename => $size) {
//    generateFile($filename, $size, $xml);
//}

function parseFirstElement(string $filename): void
{
    $start = hrtime(true);

    /** @var XMLReader $reader */
    $reader = XMLReader::open($filename);
    $mayRead = true;
    while ($mayRead && $reader->name !== 'SomeElement') {
        $mayRead = $reader->read();
    }

    $elementsCollection =
        SbWereWolf\XmlNavigator\FastXmlToArray::extractElements(
            $reader,
            SbWereWolf\XmlNavigator\FastXmlToArray::VAL,
            SbWereWolf\XmlNavigator\FastXmlToArray::ATTR,
        );
    $result =
        SbWereWolf\XmlNavigator\FastXmlToArray
            ::composePrettyPrintByXmlElements(
                $elementsCollection,
            );

    $finish = hrtime(true);
    $duration = $finish - $start;
    $duration = number_format($duration,);
    echo 'First element parsing duration of' .
        " $filename is $duration ns" .
        PHP_EOL;
    echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;

    $reader->close();
}

$files = [
    'temp-465b.xml',
//    'temp-429Kb.xml',
//    'temp-429Mb.xml',
];

echo 'Warm up OPcache' . PHP_EOL;
parseFirstElement(current($files));

echo 'Benchmark is starting' . PHP_EOL;
foreach ($files as $filename) {
    parseFirstElement($filename);
}
echo 'Benchmark was finished' . PHP_EOL;


$reader = XMLReader::XML($xml);
$mayRead = true;
while ($mayRead && $reader->name !== 'CARPLACE') {
    $mayRead = $reader->read();
}

while ($mayRead && $reader->name === 'CARPLACE') {
    $elementsCollection = FastXmlToArray::extractElements(
        $reader,
    );
    $result = FastXmlToArray::createTheHierarchyOfElements(
        $elementsCollection,
    );
    echo json_encode([$result], JSON_PRETTY_PRINT);

    while (
        $mayRead &&
        $reader->nodeType !== XMLReader::ELEMENT
    ) {
        $mayRead = $reader->read();
    }
}

$elementsCollection = FastXmlToArray::extractElements(
    $reader,
);

$result = FastXmlToArray::createTheHierarchyOfElements(
    $elementsCollection,
);