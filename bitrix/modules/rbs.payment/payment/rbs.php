<?php

/**
 * Подключение файла настроек
 */
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/rbs.payment/config.php");

/**
 * RBS
 *
 * Интеграция платежного шлюза RBS с CMS интернет-магазинов
 *
 * @author RBS
 * @version 1.0
 */
class RBS
{
    /**
     * АДРЕС ТЕСТОВОГО ШЛЮЗА
     *
     * @var string
     */
    const test_url = TEST_URL;
 
    /**
     * АДРЕС БОЕВОГО ШЛЮЗА
     *
     * @var string
     */
    const prod_url = PROD_URL;
 
    /**
     * ЛОГ ФАЙЛ
     *
     * Имя файла, который содержит лог запросов к ПШ
     *
     * @var boolean
     */
    const log_file = LOG_FILE;
 
    /**
     * ЛОГИН МЕРЧАНТА
     *
     * @var string
     */
    private $user_name;
 
    /**
     * ПАРОЛЬ МЕРЧАНТА
     *
     * @var string
     */
    private $password;
 
    /**
     * ДВУХСТАДИЙНЫЙ ПЛАТЕЖ
     *
     * Если значение true - будет производиться двухстадийный платеж
     *
     * @var boolean
     */
    private $two_stage;
 
    /**
     * ТЕСТОВЫЙ РЕЖИМ
     *
     * Если значение true - плагин будет работать в тестовом режиме
     *
     * @var boolean
     */
    private $test_mode;
 
    /**
     * ЛОГИРОВАНИЕ
     *
     * Если значение true - плагин будет логировать запросы в ПШ
     *
     * @var boolean
     */
    private $logging;
 
    /**
     * КОНСТРУКТОР КЛАССА
     *
     * Заполнение свойств объекта
     *
     * @param string $user_name логин мерчанта
     * @param string $password пароль мерчанта
     * @param boolean $logging логирование
     * @param boolean $two_stage двухстадийный платеж
     * @param boolean $test_mode тестовый режим
     */
    public function RBS($user_name, $password, $two_stage, $test_mode, $logging)
    {
        $this->user_name = $user_name;
        $this->password = $password;
        $this->two_stage = $two_stage;
        $this->test_mode = $test_mode;
        $this->logging = $logging;
    }
 
    /**
     * ЗАПРОС В ПШ
     *
     * Формирование запроса в платежный шлюз и парсинг JSON-ответа
     *
     * @param string $method метод запроса в ПШ
     * @param mixed[] $data данные в запросе
     * @param string $url адрес ПШ
     * @return mixed[]
     */
    private function gateway($method, $data)
    {
        $data['userName'] = $this->user_name;
        $data['password'] = $this->password;
        if ($this->test_mode) {
            $url = self::test_url;
        } else {
            $url = self::prod_url;
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url.$method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array('CMS: Bitrix', 'Module-Version: '.VERSION)
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        if ($this->logging) {
            $this->logger($url, $method, $data, $response);
        }
        curl_close($curl);
        return $response;
    }
 
    /**
     * ЛОГГЕР
     *
     * Логирование запроса и ответа от ПШ
     *
     * @param string $url
     * @param string $method
     * @param mixed[] $data
     * @param mixed[] $response
     * @return integer
     */
    private function logger($url, $method, $data, $response)
    {
		return error_log('RBS PAYMENT '.$url.$method.' REQUEST: '.json_encode($data). ' RESPONSE: '.json_encode($response));
    }
 
    /**
     * РЕГИСТРАЦИЯ ЗАКАЗА
     *
     * Метод register.do или registerPreAuth.do
     *
     * @param string $order_number номер заказа в магазине
     * @param integer $amount сумма заказа
     * @param string $return_url страница, на которую необходимо вернуть пользователя
     * @return mixed[]
     */
    function register_order($order_number, $amount, $return_url)
    {
        $data = array(
            'orderNumber' => $order_number,
            'amount' => $amount,
            'returnUrl' => $return_url
        );
        if ($this->two_stage) { $method = 'registerPreAuth.do'; } else { $method = 'register.do'; }
        $response = $this->gateway($method, $data);
        return $response;
    }
 
    /**
     * СТАТУС ЗАКАЗА ПО ORDER ID
     *
     * Метод getOrderStatusExtended.do
     *
     * @param string $order_number номер заказа в магазине
     * @return mixed[]
     */
    public function get_order_status_by_orderId($orderId)
    {
        $data = array('orderId' => $orderId);
        $response = $this->gateway('getOrderStatusExtended.do', $data);
        return $response;
    }
 
    /**
     * СТАТУС ЗАКАЗА ПО ORDER NUMBER
     *
     * Метод getOrderStatusExtended.do
     *
     * @param string $order_number номер заказа в магазине
     * @return mixed[]
     */
    public function get_order_status_by_orderNumber($order_number)
    {
        $data = array('orderNumber' => $order_number);
        $response = $this->gateway('getOrderStatusExtended.do', $data);
        return $response;
    }
}