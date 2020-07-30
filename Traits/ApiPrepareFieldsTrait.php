<?php
namespace App\Controllers\Api\V2\Traits;

trait ApiPrepareFieldsTrait
{
    /**
     * @param array $prepareTextFields
     * @param array $request
     * @param array $dataFields
     * @return array
     */
    protected function prepareTextFields(array $prepareTextFields, array $request, array $dataFields)
    {
        foreach ($prepareTextFields as $code => $field) {
            if (!empty($request[$field]) && isset($request[$field])) {
                if($field === 'code') {
                    $dataFields[$code] = str_replace(' ', '_', $request[$field]);
                } else {
                    $dataFields[$code] = trim(htmlspecialchars($request[$field]));
                }
            }
        }

        return $dataFields;
    }

    /**
     * @param array $prepareFileFields
     * @param array $request
     * @param array $dataFields
     * @return array
     */
    protected function prepareFileFields(array $prepareFileFields, array $request, array $dataFields)
    {
        foreach ($prepareFileFields as $code => $field) {
            if (!empty($request[$field]) && isset($request[$field])) {
                $dataFields[$code] = \CFile::MakeFileArray($request[$field]);
            }
        }

        return $dataFields;
    }

    /**
     * @param array $prepareDateFields
     * @param array $request
     * @param array $dataFields
     * @return array
     */
    protected function prepareDateFields(array $prepareDateFields, array $request, array $dataFields)
    {
        foreach ($prepareDateFields as $code => $field) {
            if (!is_null($request[$field]) || !empty($request[$field]) || \ConvertTimeStamp($request[$field], 'FULL')) {
                $dataFields[$code] = \ConvertTimeStamp($request[$field], 'FULL');
            }
        }

        return $dataFields;
    }
}