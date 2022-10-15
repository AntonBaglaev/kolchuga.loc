<?php
/**
 * Created by PhpStorm.
 * User: RITG (http://litebox.ru)
 * Date: 02.04.2018
 * Time: 21:27
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Метод компонента реализует основной функционал апи синхронизации
 * Class Sync
 */
class Sync extends CBitrixComponent
{
    /**
     * @var array $defaultUrlTemplates шаблон адреса
     */
    public $defaultUrlTemplates = [
        "template" => "#VERSION#/#METHOD#",
        "image" => "#VERSION#/#METHOD#/#ID#",
        "put" => "#VERSION#/#METHOD#/#ID#/#ACTION#",
    ];

    /**
     * @var array $variables массив параметр => значение из свойства $defaultUrlTemplates404
     */
    public $variables = [];

    /**
     * @var array $componentVariables массив параметр => значение для компонента
     */
    public $componentVariables = [];

    /**
     * @var array $variableAliases алиасы значений
     */
    public $variableAliases = [];

    /**
     * @var array $templatesUrls сформированный массив шаблон адреса
     */
    public $templatesUrls = [];

    /**
     * @var object $request объект запроса
     */
    public $requestQuery;

    /**
     * @var string $componentPage шаблон отрисовки
     */
    public $componentPage;

    /**
     * Иницилизация объектов необходимые для работы
     * @return bool
     * @throws \Bitrix\Main\SystemException
     */
    protected function InitializeComponent()
    {
        $this->setFrameMode(false);

        if (!CModule::IncludeModule('sale')) {
            return false;
        }

        if (!CModule::IncludeModule('catalog')) {
            return false;
        }

        $this->requestQuery = Bitrix\Main\Application::getInstance()->getContext()->getRequest();

        $headers = getallheaders();

        if ($headers && $headers['Content-Type'] && $headers['Content-Type'] == 'image/jpg') {
            $this->arParams["SEF_URL_TEMPLATES"] = 'image';
        }

        $this->templatesUrls = CComponentEngine::makeComponentUrlTemplates($this->defaultUrlTemplates, $this->arParams["SEF_URL_TEMPLATES"]);

        $this->componentPage = CComponentEngine::parseComponentPath(
            $this->arParams["SEF_FOLDER"],
            $this->templatesUrls,
            $this->variables
        );
        CComponentEngine::initComponentVariables($this->componentPage, $this->componentVariables, $this->variableAliases, $this->variables);

        return true;
    }

    /**
     * Иницилизация и выполнение метода api
     * @return mixed
     * @throws ReflectionException
     */
    protected function InitApi()
    {
        $version = new \litebox\kassa\lib\Api\Versions();

        $v = $version->check($this->variables['VERSION']);

        if (isset($v['error'])) {
            return $this->error($v);
        }
        $execMethod = $this->variables['METHOD'];
        $execMethod = ucfirst(strtolower($execMethod));
        $nameSpace = '\\litebox\\kassa\\lib\\Api\\Methods\\' . $v . '\\' . $execMethod;

        try {
            $ref = new ReflectionClass($nameSpace);

            $const = $ref->getConstructor();

            $constParams = $const->getParameters();

            $paramsData = [];

            foreach ($constParams as $param) {
                $paramName = $param->getName();
                $paramsData[] = $this->requestQuery->get($paramName);
            }

            $apiMethod = $ref->newInstanceArgs($paramsData);

            $runExecMethod = '';
            $action = $this->variables['ACTION'];
            if ($action) {
                $action = ucfirst(strtolower($action));
                $runExecMethod .= $action;
            }

            $runExecMethod .= 'execute' . $this->requestQuery->getRequestMethod();

            $parametrs = $this->validateParamApi($nameSpace, $runExecMethod);

            if (isset($parametrs['error'])) {
                return $parametrs;
            }

            if ($this->variables['ID']) {
                $parametrs['id'] = $this->variables['ID'];
            }

            if (is_array($parametrs)) {
                $res = call_user_func_array([$apiMethod, $runExecMethod], $parametrs);
            } else {
                $res = $parametrs;
            }

            return $res;
        } catch (Exception $exception) {
            $error = [
                'error' => 'Method not found'
            ];

            return $this->error($error);
        }
    }

    public function error($error, $codeStatus = 404)
    {
        http_response_code($codeStatus);
        return $error;
    }

