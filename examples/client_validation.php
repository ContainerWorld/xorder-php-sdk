<?php 

require '../vendor/autoload.php';

try {

    $xorder = new XOrder\XOrder('xorder.xml', true);
    $credentials = new XOrder\Credentials('bridgeb', 'brg75brw', '190566');

    $validator = new XOrder\XOrderValidator($xorder);
    $valid = $validator->validate();

}

catch (XOrder\Exceptions\XOrderValidationException $e) {
    var_dump($e->getErrors());
}

var_dump($valid);
