<?php
namespace App\Controllers\Api\V2\Traits;

trait CrudSectionTrait
{
    /**
     * @param $dataFields
     * @param $dataProperties
     * @return mixed
     */
    protected function create($dataFields, $dataProperties = [])
    {
        if(\CModule::IncludeModule("iblock")) {
            $element = new \CIBlockSection;
            AddMessage2Log($dataFields, "Добавление " . __CLASS__);

            $id = $element->Add($dataFields);

            if($id > 0) {
                header('Status: 201 Create');
                $result['success'] = ['success' => true, 'id' => $id, 'iBlockSectionId' => $dataFields['IBLOCK_SECTION_ID']];
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
    protected function update($dataFields, $dataProperties = [])
    {
        if(\CModule::IncludeModule("iblock")) {
            $element = new \CIBlockSection;
            AddMessage2Log($dataFields, "Обновление " . __CLASS__);

            $res = $element->Update($dataFields['ID'], $dataFields);

            if(!$res) {
                header('Status: 400 Bad Request');
                $result['errors'][] = "Раздела с id: " . $dataFields['ID'] . " не существует";
            } else {
                header('Status: 204 No Content');
                $result['success'] = ['success' => true, 'id' => $dataFields['id']];
            }
        } else {
            header('Status: 400 Bad Request');
            $result['errors'][] = 'Модуль инфоблоки не установлен';
        }

        return $result;
    }
}