    /**
     * Получение необходимых параметров из $_REQUEST и предварительная валидация, Так же валидация на обязательность + валидация на существование метода
     * @param string $nameSpace полный путь к классу
     * @param string $methodName исполняемый метод
     * @return array|string возвращает массив в случае успешной валидации или json строку с обшибкой
     * @throws ReflectionException
     */
    protected function validateParamApi($nameSpace, $methodName = 'execute')
    {
        $parametrs = [];

        $ref = new ReflectionClass($nameSpace);

        if (!$ref->hasMethod($methodName)) {
            return ["error" => "method not found"];
        }

        $method = $ref->getMethod($methodName);
        $params = $method->getParameters();

        foreach ($params as $param) {
            $isHaveDefaultValue = $param->isDefaultValueAvailable();
            $paramName = $param->getName();
            $paramValue = $this->requestQuery->get($paramName);

            if (!$isHaveDefaultValue && !isset($paramValue)) {
                return ['error' => 'parameter ' . $paramName . ' is required'];
            }

            if (!is_null($paramValue)) {
                $paramValue = htmlspecialchars(trim($paramValue));
            }

            $parametrs[$paramName] = $paramValue;
        }

        return $parametrs;
    }

    /**
     * Выполнение компонента, главный метод
     * @return mixed|void
     */
    public function executeComponent()
    {
        $this->InitializeComponent();

        $result = $this->InitApi();

        $this->typesData($result);

        $data = '';

        if (!is_object($result) && isset($result['isjson'])) {
            if (!$result['isjson']) {
                $data = $result['data'];
            }
        } else {
            $data = json_encode($result);
			
			switch (json_last_error()) {
				case JSON_ERROR_NONE:
					header('Content-Type: application/json');
				break;
				case JSON_ERROR_DEPTH:
					echo ' - Достигнута максимальная глубина стека';
				break;
				case JSON_ERROR_STATE_MISMATCH:
					echo ' - Некорректные разряды или не совпадение режимов';
				break;
				case JSON_ERROR_CTRL_CHAR:
					echo ' - Некорректный управляющий символ';
				break;
				case JSON_ERROR_SYNTAX:
					echo ' - Синтаксическая ошибка, не корректный JSON';
				break;
				case JSON_ERROR_UTF8:
					echo ' - Некорректные символы UTF-8, возможно неверная кодировка';
				break;
				default:
					echo ' - Неизвестная ошибка';
				break;
			}
        }

        $this->arResult = array_merge(
            [
                'VARIABLES' => $this->variables,
//                'json' => json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'json' => $data,
            ],
            $this->arResult
        );

        $this->componentPage = 'template';

        $this->includeComponentTemplate($this->componentPage);
    }

    /**
     * Типизация данных
     * @param object $result
     * @return mixed
     * @throws ReflectionException
     */
    public function typesData($result)
    {
        $reflection = new ReflectionObject((object) $result);
        foreach ($reflection as $reflectionData) {
            if (empty($reflectionData)) {
                continue;
            }
            $reflectionClass = new ReflectionClass($reflectionData);

            $propertyClass = $reflectionClass->getProperties();

            foreach ($propertyClass as $propertyObject) {
                $doc = $propertyObject->getDocComment();

                preg_match('/@var\s+([^\s]+)/', $doc, $matches);

                $propertyName = $propertyObject->getName();
                $propertyType = strtolower($matches[1]);

                $this->actionForType($result, $propertyName, $propertyType);
            }
        }

        return $result;
    }

    /**
     * Метод приведения к необходимому типу данных
     * @param object $result
     * @param string $propertyName
     * @param string  $propertyType
     * @throws ReflectionException
     */
    public function actionForType($result, $propertyName, $propertyType)
    {
        if ($propertyName == 'rules') {
            return;
        }
        if ($propertyType == 'integer') {
            $propertyType = 'int';
        }

        $setType = settype($result->$propertyName, $propertyType);

        if ($setType && ($propertyType == 'array' || $propertyType == 'object')) {
            $this->typesObjectOrArray($result->$propertyName);
        }
    }

    /**
     * Типизация объекта или массива
     * @param array|object $collection
     */
    public function typesObjectOrArray($collection)
    {
        foreach ($collection as $key => &$tmpObj) {
            $tmpObj = $this->typesData($tmpObj);
        }
    }
}