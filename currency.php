<?
\Bitrix\Main\Loader::includeModule('currency');

/**
 * Типы валют на сайте
 * @return array KEY => NAME
 */
\Bitrix\Currency\CurrencyManager::getCurrencyList();

/**
 * Проверка на существование валюты
 * @return bool
 */
\Bitrix\Currency\CurrencyManager::isCurrencyExist('USD');

/**
 * Чистка кеша по указанной валюте
 */
\Bitrix\Currency\CurrencyManager::clearTagCache('USD');

/**
 * Чистка кеша валют по языковой привязке сайта
 */
\Bitrix\Currency\CurrencyManager::clearCurrencyCache(LANGUAGE_ID);

/**
 * Идентификатор базовой валюты
 * @return string
 */
\Bitrix\Currency\CurrencyManager::getBaseCurrency();

/**
 * Установка базовой валюты
 */
\Bitrix\Currency\CurrencyManager::updateBaseCurrency('RUB');

/**
 * Добавление новой валюты
 */
$result = \Bitrix\Currency\CurrencyTable::add([
    'fields' => [
        'CURRENCY' => 'BLL',
        'AMOUNT_CNT' => 2,
        'AMOUNT' => 666,
        'SORT' => 500,
        'DATE_UPDATE' => \Bitrix\Main\Type\DateTime::createFromUserTime(date('d.m.Y H:i:s')),
        'NUMCODE' => 666,
        'BASE' => 'N',
        'DATE_CREATE' => \Bitrix\Main\Type\DateTime::createFromUserTime(date('d.m.Y H:i:s')),
        'CURRENT_BASE_RATE' => 3,
        'CREATED_BY' => 1,
        'MODIFIED_BY' => 1,
        'LANG' => 'ru',
    ],
	'auth_context' => \Bitrix\Main\Authentication\Context::class
]);

if($result->isSuccess())
    $result_id = $result->getId();

/**
 * Вывод валют
 * @return array
 */
\Bitrix\Currency\CurrencyTable::getList(
    [
        'order' => [
            'SORT' => 'ASC',
            'CURRENCY' => 'ASC'
        ],
        'filter' => [
            '!BASE' => 'Y'
        ],
        'select' => [
            'CURRENCY',
            'BASE',
            'AMOUNT',
            'SORT'
        ],
        'cache' => [
            'ttl' => 3600,
            'cache_joins' => true
        ]
    ]
)->fetchAll();

/**
 * Обновление данных по коду валюты
 */
\Bitrix\Currency\CurrencyTable::update(
    'UAH',
    [
        'AMOUNT' => '666',
        'DATE_UPDATE' => date('d.m.Y H:i:s'),
    ]
);

/**
 * Удаление валюты по коду
 */
\Bitrix\Currency\CurrencyTable::delete('UAH');
