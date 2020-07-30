<?php
namespace App\Controllers\Api\V2\Traits;

trait ApiPreparePropertiesTrait
{
    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function preparePointProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if (isset($request[$field]['lat']) && isset($request[$field]['lon']) && !empty($request[$field]['lat']) && !empty($request[$field]['lon'])) {
                $dataProperties[$code] = $request[$field]['lat'] . "," . $request[$field]['lon'];
            }
        }
        
        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareTextProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if (!empty($request[$field]) && isset($request[$field])) {
                $dataProperties[$code] = trim(htmlspecialchars($request[$field]));
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareFileProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if (is_array($request[$field])) {
                foreach ($request[$field] as $value) {
                    if(isset($value) && !empty($value)) {
                        $dataProperties[$code][] = \CFile::MakeFileArray($value);
                    }
                }
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareDirProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if (!empty($request[$field]) && isset($request[$field])) {
                $dataProperties[$code]['VALUE'] = trim(htmlspecialchars($request[$field]));
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareAgeProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if ((isset($request[$field]['Y']) && !empty($request[$field]['Y'])) || (isset($request[$field]['M']) && !empty($request[$field]['M']))) {
                $year = $request[$field]['Y'] > 0 ? $request[$field]['Y'] : 0;
                $month = $request[$field]['M'] > 0 ? $request[$field]['M'] : 0;
                $dataProperties[$code]['VALUE'] = ['Y' => $year, 'M' => $month];
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareBindProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if($request[$field] > 0) {
                $dataProperties[$code] = $request[$field];
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareCustomCheckbox(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if(!empty($request[$field]) || isset($request[$field]) || !is_null($request[$field])) {
                $dataProperties[$code] = $request[$field];
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareIntProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if(isset($request[$field]) && ! empty($request[$field])) {
                if(is_numeric($request[$field])) {
                    $dataProperties[$code] = $request[$field];
                }
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareDateProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if (!is_null($request[$field]) || !empty($request[$field]) || \ConvertTimeStamp($request[$field], 'FULL')) {
                $dataProperties[$code] = \ConvertTimeStamp($request[$field], 'FULL');
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareAccessInstruction(array $prepareProperties, array $request, $dataProperties)
    {
        foreach($prepareProperties as $code => $field) {
            if(!empty($request[$field]['text']) && isset($request[$field]['text'])) {
                $dataProperties[$code]['VALUE'] = [
                    'TYPE' => $request[$field]['type'],
                    'TEXT' => $request[$field]['text']
                ];
            }
        }

        return $dataProperties;
    }

    /**
     * @param array $prepareProperties
     * @param array $request
     * @param $dataProperties
     * @return mixed
     */
    protected function prepareListProperties(array $prepareProperties, array $request, $dataProperties)
    {
        foreach ($prepareProperties as $code => $field) {
            if(is_array($request[$field])) {
                $dataProperties[$code] = $request[$field];
            }
        }

        return $dataProperties;
    }
}