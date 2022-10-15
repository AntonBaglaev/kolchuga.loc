# Модуль комментариев

## Использование компонента

Подключается модуль стандартными средствами bitrix:

    $APPLICATION->IncludeComponent(
        "soodwa.comments",
        ".default",
        Array(
            "AUTH" => "N",
            "CACHE" => "Y",
            "CACHE_TIMES" => "36000000",
            "COUNT" => "5",
            "ID_CHAT" => "1",
            "MODERATION" => "Y"
        )
    );

## Параметры компонента

> AUTH

Параметр отвечает: может ли не зарегистрированный пользователь оставить комментарий (Y/N)

> CACHE

Параметр отвечает: включен кеш или нет (Y/N)

> CACHE_TIMES

Параметр отвечае: сколько времени кешировать (int)

> COUNT

Параметр отвечает: какое колличество комментариев будет показанно на 1 странице (int)
 
> ID_CHAT

Параметр отвечает: ИД чата (string)

> MODERATION

Параметр отвечает: включена ли модерация (Y/N)


## API

### Добовление элемента

> \Soobwa\Comments\Api::addElement($arParams)

Параметры функции:

    @arParams - принимает массив с параметрами комментария
    
Пример массива:

    $arParams = array(
        'ID_CHAT' => 1,
        'ACTIVE' => false,
        'ID_USER' => 1,
        'DATA' => 1483549003,
        'TEXT' => 'test',
        'DELETE' => false,
    );
    
### Колличество элементов в таблице

> \Soobwa\Comments\Api::getCount($filter = array(), $order = array('ID'=>'ASC'), $limit = 0, $offset = 0)

Параметры функции:

    @param array $filter - параметры фильтра
    @param array $order - параметры сортировки
    @param array $limit - лимит
    @param array $offset - смещение
    
Возвращает:
    
    @return int - колличество строк в выборке
    
### Обновление элемента

> \Soobwa\Comments\Api::getCount($id, $arParams)

Параметры функции:

    @param int $id - id сообщения
    @param array $arParams - массив с тем что нужно изменить
    
    
### Удаление элемента

> \Soobwa\Comments\Api::delElement($arParams)

Параметры функции:

    @param int $arParams - id записи которую нужно удалить
   
### Возврашает список элементов в таблице

> \Soobwa\Comments\Api::delElement($select = array(), $filter = array(), $order = array('ID'=>'ASC'), $limit = 0, $offset = 0)
    
  
Параметры функции:

    @param array $filter - параметры фильтра
    @param array $order - параметры сортировки
    @param array $limit - лимит
    @param array $offset - смещение
    
Возвращает:

    @return array() - выборка
    
### Изменить статус удаленно для сообщения

> \Soobwa\Comments\Api::statusDel($id, $valParams)

Параметры функции:
    
    @param int $id - ид комментария
    @param bool $valParams - параметры (true/false)

### Изменить статус активности для сообщения

> \Soobwa\Comments\Api::statusActive($id, $valParams)

Параметры функции:

    @param int $id - ид комментария
    @param bool $valParams - параметры (true/false)