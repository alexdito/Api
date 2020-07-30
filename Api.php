<?php
namespace App\Controllers\Api\V2;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;

abstract class Api
{
    use Traits\ApiPrepareFieldsTrait;
    use Traits\ApiPreparePropertiesTrait;
    use Traits\CrudElementTrait;

    protected $IBlockId = 3;                    //ID инфоблока
    protected $method = '';                     //Метод
    protected $dataFields = [];                 //Массив полей
    protected $dataProperties = [];             //Массив свойств
    protected $dataRequest = [];                //Данные запроса к API
    protected $result = [];                     //Массив ответов
    protected $fieldsNeedCheck = [              //Поля, которые нужно обязательно проверить
        'create' =>['name', 'code'],
        'update' =>['id']
    ];

    protected $prepareTextFields = [];         //Поля элемента типа
    protected $prepareFileFields = [];         //Поля типа файл
    protected $prepareDateFields = [];         //Поля типа дата
    protected $prepareTextProperties = [];     //Свойства элемента типа
    protected $prepareDirProperties = [];      //Свойства элемента типа
    protected $prepareFileProperties = [];     //Свойства элемента типа
    protected $preparePointProperties = [];    //Свойства элемента типа
    protected $prepareAgeProperties = [];      //Свойства элемента типа
    protected $prepareBindProperties = [];     //Свойства элемента типа
    protected $prepareCustomCheckbox = [];     //Свойства элемента типа
    protected $prepareIntProperties = [];      //Свойства элемента типа
    protected $prepareDateProperties = [];     //Свойства элемента типа
    protected $prepareAccessInstruction = [];
    protected $prepareListProperties = [];

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        header("Content-type:application/json");

        $this->getResult();

        $response = new Response();
        $response->getBody()->write(json_encode($this->result));
        AddMessage2Log($this->result, "Response " . __CLASS__);

        return $response;
    }

    /**
     * Метод получения результата
     */
    protected function getResult()
    {
        $jsonStr = file_get_contents('php://input');
        $jsonArray = json_decode($jsonStr, true);
        $this->dataRequest = $jsonArray['fields'];
        $this->method = $jsonArray['method'];
        define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/api_log.txt");
        AddMessage2Log($this->dataRequest, __CLASS__);

        $this->dataFields['IBLOCK_ID'] = $this->IBlockId;

        if (isset($this->dataRequest)) {
            if(method_exists(__CLASS__, $this->method)) {
                $this->getFieldsAndProperties();
                //$this->getFieldsAndProperties();
            } else {
                header('Status: 400 Bad Request');
                $this->result['errors'][] = "Неправильное имя метода";
            }
        } else {
            header('Status: 400 Bad Request');
            $this->result['errors'][] = 'Проверьте формат JSON';
        }
    }

    protected function getFieldsAndProperties()
    {
        if($this->checkRequiredFields()) {

            $reflection = new \ReflectionClass(__CLASS__);

            foreach ($reflection->getProperties() as $propertyObj) {
                if ($propertyName = stristr($propertyObj->name, "prepare")) {
                    if (!empty($this->$propertyName)) {

                        if(stristr($propertyName, 'Fields')) {
                            $this->dataFields = $this->$propertyName($this->$propertyName, $this->dataRequest, $this->dataFields);
                        } else {
                            $this->dataProperties = $this->$propertyName($this->$propertyName, $this->dataRequest, $this->dataProperties);
                        }
                    }
                }
            }

            $this->checkSection();
            $method = $this->method;
            $this->result = $this->$method($this->dataFields, $this->dataProperties);
        }
    }
    /**
     * Метод проверки заполнения обязательных полей
     * @return bool
     */
    protected function checkRequiredFields()
    {
        foreach($this->fieldsNeedCheck[$this->method] as $fieldCode) {
            if(empty($this->dataRequest[$fieldCode]) || !isset($this->dataRequest[$fieldCode]) || strtolower($this->dataRequest[$fieldCode]) === 'null') {
                $this->result['errors'][] = "Поле $fieldCode не заполнено";
            }
        }

        if (isset($this->result['errors'])) {
            header('Status: 400 Bad Request');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Метод проверяет наличие раздела, если заполнено поле iBlockSectionId
     * Если раздела не существует отдает корень раздела.
     */
    protected function checkSection()
    {
        if(\CModule::IncludeModule("iblock")) {
            if ($this->dataFields['IBLOCK_SECTION_ID'] > 0) {
                $rsParentSection = \CIBlockSection::GetByID($this->dataFields['IBLOCK_SECTION_ID']);
                if (!$arParentSection = $rsParentSection->GetNext()) {
                    $this->dataFields['IBLOCK_SECTION_ID'] = 0;
                    $this->result['errors'][] = 'Неверный id раздела';
                }
            } else {
                $this->dataFields['IBLOCK_SECTION_ID'] = 0;
            }
        }
    }
}