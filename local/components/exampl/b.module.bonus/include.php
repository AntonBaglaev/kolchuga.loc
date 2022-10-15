<?php

//Загрузка классов
CModule::AddAutoloadClasses(
    'bonus.program',
    [
        'Bonus\Program\BonusChecker' => 'lib/BonusChecker.php',
    ]
);

?>
