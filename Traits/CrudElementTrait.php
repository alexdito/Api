<?php
namespace App\Controllers\Api\V2\Traits;

trait CrudElementTrait
{
    /**
     * @param $dataFields
     * @param $dataProperties
     * @return mixed
     */
    protected function create($dataFields, $dataProperties)
    {
        if(\CModule::IncludeModule("iblock")) {

            $element = new \CIBlockElement;

            $dataFields['PROPERTY_VALUES'] = $dataProperties;
            AddMessage2Log($dataFields, "Добавление " . __CLASS__);

            if($id = $element->Add($dataFields)) {
                header('Status: 201 Create');
                $result['success'] = ['success' => true, 'id' => $id];
            } else {
                header('Status: 400 Bad Request');
                $result['errors'][] = $element->LAST_ERROR;
            }
        } else {
            header('Status: 400 Bad Request');
            $result['errors'][] = 'Модуль инфоблоки не установлен';
        }
        
        return $result;
    }

    /**
     * @param $dataFields
     * @param $dataProperties
     * @return mixed
     */
    protected function update($dataFields, $dataProperties)
    {
        if(\CModule::IncludeModule("iblock")) {
            AddMessage2Log($dataProperties, "Обновление свойств " . __CLASS__);

            \CIBlockElement::SetPropertyValuesEx($dataFields['ID'], $this->IBlockId, $dataProperties);

            $element = new \CIBlockElement;
            AddMessage2Log($dataFields, "Обновление полей " . __CLASS__);

            if(!$element->Update($dataFields['ID'], $dataFields)) {
                header('Status: 400 Bad Request');
                $result['errors'][] = "Элемент с id: " . $dataFields['ID'] . " не существует";
            } else {
                header('Status: 204 No Content');
                $result['success'] = ['success' => true, 'id' => $dataFields['ID']];
            }
        } else {
            header('Status: 400 Bad Request');
            $result['errors'][] = 'Модуль инфоблоки не установлен';
        }

        return $result;
    }
}